<?php
    namespace App;

    abstract class AbstractEntity
    {
        
        protected static function hydrate($data, $object){ //$data = Data from DB, $object = object to hydrate
            
            foreach($data as $field => $value){ // check if they keys are a DB field
                $fieldArray = explode("_",$field);
                if(isset($fieldArray[1]) && $fieldArray[1] === "id") //if we find a foreigner key (we have to end it with _id)
                {
                    $classname= "Models\\".ucfirst($fieldArray[0])."Manager"; //we call the corresponding manager
                    $manager = new $classname();
                    $value = $manager->findOneById($value); //we look for the object associated with the foreigner key , then hydrate it too
                }
                $method = "set".ucfirst($field); //we call the setter for each data
                if(method_exists($object, $method)){ // if the setter exist, we call it and add the data from DB
                    $object->$method($value);
                }
            }
        }
    }