<?php
    namespace App;

    abstract class AbstractManager
    {
        private static $connection;

        protected static function connect(){
            self::$connection = DAO::connect();
        }

        protected static function getOneOrNullResult($row, $class){
            
            if($row != null){
                return new $class($row);
            }
            return null;
        }

        protected static function getResults($rows, $class){
            
            $results = [];
            
            if($rows != null){
                foreach($rows as $row){
                    $results[] = new $class($row);
                }
            }
            
            return $results;
        }

        protected static function getValue($row){
            
            if($row != null){
                return $row;
            }
            return null;
        }

        protected static function select($sql, $params = null, $multiple = true){
            
            try{
                $stmt = self::$connection->prepare($sql);
                $stmt->execute($params);

                if($multiple){
                    return $stmt->fetchAll();
                }
                return $stmt->fetch();
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Affichage d'une erreur
                die();  // meurt
            }

        }

        protected static function insert($sql, $params){
            try{
                $stmt = self::$connection->prepare($sql);
                return $stmt->execute($params);
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Affichage d'une erreur
                die();  // meurt
            }
        }

        protected static function insertReturn($sql, $params){
            try{
                $stmt = self::$connection->prepare($sql);
                $stmt->execute($params);
                return self::$connection->lastInsertId();
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Affichage d'une erreur
                die();  // meurt
            }
        }

        protected static function update($sql, $params){
            try{
                $stmt = self::$connection->prepare($sql);
                return $stmt->execute($params);
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Affichage d'une erreur
                die();  // meurt
            }
        }

        protected static function delete($sql, $params){
            try{
                $stmt = self::$connection->prepare($sql);
                return $stmt->execute($params);
            }
            catch(\PDOException $e) {
                echo $e->getMessage();  //Affichage d'une erreur
                die();  // meurt
            }
        }
    }