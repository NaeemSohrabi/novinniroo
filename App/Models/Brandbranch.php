<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Brandbranch extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM brand_branch');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($title, $image, $brand_id)
    {
        $db = static::getDB();
        $sql = "INSERT INTO brand_branch (title, image, brand_id) VALUES (:title, :image, :brand_id)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, ':image' => $image, ':brand_id' => $brand_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function getBranch($branch_id){
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM brand_branch where id =".$branch_id." LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getBrandBranch($brand_id){
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM brand_branch where brand_id =".$brand_id;
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($title, $image, $branch_id)
    {
        $db = static::getDB();
        $sql = "update brand_branch set title = :title, image = :image where id = :branch_id ";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, ':image' => $image, ':branch_id' => $branch_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($branch_id)
    {
        $db = static::getDB();
        $sql = "delete from brand_branch where id = :branch_id ";
        $query = $db->prepare($sql);
        $parameters = array(':branch_id' => $branch_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }
}
