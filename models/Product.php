<?php


namespace app\models;

use app\Core\DbModel;


class Product extends DbModel
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
    public array $ids =[] ;

    public function table(): string
    {
        return '`products`';
    }

    public function store()
    {
        return parent::store();
    }
    public function delete()
    {
        return parent::delete();
    }


    // Set The Rules For All Attributes 
    public  function rules(): array
    {
        $specialRules = $this->specialRules();
        
        $rules = [
            'sku' => [self::RULE_REQUIRED , [self::RULE_UNIQUE, 'field' =>self::class]],
            'name' => [self::RULE_REQUIRED],
            'price' => [self::RULE_REQUIRED],
            'productType' => [self::RULE_REQUIRED],
            'ids'=>[],
        ];

        return array_merge($rules, $specialRules);
    }


    // Set The Rules For Specific Attributes For Each Product Type
    public  function specialRules(): array
    {
        $typeValidator = [

            'dvd' => [
                'size' => [self::RULE_REQUIRED,   [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 5]],

            ],

            'furniture' => [
                'height' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 5], 'field' => self::class],
                'width' => [self::RULE_REQUIRED,  [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 5], 'field' => self::class],
                'length' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 5], 'field' => self::class],

            ],

            'book' => [
                'weight' => [self::RULE_REQUIRED,  [self::RULE_MIN, 'min' => 1], [self::RULE_MAX, 'max' => 5], 'field' => self::class],
            ]
        ];

        if (in_array($this->productType, array_keys(array_filter($typeValidator)))) {
            return $typeValidator[$this->productType];
        } else {
            return [];
        }
    }

    // Generate Attributes Names from Rules Array
    public function attributes(): array
    {
        foreach ($this->rules() as $attribute => $value) {
            $attributeValue[$attribute] = $this->{$attribute};
        }
        return $attributeValue;
    }

    // Generate Labels for Each Page 
    public function labels(): array
    {
        foreach ($this->rules() as $attribute => $value) {
            $attributeLabel[$attribute] = ucwords($attribute);
        }
        return $attributeLabel;
    }
}
