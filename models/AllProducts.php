<?php


namespace app\models;

use app\Core\App;
use app\models\Abstracts\Products;


class AllProducts extends Products
{
    
    public function loadData($data)
    {
        return parent::loadData($data);
    }
    public function getAllData()
    {
        $table = parent::table();
        $statement = $this->prepare("SELECT * FROM $table");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function delete()
    {
        $table = parent::table();
        $ids = $this->ids;
        $ids = implode(',', $ids);
        $statement = $this->prepare("DELETE FROM $table WHERE `id` IN ($ids)");
        if ($statement == true) {
            $statement->execute();
            return true;
        }
    }

    public static function prepare($sql)
    {
        return App::$app->db->mysqli->prepare($sql);
    }
}
