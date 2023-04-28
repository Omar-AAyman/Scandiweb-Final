<?php

namespace app\Models\Abstracts;

use app\Core\Model;


abstract class Products extends Model{

    public array $ids ;
    
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
    
    abstract public function delete();
    abstract public function getAllData();
}