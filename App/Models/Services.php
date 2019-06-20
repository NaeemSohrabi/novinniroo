<?php

namespace App\
Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Services extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM services order by priority');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getService($service_id){
        $db = static::getDB();
        $select_service_sql = "SELECT * FROM services where id =".$service_id." LIMIT 1 ";
        $stmt = $db->query($select_service_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($title, $fa_title ,$description, $fa_description, $link, $alt, $alt_fa ,$image)
    {
        $db = static::getDB();
        $sql = "INSERT INTO services (title, fa_title ,description, fa_description, link, alt, alt_fa ,image) VALUES (:title, :fa_title ,:description, :fa_description , :link, :alt, :alt_fa ,:image)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, 'fa_title' => $fa_title ,':description' => $description, 'fa_description' => $fa_description, 'link' => $link, 'alt' => $alt, 'alt_fa' => $alt_fa ,'image' => $image);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function update($id, $title, $fa_title ,$description, $fa_description, $link, $alt, $alt_fa ,$image , $status , $priority)
    {
        $db = static::getDB();
        $sql = "update services set title = :title, fa_title = :fa_title ,description = :description, fa_description = :fa_description, link = :link, alt = :alt, alt_fa = :alt_fa ,image = :image , status = :status , priority = :priority where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array( ':id' => $id, ':title' => $title, ':fa_title' => $fa_title ,':description' => $description, ':fa_description' => $fa_description, 'link' => $link, 'alt' => $alt, 'alt_fa' => $alt_fa ,':image' => $image , ':status' => $status , ':priority' => $priority);

        // useful for debugging: you can see the SQL behind above construction by using:
//         echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($service_id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM services WHERE id = :service_id";
        $query = $db->prepare($sql);
        $parameters = array(':service_id' => $service_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

//    public static function getBrandProduct($brand_id){
//        $db = static::getDB();
//        $select_brand_sql = "SELECT * FROM products where brand_id =".$brand_id;
//        $stmt = $db->query($select_brand_sql);
//        $products = (array)$stmt->fetchAll(PDO::FETCH_ASSOC);
//        $last_arr = [];
//        foreach ($products as $key => $value){
//            $arr = $value;
//            $images = Media::getMediaOne('product', $value['id'], 'gallery');
//            $arr['image'] = $images;
//         $last_arr[] = $arr;
//        }
//        return $last_arr;
//    }
//
//    public static function getCatalogProduct($product_id){
//        $db = static::getDB();
//        $select_brand_sql = "SELECT * FROM products where id =".$product_id." LIMIT 1 ";
//        $stmt = $db->query($select_brand_sql);
//        return $stmt->fetch(PDO::FETCH_ASSOC);
//    }
}
