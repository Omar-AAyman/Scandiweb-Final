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
    

    
    /**
     * Set the value of ids
     *
     * @return  self
     */ 
    public function setIds()
    {
        $this->ids = $this->{'ids'};

        return $this;
    }
    
 
    abstract public function delete():bool;
    abstract public function getAllData():array;
}