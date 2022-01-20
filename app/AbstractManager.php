<?php

namespace App;

use Exception;

abstract class AbstractManager
{
    private static $connection;

    protected static function connect() //We connect to the DB
    {
        self::$connection = DAO::connect();
    }

    protected static function disconnect() // We disconnect the DB
    {
        self::$connection = DAO::disconnect();
    }

    protected static function getOneOrNullResult($row, $class) //We return either a single result or null
    {
        if ($row != null) {
            return new $class($row);
        }
        return null;
    }

    protected static function getResults($rows, $class) //We return multiple result
    {
        $results = [];
        if ($rows != null) {
            foreach ($rows as $row) {
                $results[] = new $class($row);
            }
        }
        return $results;
    }

    protected static function getValue($row) //We return a single value without hydratation
    {
        if ($row != null) {
            return $row;
        }
        return null;
    }

    protected static function select($sql, $params = null, $multiple = true)//The general SELECT function
    { 
        try {
            $stmt = self::$connection->prepare($sql); //We prepare the query (protection against sql injection)
            $stmt->execute($params);

            if ($multiple) { //If we return multiple results we fecthAll
                return $stmt->fetchAll();
            }
            return $stmt->fetch();
        } catch (\PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    protected static function insert($sql, $params, $idBoard = null) // The general INSERT function
    { 
        try {
            $stmt = self::$connection->prepare($sql);
            $id = $idBoard ? $idBoard : (isset($params["idBoard"]) ? $params["idBoard"] : null);
            $id ? self::setChange($id) : null; //this method is called to indicate a change has been made
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    protected static function insertNoChange($sql, $params) // The INSERT function that do not trigger the change function
    { 
        try {
            $stmt = self::$connection->prepare($sql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    protected static function insertReturn($sql, $params) //The other INSERT function, insert and return the last ID inserted (does not trigger change cause it's only use when we create a new board)
    { 
        try {
            $stmt = self::$connection->prepare($sql);
            $stmt->execute($params);
            $id = self::$connection->lastInsertId();

            return $id;
        } catch (\PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    protected static function update($sql, $params, $idBoard = null) // The general UPDATE function
    { 
        try {
            $stmt = self::$connection->prepare($sql);
            $stmt = $stmt->execute($params);

            $id = $idBoard ? $idBoard : (isset($params["idBoard"]) ? $params["idBoard"] : null); //if no id board is provided, we do not trigger a change
            $id ? self::setChange($id) : null;
            return $stmt;
        } catch (\PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    protected static function delete($sql, $params = null, $idBoard = null) // The general DELETE function
    { 
        try {
            $stmt = self::$connection->prepare($sql);
            $stmt = $stmt->execute($params);

            $id = $idBoard ? $idBoard : (isset($params["idBoard"]) ? $params["idBoard"] : null);
            $id ? self::setChange($id) : null;
            return $stmt;
        } catch (\PDOException $e) {
            echo $e->getMessage();  //Basic error shown
        }
    }

    protected static function transaction($sqls, $params = null, $idBoard = null) // Transaction function
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
        } catch (\PDOException $e) {
            self::$connection->rollback(); //if an error occured we rollback everything 
            echo $e->getMessage();  //Basic error shown
        }
    }

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
