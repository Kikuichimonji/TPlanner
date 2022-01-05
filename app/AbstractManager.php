<?php
    namespace App;

    abstract class AbstractManager
    {
        private static $connection;

        protected static function connect(){ //We connect to the DB
            self::$connection = DAO::connect();
        }

        protected static function disconnect(){ // We disconnect the DB
            self::$connection = DAO::disconnect();
        }

        protected static function getOneOrNullResult($row, $class){ //We return either a single result or null
            
            if($row != null){
                return new $class($row);
            }
            return null;
        }

        protected static function getResults($rows, $class){ //We return multiple result
            
            $results = [];
            
            if($rows != null){
                foreach($rows as $row){
                    $results[] = new $class($row);
                }
            }
            
            return $results;
        }

        protected static function getValue($row){ //We return a single value without hydratation
            
            if($row != null){
                return $row;
            }
            return null;
        }

        protected static function select($sql, $params = null, $multiple = true){ //The general SELECT function
            
            try{
                $stmt = self::$connection->prepare($sql); //We prepare the query (protection against sql injection)
                $stmt->execute($params); 

                if($multiple){ //If we return multiple results we fecthAll
                    return $stmt->fetchAll();
                }
                return $stmt->fetch();
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Basic error shown
                //die();  // meurt
            }

        }

        protected static function insert($sql, $params, $idBoard = null){ // The general INSERT function
            try{
                $stmt = self::$connection->prepare($sql);
                self::setChange($idBoard? $idBoard : $params["idBoard"]); //this method is called to indicate a change has been made
                return $stmt->execute($params);
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Basic error shown
                //die();  // meurt
            }
        }

        protected static function insertNoChange($sql, $params){ // The general INSERT function
            try{
                $stmt = self::$connection->prepare($sql);
                return $stmt->execute($params);
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Basic error shown
                //die();  // meurt
            }
        }

        protected static function insertReturn($sql, $params){ //The other INSERT function, insert and return the last ID inserted
            try{
                $stmt = self::$connection->prepare($sql);
                $stmt->execute($params);
                $id = self::$connection->lastInsertId();

                return $id;
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Basic error shown
                //die();  // meurt
            }
        }

        protected static function update($sql, $params, $idBoard = null){ // The general UPDATE function
            try{
                $stmt = self::$connection->prepare($sql);
                $stmt = $stmt->execute($params);

                self::setChange($idBoard? $idBoard : $params["idBoard"]);
                return $stmt;
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Basic error shown
                //die();  // meurt
            }
        }

        protected static function delete($sql, $params = null, $idBoard = null){ // The general DELETE function
            try{
                $stmt = self::$connection->prepare($sql);
                $stmt = $stmt->execute($params);

                self::setChange($idBoard? $idBoard : $params["idBoard"]);
                return $stmt;
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Basic error shown
                //die();  // meurt
            }
        }

        protected static function setChange($id){//The function used to indicate a change has been made
            $sql =  "UPDATE boards".
                    " SET lastChange = :date".
                    " WHERE id = :id";
            $params= ["date" => date("Y-m-d H:i:s"),
                        "id" => $id];
            //var_dump($params);die();
            $stmt = self::$connection->prepare($sql);
            return $stmt->execute($params);
        }
    }