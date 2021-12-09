<?php
    namespace App;

    abstract class AbstractEntity
    {
        
        protected static function hydrate($data, $object){ //$data = données de la base, $object = objet a hydrater
            foreach($data as $field => $value){ // check clef est un champ 
                $fieldArray = explode("_",$field);
                if(isset($fieldArray[1]) && $fieldArray[1] === "id")
                {
                    $classname= "Models\\".ucfirst($fieldArray[0])."Manager";
                    $manager = new $classname;
                    $value = $manager->findOneById($value);
                }
                $method = "set".ucfirst($field); //on essaye d'appeler un setter pour chaque données
                //var_dump($method);die();
                if(method_exists($object, $method)){ // Si la methode existe, on remplit l'objet
                    $object->$method($value);
                }
            }

        }
    }