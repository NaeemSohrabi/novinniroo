<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Brand extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM brands');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($fa_title, $title, $fa_description, $description,$fa_branch_text ,$branch_text, $brand_logo)
    {
        $db = static::getDB();
        $sql = "INSERT INTO brands (fa_title, title, fa_description ,description, fa_branch_text ,branch_text, brand_logo) VALUES (:fa_title, :title, :fa_description ,:description, :fa_branch_text ,:branch_text, :brand_logo)";
        $query = $db->prepare($sql);
        $parameters = array( ':fa_title' => $fa_title ,':title' => $title, ':fa_description' => $fa_description ,':description' => $description, ':fa_branch_text' => $fa_branch_text ,':branch_text' => $branch_text, ':brand_logo' => $brand_logo);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function getBrand($brand_id){
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM brands where id =".$brand_id." LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($brand_id, $fa_title ,$title, $fa_description ,$description, $fa_branch_text ,$branch_text, $brand_logo)
    {
        $db = static::getDB();
        $sql = "update brands set fa_title = :fa_title, title = :title, fa_description = :fa_description ,description = :description, fa_branch_text = :fa_branch_text ,branch_text = :branch_text, brand_logo = :brand_logo where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $brand_id, 'fa_title' => $fa_title ,':title' => $title, 'fa_description' => $fa_description ,':description' => $description, ':fa_branch_text' => $fa_branch_text ,':branch_text' => $branch_text, ':brand_logo' => $brand_logo);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($brand_id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM brands WHERE id = :brand_id";
        $query = $db->prepare($sql);
        $parameters = array(':brand_id' => $brand_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

}
