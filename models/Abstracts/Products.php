<?php

namespace app\Models\Abstracts;

use app\Core\Model;


/**
 * Summary of Products
 */
abstract class Products extends Model{

    public array $ids=[] ;
    
    public function table(): string
    {
        return '`products`';
    }
    
 
    abstract public function delete():bool;
    abstract public function getAllData():array;
}
