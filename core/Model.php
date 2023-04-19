<?php


namespace app\Core;

use app\models\Product;

abstract class Model
{

    public const RULE_REQUIRED = 'required';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_UNIQUE = 'unique';
    public array $errors = [];




    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
    abstract public function rules(): array;
    abstract public function specialRules(): array;
    public function labels(): array
    {
        return [];
    }
    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }


    public function Validate()
    {


        foreach ($this->rules() as $attribute => $rules) {
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


    public function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_MIN => 'Please enter a valid {field}',
            self::RULE_MAX => 'Please enter a valid {field}',
            self::RULE_UNIQUE => 'This {field} is already exist',
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? '';
    }
}
