<?php


namespace app\models;

use app\Core\App;
use app\models\Abstracts\Products;


/**
 * Summary of AllProducts
 */
class AllProducts extends Products
{
    
    
    public function loadData($data):void
    {
        return parent::loadData($data);
    }

   
    public function getAllData(): array
    {
        $table = parent::table();
        $statement = $this->prepare("SELECT * FROM $table");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function delete():bool
    {
        $table = parent::table();
        $ids = $this->ids;
        $ids = implode(',', $ids);
        $statement = $this->prepare("DELETE FROM $table WHERE `id` IN ($ids)");
        if ($statement == true) {
            $statement->execute();
            return true;
        }
        return false;
    }

   
    public static function prepare($sql):\mysqli_stmt|bool
    {
        return App::$app->db->mysqli->prepare($sql);
    }
}
