<?php

namespace App\
Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Product extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM products');
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $products as $k => $product ) {
            $brand = Brand::getBrand($product['brand_id']);
            $products[$k]['brand_name'] = $brand['fa_title'];
        }
        return $products;
    }

    public static function searchProduct($brand_id)
    {
        $db = static::getDB();
        $stmt =$db->query("SELECT * FROM products where brand_id =".$brand_id);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $products as $k => $product ) {
            $brand = Brand::getBrand($product['brand_id']);
            $products[$k]['brand_name'] = $brand['fa_title'];
        }
        return $products;
    }

    public static function getProduct($product_id){
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM products where id =".$product_id." LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($title, $fa_title ,$description, $fa_description ,$content, $fa_content ,$catalog, $fa_catalog ,$brand_id, $cover)
    {
        $db = static::getDB();
        $sql = "INSERT INTO products (title, fa_title ,description, fa_description ,content, fa_content ,catalog, fa_catalog ,brand_id, cover) VALUES (:title, :fa_title ,:description, :fa_description ,:content, :fa_content ,:catalog , :fa_catalog ,:brand_id, :cover)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, 'fa_title' => $fa_title ,':description' => $description, 'fa_description' => $fa_description, 'fa_content' => $fa_content ,':content' => $content,  ':catalog' => $catalog, ':fa_catalog' => $fa_catalog, ':brand_id' => $brand_id, ':cover' => $cover);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function update($id, $title, $fa_title ,$description, $fa_description ,$content, $fa_content ,$catalog, $fa_catalog ,$brand_id, $cover)
    {
        $db = static::getDB();
        $sql = "update products set title = :title, fa_title = :fa_title ,description = :description, fa_description = :fa_description ,content = :content, fa_content = :fa_content ,catalog = :catalog, fa_catalog = :fa_catalog, brand_id = :brand_id, cover = :cover where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array( ':id' => $id, ':title' => $title, ':fa_title' => $fa_title ,':description' => $description, ':fa_description' => $fa_description ,':content' => $content, ':fa_content' => $fa_content ,':catalog' => $catalog,':fa_catalog' => $fa_catalog, ':brand_id' => $brand_id, ':cover' => $cover);

        // useful for debugging: you can see the SQL behind above construction by using:
//         echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($product_id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM products WHERE id = :product_id";
        $query = $db->prepare($sql);
        $parameters = array(':product_id' => $product_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function getBrandProduct($brand_id){
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM products where brand_id =".$brand_id;
        $stmt = $db->query($select_brand_sql);
        $products = (array)$stmt->fetchAll(PDO::FETCH_ASSOC);
        $last_arr = [];
        foreach ($products as $key => $value){
            $arr = $value;
            $images = Media::getMediaOne('product', $value['id'], 'gallery');
            $arr['image'] = $images;
         $last_arr[] = $arr;
        }
        return $last_arr;
    }

    public static function getCatalogProduct($product_id){
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM products where id =".$product_id." LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
