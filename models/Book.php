<?php

namespace app\models;

use app\Models\Abstracts\Product;

/**
 * Summary of Book
 */
class Book extends Product
{

    
    public function loadData($data):void
    {
        return parent::loadData($data);
    }


    // Set The Rules For Specific Attributes For Each Product Type
    public  function allRules(): array
    {
        $mainRules = parent::mainRules();
        $specialRules = [
            'weight' => [self::RULE_REQUIRED,  [self::RULE_MIN, 'min' => 1], [self::RULE_MAX, 'max' => 5], 'field' => self::class],
        ];

        return array_merge($mainRules, $specialRules);
    }


    public function AddToDB():bool
    {
        if ($this->validate() && $this->store()) {
            return true;
        };
        return false;
    }
}
