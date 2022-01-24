<?php
    namespace App;

    abstract class AbstractEntity
    {
        /**
         * Hydrate object with data
         *
         * @param array $data Data table from database
         * @param object $object Object to hydrate
         * @return void
         */
        protected static function hydrate($data, $object){ 
            foreach($data as $field => $value){ // check if they keys are a DB field
               /* $fieldArray = explode("_",$field);  //NOT USED ANYMORE, WILL BREAK THIS PROJECT
                if(isset($fieldArray[1]) && $fieldArray[1] === "id") //if we find a foreigner key (we have to end it with _id)
                {
                    //dd($fieldArray);
                    $classname= "Models\\".ucfirst($fieldArray[0])."sManager"; //we call the corresponding manager
                    $manager = new $classname();
                    $value = $manager->findOneById($value); //we look for the object associated with the foreigner key , then hydrate it too
                }*/
                $method = "set".ucfirst($field); //we call the setter for each data
                if(method_exists($object, $method)){ // if the setter exist, we call it and add the data from DB
                    $object->$method($value);
                }
            }
        }
    }