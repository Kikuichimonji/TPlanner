<?php

namespace App;

use Exception;
use PDOException;

abstract class AbstractManager
{
    private static $connection;

    /**
     * Establish connection to the database
     */
    protected static function connect()
    {
        self::$connection = DAO::connect();
    }

    /**
     * Severe the connection to the database
     */
    protected static function disconnect()
    {
        self::$connection = DAO::disconnect();
    }

    /**
    * Create and return an object from a single row, or return null
    *
    * @param array $row Datas from database
    * @param string $class Class to call (ex. "Models\Board")
    * @return null|object
    */
    protected static function getOneOrNullResult($row, $class) 
    {
        if ($row != null) {
            return new $class($row);
        }
        return null;
    }

    /**
    * Create and return objects from multiple rows
    *
    * @param array $rows Datas from database
    * @param string $class Class to call (ex. "Models\Board")
    * @return array
    */
    protected static function getResults($rows, $class)
    {
        $results = [];
        if ($rows != null) {
            foreach ($rows as $row) {
                $results[] = new $class($row);
            }
        }
        return $results;
    }

    /**
    * Return a row from database without hydratation
    *
    * @param array $row single data from database
    * @return array|null
    */
    protected static function getValue($row)
    {
        if ($row != null) {
            return $row;
        }
        return null;
    }

    /**
    * The general SELECT function
    *
    * @param string $sql Sql request
    * @param array $params Sql parameters
    * @param bool $multiple False for fetch(), True for fetchAll()
    * @return array
    */
    protected static function select($sql, $params = null, $multiple = true)
    { 
        try {
            $stmt = self::$connection->prepare($sql); //We prepare the query (protection against sql injection)
            $stmt->execute($params);

            if ($multiple) { //If we return multiple results we fecthAll
                return $stmt->fetchAll();
            }
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    /**
    * General INSERT function
    *
    * @param string $sql Sql request
    * @param array $params Sql parameters
    * @param int $idBoard Board ID
    * @return bool
    */
    protected static function insert($sql, $params, $idBoard = null)
    { 
        try {
            $stmt = self::$connection->prepare($sql);
            $id = $idBoard ? $idBoard : (isset($params["idBoard"]) ? $params["idBoard"] : null); //we check if we can find a board ID
            $id ? self::setChange($id) : null; //this method is called to indicate a change has been made
            return $stmt->execute($params);
        } catch (PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    /**
    * INSERT function that return the latest id
    *
    * @param string $sql Sql request
    * @param array $params Sql parameters
    * @return bool
    */
    protected static function insertReturn($sql, $params)
    { 
        try {
            $stmt = self::$connection->prepare($sql);
            $stmt->execute($params);
            $id = self::$connection->lastInsertId();

            return $id;
        } catch (PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    /**
    * General UPDATE function 
    *
    * @param string $sql Sql request
    * @param array $params Sql parameters
    * @param int $idBoard Board ID
    * @return bool
    */
    protected static function update($sql, $params, $idBoard = null)
    { 
        try {
            $stmt = self::$connection->prepare($sql);
            $stmt = $stmt->execute($params);

            $id = $idBoard ? $idBoard : (isset($params["idBoard"]) ? $params["idBoard"] : null); //if no id board is provided, we do not trigger a change
            $id ? self::setChange($id) : null;
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    /**
    * General DELETE function 
    *
    * @param string $sql Sql request
    * @param array $params Sql parameters
    * @param int $idBoard Board ID
    * @return bool
    */
    protected static function delete($sql, $params = null, $idBoard = null)
    { 
        try {
            $stmt = self::$connection->prepare($sql);
            $stmt = $stmt->execute($params);

            $id = $idBoard ? $idBoard : (isset($params["idBoard"]) ? $params["idBoard"] : null);
            $id ? self::setChange($id) : null;
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    /**
    * General TRANSACTION function 
    *
    * @param string $sql Sql request
    * @param array $params Sql parameters
    * @param int $idBoard Board ID
    * @return bool
    */
    protected static function transaction($sqls, $params = null, $idBoard = null)
    { 
        try {
            self::$connection->beginTransaction();
            foreach ($sqls as $sql) {
                $stmt = self::$connection->prepare($sql);
                $stmt = $stmt->execute($params);
                if ($stmt === false) {
                    throw new Exception("Database Error " . self::$connection->errorInfo()[2]);
                }
            }
            self::$connection->commit(); //if everything went well we commit the sqls

            $id = $idBoard ? $idBoard : (isset($params["idBoard"]) ? $params["idBoard"] : null);
            $id ? self::setChange($id) : null;

            return $stmt;
        } catch (PDOException $e) {
            self::$connection->rollback(); //if an error occured we rollback everything 
            echo $e->getMessage();  //Basic error shown
        }
    }

    /**
    * Set a new date in the DB
    *
    * @param int $id The board ID
    * @return bool
    */
    protected static function setChange($id) //The function used to indicate a change has been made (for refresh purpose)
    { 
        $sql =  "UPDATE boards" .
            " SET lastChange = :date" .
            " WHERE id = :id";
        $params = [
            "date" => date("Y-m-d H:i:s"),
            "id" => $id
        ];
        $stmt = self::$connection->prepare($sql);
        return $stmt->execute($params);
    }
}
