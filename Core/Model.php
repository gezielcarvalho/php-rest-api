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
}