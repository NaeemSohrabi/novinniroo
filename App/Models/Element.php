<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Element extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM elements');
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $elements = [];
        foreach ($list as $key => $value){
            $elements[$value['entity_key']] = (array)json_decode($value['entity_value']);
        }
        return $elements;
    }

    public static function insert($entity_key, $entity_value)
    {
        $db = static::getDB();
        $sql = "INSERT INTO elements (entity_key, entity_value) VALUES (:entity_key, :entity_value)";
        $query = $db->prepare($sql);
        $parameters = array(':entity_key' => $entity_key, ':entity_value' => $entity_value);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function update($entity_key, $entity_value)
    {
        $db = static::getDB();
        $sql = "update elements set  entity_value = :entity_value where entity_key = :entity_key ";
        $query = $db->prepare($sql);
        $parameters = array(':entity_key' => $entity_key, ':entity_value' => $entity_value);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function getElement($entity_key){
        echo $entity_key;
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM elements where entity_key = '".$entity_key."' LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




}
