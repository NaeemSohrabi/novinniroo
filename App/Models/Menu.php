<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Menu extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM menues order by sort');
        $menues = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $menues as $k => $menue ) {
            $parent = Menu::getMenu($menue['parent_id']);
            $menues[$k]['parent_name'] = $parent['title'];
        }
        return $menues;
    }

    public static function getRecursive()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM menues order by sort');
        $menues = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return self::recursive($menues, 0);
    }

    public static function getMenu($id)
    {
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM menues where id =" . $id . " LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($title, $fa_title , $link, $parent_id, $sort)
    {
        $db = static::getDB();
        $sql = "INSERT INTO menues (title, fa_title ,link, parent_id, sort) VALUES (:title, :fa_title ,:link, :parent_id, :sort)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, ':fa_title' => $fa_title ,':link' => $link, ':parent_id' => $parent_id, ':sort' => $sort);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function getBrand($brand_id)
    {
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM brands where id =" . $brand_id . " LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $title, $fa_title ,$link, $parent_id, $sort)
    {
        $db = static::getDB();
        $sql = "update menues set title = :title, fa_title = :fa_title ,link = :link, parent_id = :parent_id, sort = :sort where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $id, ':title' => $title, ':fa_title' => $fa_title ,':link' => $link, ':parent_id' => $parent_id, ':sort' => $sort);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM menues WHERE id = :id";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function recursive(array $elements, $patrent_id = 0)
    {
        $branch = array();
        foreach ($elements as $element){
            if($element['parent_id'] == $patrent_id){
                $children = self::recursive($elements, $element['id']);
                if($children){
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

}
