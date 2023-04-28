<?php


namespace app\models;

use app\models\Abstracts\Product;

class Furniture extends Product
{

    public function loadData($data)
    {
        return parent::loadData($data);
    }



    // Set The Rules For Specific Attributes For Each Product Type
    public  function allRules(): array
    {
        $mainRules = parent::mainRules();
        $specialRules = [
            'height' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 5], 'field' => self::class],
            'width' => [self::RULE_REQUIRED,  [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 5], 'field' => self::class],
            'length' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 5], 'field' => self::class],
        ];

        return array_merge($mainRules, $specialRules);
    }

    
    public function AddToDB()
    {
        if ($this->validate() && $this->store()) {
            return true;
        };
        return false;
    }
}
