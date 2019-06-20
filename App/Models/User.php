<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */


    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getuser($user_id)
    {
        $db = static::getDB();
        $select_user = "SELECT * FROM users where id =".$user_id." LIMIT 1 ";
        $stmt = $db->query($select_user);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($title ,$username, $password, $is_admin)
    {
        $db = static::getDB();
        $sql = "INSERT INTO users (title, username, password, is_admin) VALUES (:title, :username, :password, :is_admin)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title ,':username' => $username, ':password' => md5($password), ':is_admin' => $is_admin);
        $query->execute($parameters);
    }

    public static function update($user_id, $title ,$username, $password, $is_admin)
    {
        $db = static::getDB();
        $sql = "update users set title = :title, username = :username, password = :password, is_admin = :is_admin where id = :id";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $user_id ,':title' =>$title ,':username' => $username, ':password' => md5($password), ':is_admin' => $is_admin);
        $query->execute($parameters);
    }

    public static function delete($user_id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM users WHERE id = :user_id";
        $query = $db->prepare($sql);
        $parameters = array(':user_id' => $user_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function verify($username, $password)
    {
        if ($username != '' && $password != '') {

            $db = static::getDB();
            $sql = "SELECT * FROM users WHERE username = :username and password = :password";
            $query = $db->prepare($sql);
            $hash = md5($password);
            $parameters = array(':username' => $username, ':password' => $hash);
            $query->execute($parameters);
            if ($query->rowCount() > 0) {
                $_SESSION['islogin'] = $query->fetch(PDO::FETCH_ASSOC);
//                print_r($query->fetch(PDO::FETCH_ASSOC));
            }
        }
    }

    public function isAdmin($user_id, $is_admin)
    {
        $sql = "SELECT id, is_admin from useers WHERE id = :user_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id, ':is_admin' => $is_admin);
        $query->execute($parameters);
        return $query->fetch();
    }

}
