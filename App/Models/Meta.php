<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Meta extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */

    public static function getMeta($entity_type, $entity_id)
    {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM meta where entity_type = '".$entity_type."' and entity_id = '".$entity_id."'  LIMIT 1 ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($entity_type, $entity_id, $meta_tag, $meta_tag_fa ,$meta_description, $meta_description_fa )
    {
        $db = static::getDB();
        $sql = "INSERT INTO meta (entity_type, entity_id, meta_tag, meta_tag_fa ,meta_description, meta_description_fa) VALUES (:entity_type, :entity_id, :meta_tag, :meta_tag_fa , :meta_description, :meta_description_fa)";
        $query = $db->prepare($sql);
        $parameters = array(':entity_type' => $entity_type, ':entity_id' => $entity_id, ':meta_tag' => $meta_tag, ':meta_tag_fa' => $meta_tag_fa ,':meta_description' => $meta_description, ':meta_description_fa' => $meta_description_fa);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public static function update( $entity_type, $entity_id, $meta_tag, $meta_tag_fa ,$meta_description, $meta_description_fa )
    {
        $db = static::getDB();
        $sql = "update meta set meta_tag = :meta_tag, meta_tag_fa = :meta_tag_fa ,meta_description = :meta_description, meta_description_fa = :meta_description_fa where entity_type = :entity_type and entity_id = :entity_id ";
        $query = $db->prepare($sql);
        $parameters = array( ':entity_type' => $entity_type, ':entity_id' => $entity_id, ':meta_tag' => $meta_tag, ':meta_tag_fa' => $meta_tag_fa ,':meta_description' => $meta_description, ':meta_description_fa' => $meta_description_fa);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }


}
