<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Page extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM pages');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($title, $fa_title, $summary, $fa_summary, $subtitle, $fa_subtitle, $description, $fa_description, $slug)
    {
        $db = static::getDB();
        $sql = "INSERT INTO pages (title, fa_title, summary, fa_summary, subtitle, fa_subtitle, description, fa_description, slug) VALUES (:title, :fa_title, :summary ,:fa_summary, :subtitle ,:fa_subtitle, :description, :fa_description, :slug)";
        $query = $db->prepare($sql);
        $parameters = array( ':title' => $title ,':fa_title' => $fa_title, ':summary' => $summary ,':fa_summary' => $fa_summary, ':subtitle' => $subtitle ,':fa_subtitle' => $fa_subtitle, ':description' => $description, ':fa_description' => $fa_description, ':slug' => $slug);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function getPage($page_id){
        $db = static::getDB();
        $select_page_sql = "SELECT * FROM pages where id =".$page_id." LIMIT 1 ";
        $stmt = $db->query($select_page_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getPageSlug($page_slug){
        $db = static::getDB();
        $select_page_sql = "SELECT * FROM pages where slug = '".$page_slug."' LIMIT 1 ";
        $stmt = $db->query($select_page_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($page_id, $title, $fa_title, $summary, $fa_summary, $subtitle, $fa_subtitle, $description, $fa_description, $slug)
    {
        $db = static::getDB();
        $sql = "update pages set fa_title = :fa_title, title = :title, fa_description = :fa_description ,description = :description, summary = :summary ,fa_summary = :fa_summary, subtitle = :subtitle, fa_subtitle = :fa_subtitle, slug = :slug where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array('id'=> $page_id, ':title' => $title ,':fa_title' => $fa_title, ':summary' => $summary ,':fa_summary' => $fa_summary, ':subtitle' => $subtitle ,':fa_subtitle' => $fa_subtitle, ':description' => $description, ':fa_description' => $fa_description, ':slug' => $slug);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($page_id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM pages WHERE id = :page_id";
        $query = $db->prepare($sql);
        $parameters = array(':page_id' => $page_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

}
