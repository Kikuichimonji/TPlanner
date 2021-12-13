<?php

namespace Models;
use App\AbstractEntity;
use Models\BoardManager;

class Board extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    protected $table = 'board';

    private $id;
    private $label;
    private $listLists;

    public function __construct($data)
    {
        parent::hydrate($data,$this);
        $bm = new BoardManager();
        $this->listLists = $bm->getLists($this->id);
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

    /**
     * Get the value of listLists
     */ 
    public function getListLists()
    {
        return $this->listLists;
    }

    /**
     * Set the value of listLists
     *
     * @return  self
     */ 
    public function setListLists($listLists)
    {
        $this->listLists = $listLists;

        return $this;
    }
}
