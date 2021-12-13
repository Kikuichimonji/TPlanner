<?php

namespace Models;
use App\AbstractEntity;

class Board extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    protected $table = 'board';

    private $id;
    private $label;

    public function __construct($data)
    {
        parent::hydrate($data,$this);
    }
    
    public function __toString()
    {
        return "Board {$this->id}";
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of label
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @return  self
     */ 
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }
}
