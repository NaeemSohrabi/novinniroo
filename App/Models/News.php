<?php

namespace App\
Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class News extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM newses');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getNews($news_id){
        $db = static::getDB();
        $select_news_sql = "SELECT * FROM newses where id =".$news_id." LIMIT 1 ";
        $stmt = $db->query($select_news_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($title, $fa_title ,$description, $fa_description ,$image, $alt, $alt_fa)
    {
        $db = static::getDB();
        $sql = "INSERT INTO newses (title, fa_title ,description, fa_description ,image, alt, alt_fa ,created_at) VALUES (:title, :fa_title ,:description, :fa_description , :image, :alt, :alt_fa ,:created_at)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, 'fa_title' => $fa_title ,':description' => $description, 'fa_description' => $fa_description, 'image' => $image, 'alt' => $alt, 'alt_fa' => $alt_fa ,'created_at' => date('Y-m-d', time()) );

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function update($id, $title, $fa_title ,$description, $fa_description ,$image, $alt, $alt_fa)
    {
        $db = static::getDB();
        $sql = "update newses set title = :title, fa_title = :fa_title ,description = :description, fa_description = :fa_description ,image = :image, alt = :alt, alt_fa = :alt_fa ,updated_at = :updated_at where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array( ':id' => $id, ':title' => $title, ':fa_title' => $fa_title ,':description' => $description, ':fa_description' => $fa_description ,':image' => $image, ':alt' => $alt, ':alt_fa' => $alt_fa ,'updated_at' => date('Y-m-d', time()) );

        // useful for debugging: you can see the SQL behind above construction by using:
//         echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($news_id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM newses WHERE id = :news_id";
        $query = $db->prepare($sql);
        $parameters = array(':news_id' => $news_id);

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
