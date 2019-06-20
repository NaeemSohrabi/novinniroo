<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Contact extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM contacts');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($en_name, $fa_name ,$phone, $fax, $mobile, $email, $web, $en_address, $fa_address, $lat, $lng)
    {
        $db = static::getDB();
        $sql = "INSERT INTO contacts (en_name, fa_name ,phone, fax, mobile, email, web, en_address, fa_address, lat, lng) VALUES (:en_name, :fa_name ,:phone, :fax ,:mobile, :email ,:web, :en_address, :fa_address, :lat, :lng)";
        $query = $db->prepare($sql);
        $parameters = array( ':en_name' => $en_name, ':fa_name' => $fa_name ,':phone' => $phone, ':fax' => $fax ,':mobile' => $mobile, ':email' => $email ,':web' => $web, ':en_address' => $en_address, ':fa_address' => $fa_address, ':lat' => $lat, ':lng' => $lng);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function getContact($contact_id){
        $db = static::getDB();
        $select_contact_sql = "SELECT * FROM contacts where id =".$contact_id." LIMIT 1 ";
        $stmt = $db->query($select_contact_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function update($contact_id, $en_name, $fa_name ,$phone, $fax, $mobile, $email, $web, $fa_address, $en_address, $lat, $lng)
    {
        $db = static::getDB();
        $sql = "update contacts set en_name = :en_name, fa_name = :fa_name ,phone = :phone, fax = :fax ,mobile = :mobile, email = :email ,web = :web, fa_address = :fa_address, en_address = :en_address, lat = :lat, lng = :lng where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array('id'=> $contact_id, ':en_name' => $en_name , ':fa_name' => $fa_name ,':phone' => $phone, ':fax' => $fax ,':mobile' => $mobile, ':email' => $email ,':web' => $web, ':en_address' => $en_address, ':fa_address' => $fa_address, ':lat' => $lat, ':lng' => $lng);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($contact_id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM contacts WHERE id = :contact_id";
        $query = $db->prepare($sql);
        $parameters = array(':contact_id' => $contact_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

}
