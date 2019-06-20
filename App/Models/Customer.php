<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Customer extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function insert($title, $alt, $alt_fa, $logo)
    {
        $db = static::getDB();
        $sql = "INSERT INTO customers (title, alt, alt_fa, logo) VALUES (:title, :alt, :alt_fa, :logo)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title,':alt' => $alt, ':alt_fa' => $alt_fa ,':logo' => $logo);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM customers');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCustomer($customer_id){
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM customers where id =".$customer_id." LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($customer_id, $title, $alt, $alt_fa ,$logo)
    {
        $db = static::getDB();
        $sql = "update customers set title = :title, alt = :alt, alt_fa = :alt_fa ,logo = :logo where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $customer_id, ':title' => $title, ':alt' => $alt, ':alt_fa' => $alt_fa ,':logo' => $logo);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($customer_id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM customers WHERE id = :customer_id";
        $query = $db->prepare($sql);
        $parameters = array(':customer_id' => $customer_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }
}
