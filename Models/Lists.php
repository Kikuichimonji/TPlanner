<?php

namespace Models;
use App\AbstractEntity;
use Models\ListsManager;

class Lists extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    protected $table = 'Lists';

    private $id;
    private $label;
    private $listPosition;
    private $isArchived;
    private $listCards;

    public function __construct($data)
    {
        parent::hydrate($data,$this);
        $lm = new ListsManager();
        $this->listCards = $lm->getCards($this->id);
    }
    
    public function __toString()
    {
        return "List {$this->id}";
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
     * Get the value of listPosition
     */ 
    public function getListPosition()
    {
        return $this->listPosition;
    }

    /**
     * Set the value of listPosition
     *
     * @return  self
     */ 
    public function setListPosition($listPosition)
    {
        $this->listPosition = $listPosition;

        return $this;
    }

    /**
     * Get the value of isArchived
     */ 
    public function getIsArchived()
    {
        return $this->isArchived;
    }

    /**
     * Set the value of isArchived
     *
     * @return  self
     */ 
    public function setIsArchived($isArchived)
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    /**
     * Get the value of listCards
     */ 
    public function getListCards()
    {
        return $this->listCards;
    }

    /**
     * Set the value of listCards
     *
     * @return  self
     */ 
    public function setListCards($listCards)
    {
        $this->listCards = $listCards;

        return $this;
    }
}
