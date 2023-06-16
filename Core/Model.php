<?php

namespace Core;

use PDO;

abstract class Model
{

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $host = getenv('DATABASE_HOST');
            $dbname = getenv('DATABASE_NAME');
            $username = getenv('DATABASE_USER');
            $password = getenv('DATABASE_PASSWORD');


            $db = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $username,
                $password
            );

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }

        return $db;
    }

    /**
     * Check if a column exists in a table
     *
     * @param string $column
     * @param string $table
     * @return boolean
     */
    protected static function isColumnExists($column, $table)
    {
        $db = static::getDB();
        $query = "SHOW COLUMNS FROM $table LIKE '$column'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result !== false);
    }
}