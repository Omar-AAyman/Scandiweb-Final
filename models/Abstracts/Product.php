<?php


namespace app\Models\Abstracts;

use app\Core\App;
use app\Core\Model;
use app\models\Book;
use app\models\DVD;
use app\models\Furniture;

abstract class Product extends Model
{
    public string $sku = '';
    public string $name = '';
    public string $price = '';
    public string $productType = '';
    public string $size = '';
    public string $height = '';
    public string $width = '';
    public string $length = '';
    public string $weight = '';

    public function table(): string
    {
        return '`products`';
    }
    
    abstract function AddToDB();
    abstract function allRules(): array;

    public static function getProductType($productType)
    {
        if (in_array($productType, ['dvd', 'furniture', 'book'])) {
            $productTypes = [
                "dvd" => new DVD,
                "furniture" => new Furniture,
                "book" => new Book
            ];
            return [
                'status' => true,
                'productObj' => $productTypes[$productType]
            ];
        };
        return [
            'status' => false,
            'message' => 'Please Fill All Inputs!'
        ];
    }

    public function store()
    {
        $table = $this->table();
        $attributes = $this->attributes();
        $qMarks = $this->qMarks();

        $statement = $this->prepare("INSERT INTO $table (" . '`' . implode('`,`', array_keys(array_filter($attributes))) . '`' . ") VALUES (" . implode(',', $qMarks) . ")");
        call_user_func_array(array($statement, 'bind_param'), $this->getRefs());
        if (!$statement == false) {
            $statement->execute();
            return true;
        }
    }



    // Set The Rules For All Attributes 
    public  function mainRules(): array
    {
        $rules = [
            'sku' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'field' => self::class]],
            'name' => [self::RULE_REQUIRED],
            'price' => [self::RULE_REQUIRED],
            'productType' => [self::RULE_REQUIRED],
        ];
        return $rules;
    }


    // Generate Attributes from Rules Array

    public function attributes()
    {
        foreach ($this->allRules() as $attribute => $value) {
            $attributeValue[$attribute] = $this->{$attribute};
        }
        return $attributeValue;
    }

    // Generate Labels for Each Page 
    public function labels(): array
    {
        foreach ($this->allRules() as $attribute => $value) {
            $attributeLabel[$attribute] = ucwords($attribute);
        }
        return $attributeLabel;
    }




    public function qMarks(): array
    {
        $attributes = $this->attributes();
        $attributes = array_values(array_filter($attributes));
        $qMarks = [];
        foreach ($attributes as $key => $value) {
            $qMarks[$key] = '?';
        }
        return $qMarks;
    }


    // To get attributes with their references 
    public function getRefs(): array
    {
        $attributes = $this->attributes();
        $attributes = array_values(array_filter($attributes));

        $type = '';
        $refs = array();
        foreach ($attributes as $key => $value) {
            $refs[$key] = &$attributes[$key];

            if (!is_array(gettype($attributes[$key]))) {
                $type .= substr(gettype($attributes[$key]), 0, 1);
            }
        }

        array_splice($refs, 0, 0, "$type");
        return $refs;
    }



    public function Validate()
    {
        foreach ($this->allRules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, ['field' => $this->getLabel($attribute)]);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, ['field' => $this->getLabel($attribute)]);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $class = $rule['field'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $table = $class::table();
                    $statement = App::$app->db->prepare("SELECT * FROM $table WHERE $uniqueAttr = ?");
                    $statement->bind_param("s", $value);
                    $statement->execute();
                    $record = $statement->fetch();
                    if ($record) {
                        $this->addError($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }

        return empty($this->errors);
    }


    public static function prepare($sql)
    {
        return App::$app->db->mysqli->prepare($sql);
    }
}
