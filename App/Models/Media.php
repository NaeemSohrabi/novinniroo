<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Media extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getMediaAll($entity_type, $entity_id, $entity_position)
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM medias where entity_type = '".$entity_type."' and entity_id = '".$entity_id."' and entity_position = '".$entity_position."' order by priority ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getMediaOne($entity_type, $entity_id, $entity_position)
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM medias where entity_type = '".$entity_type."' and entity_id = '".$entity_id."' and entity_position = '".$entity_position."' ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($entity_type, $entity_id, $entity_position, $title, $fa_title ,$description, $fa_description , $link ,$file)
    {
        $db = static::getDB();
        echo '! Ooops1';
        $sql = "INSERT INTO medias (entity_type, entity_id, entity_position, title, fa_title ,description, fa_description, link , file) VALUES (:entity_type , :entity_id , :entity_position , :title , :fa_title , :description , :fa_description, :link , :file)";
        $query = $db->prepare($sql);
        $parameters = array(':entity_type' => $entity_type, ':entity_id' => $entity_id, ':entity_position' => $entity_position,':title' => $title, ':fa_title' =>$fa_title ,':description' => $description, ':fa_description' => $fa_description, 'link' => $link ,':file' => $file);

        // useful for debugging: you can see the SQL behind above construction by using:
//         echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters); exit();
//         print_r($parameters);

        $query->execute($parameters);
    }

    public static function getMedia($media_id){
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM medias where id =".$media_id." LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id , $entity_type, $entity_id, $entity_position, $title, $fa_title , $description, $fa_description, $link , $file, $status , $priority)
    {
        $db = static::getDB();
        $sql = "update medias set entity_type = :entity_type, entity_id = :entity_id, entity_position = :entity_position, title = :title, fa_title = :fa_title ,description = :description, fa_description = :fa_description, link = :link ,file = :file , status = :status , priority = :priority where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $id, ':entity_type' => $entity_type, ':entity_id' => $entity_id, ':entity_position' => $entity_position,':title' => $title, ':fa_title' => $fa_title ,':description' => $description, ':fa_description' => $fa_description, 'link' => $link ,':file' => $file , ':status' => $status , ':priority' => $priority);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
//        print_r($parameters);

        $query->execute($parameters);
    }

    public static function deleteMedia($media_id){
        $db = static::getDB();
        $sql = "DELETE FROM medias WHERE id = :media_id";
        $query = $db->prepare($sql);
        $parameters = array(':media_id' => $media_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function altMedia($id, $alt, $alt_fa , $status){
        $db = static::getDB();
        $sql = "update medias set alt = :alt, alt_fa = :alt_fa , status = :status where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $id, ':alt' => $alt, ':alt_fa' => $alt_fa , ':status' => $status);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

}
