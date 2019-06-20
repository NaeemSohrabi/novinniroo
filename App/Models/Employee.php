<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Employee extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function insert($name ,$fa_name, $family, $fa_family ,$department, $fa_department ,$email, $phone ,$image)
    {
        $db = static::getDB();
        $sql = "INSERT INTO employees (name, fa_name ,family, fa_family ,department, fa_department ,email, phone ,image) VALUES (:name, :fa_name , :family, :fa_family , :department, :fa_department , :email, :phone, :image)";
        $query = $db->prepare($sql);
        $parameters = array(':name' => $name, ':fa_name' => $fa_name ,':family' => $family, ':fa_family' => $fa_family ,':department' => $department, ':fa_department' => $fa_department ,':email' => $email, ':phone' => $phone,':image' => $image );

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM employees');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getEmployee($employee_id){
        $db = static::getDB();
        $select_brand_sql = "SELECT * FROM employees where id =".$employee_id." LIMIT 1 ";
        $stmt = $db->query($select_brand_sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($employee_id, $name,$fa_name, $family, $fa_family ,$department, $fa_department ,$email, $phone ,$image)
    {
        $db = static::getDB();
        $sql = "update employees set name = :name, fa_name = :fa_name ,family = :family, fa_family = :fa_family ,department = :department, fa_department = :fa_department ,email = :email, phone = :phone, image = :image where id = :id ";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $employee_id, ':name' => $name, ':fa_name' => $fa_name ,':family' => $family, ':fa_family' => $fa_family ,':department' => $department, ':fa_department' => $fa_department ,':email' => $email,':phone' => $phone,':image' => $image);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function delete($employee_id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM employees WHERE id = :employee_id";
        $query = $db->prepare($sql);
        $parameters = array(':employee_id' => $employee_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }
}
