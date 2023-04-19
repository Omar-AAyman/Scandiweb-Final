<?php

namespace app\core;

use app\Core\Model;

abstract class DbModel extends Model
{
    abstract public function table(): string;

    abstract public function attributes(): array;


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


    public function store()
    {
        $table = $this->table();
        $attributes = $this->attributes();
        $qMarks = $this->qMarks();
        $statement = $this->prepare("INSERT INTO $table (" . '`' . implode('`,`', array_keys(array_filter($attributes))) . '`' . ") VALUES (" . implode(',', $qMarks) . ")");
        if (!$statement == false) {
            call_user_func_array(array($statement, 'bind_param'), $this->getRefs());
            $statement->execute();
            return true;
        }
    }
    public function delete()
    {
        $table = $this->table();
        $ids=$this->attributes()['ids'];
        $ids = implode(',', $ids);
        $statement = $this->prepare("DELETE FROM $table WHERE `id` IN ($ids)");
        if ($statement == true) {
            $statement->execute();
            return true;
        }
    }

    public function getAllData()
    {
        $table = $this->table();
        $statement = $this->prepare("SELECT * FROM $table");
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function prepare($sql)
    {
        return App::$app->db->mysqli->prepare($sql);
    }
}
