<?php

namespace App\Models;

use Core\Model;
use PDO;
use PDOException;

/**
 * User model
 *
 * PHP version 8.1
 */
class User extends Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $results = [];
        try {
            $db = static::getDB();
            $stmt = $db->query('SELECT * FROM users');
            // prepare response
            http_response_code(200);
            $results["success"] = true;
            $results["status"] = 200;
            $results["message"] = "Records found";
            $results["data"]["users"] = $stmt->fetchAll(PDO::FETCH_ASSOC);  
            // delete password
            foreach ($results["data"]["users"] as $key => $value) {
                unset($results["data"]["users"][$key]['password']);
            }
        } catch (PDOException $e) {
            // prepare response
            http_response_code(500);
            $results["success"] = false;
            $results["status"] = 500;
            $results['message'] = 'Error: ' . $e->getMessage();
            $results['error'] = $e->getMessage();
            return $results;
        } 
        return $results;
    }

    /**
     * Get a user by id
     *
     * @param integer $id
     * @return array
     */
    public static function getById($id)
    {
        try {
            $db = static::getDB();
            $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->execute(['id' => $id]);
            http_response_code(200);
            // prepare response
            $results["status"] = 200;
            $results["success"] = true;
            $results["message"] = "Record found";
            $results["data"]["user"] = $stmt->fetch(PDO::FETCH_ASSOC);
            // if is set delete password
            if (isset($results["data"]["user"]['password'])) {
                unset($results["data"]["user"]['password']);
            }
            if (!$results["data"]["user"]) {
                http_response_code(404);
                // prepare response
                $results["status"] = 404;
                $results["success"] = false;
                $results["message"] = "Record not found";
                $results['error'] = 'Record not found';
                unset($results["data"]);
            }
        } catch (PDOException $e) {
            $results[] = $e->getMessage();
            return $results;
        } 
        return $results;
    }

    /**
     * Create a new user
     *
     * @return array
     */
    public static function create(){
        try {
            $db = static::getDB();
            $stmt = $db->prepare('INSERT INTO users (fullname, username, email, password, address) VALUES (:fullname, :username, :email, :password, :address)');
            $stmt->execute([
                'fullname' => $_POST['fullname'],
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'address' => $_POST['address']
            ]);
            // get last inserted id
            $lastId = $db->lastInsertId();
            // get the product
            $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->execute(['id' => $lastId]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            // delete password
            unset($results['password']);
        } catch (PDOException $e) {
            $results[] = $e->getMessage();
            return $results;
        }
        return $results;
    }

    /**
     * Update a user
     *
     * @param integer $id
     * @return array
     */
    public static function update($id){
        try {
            $db = static::getDB();
            $columns = [];
            $parameters = [];

            // Build the columns and parameters arrays based on the received data
            foreach ($_POST as $key => $value) {
                if ($key === 'id') {
                    continue; // Skip the 'id' field, as it is not updated
                }

                // Check if the column exists in the table
                if (parent::isColumnExists($key, 'users')) {
                    $columns[] = $key; 
                    $parameters[$key] = $value;
                }
            }
            // Construct the SQL query
            $query = 'UPDATE users SET ';
            $updates = [];
            foreach ($columns as $column) {
                $updates[] = $column . ' = :' . $column;
            }
            $query .= implode(', ', $updates) . ' WHERE id = :id';
            $parameters['id'] = $id;
            $stmt = $db->prepare($query);

            // check if columns were provided
            if (count($columns) == 0) {
                http_response_code(400);
                exit();
            }
            $stmt->execute($parameters);
            if ($stmt->rowCount() == 0) {
                http_response_code(404);
                $results = ['error' => 'Record not found'];
            } else {           
                // get the product
                $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
                $stmt->execute(['id' => $id]);
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                // delete password
                unset($results['password']);
            }
        } catch (PDOException $e) {
            $results[] = $e->getMessage();
            return $results;
        }
        return $results;
    }

    /**
     * Delete a user
     *
     * @param integer $id
     * @return array
     */
    public static function delete($id){
        try {
            $db = static::getDB();
            $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // if acctected rows is 0, return error
            if ($stmt->rowCount() == 0) {
                http_response_code(404);
                $results = ['error' => 'Record not found'];
            } else {
                // set the header to 204
                http_response_code(204);
            }            
        } catch (PDOException $e) {
            $results[] = $e->getMessage();
        } finally {
            return $results;
        }
    }
}