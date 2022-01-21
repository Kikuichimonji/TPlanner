<?php

namespace Models;

use App\AbstractEntity;
use Models\BoardsManager;

class Board extends AbstractEntity
{
    /**
     * @inheritdoc
     */
    protected $table = 'boards';

    private $id;
    private $label;
    private $listLists;
    private $cardsArchived;
    private $listsArchived;

    public function __construct($data)
    {
        parent::hydrate($data, $this);
        $bm = new BoardsManager();
        $this->listLists = $bm->getLists($this->id);
        $this->listsArchived = $bm->getListsArchived($this->id);
        $this->cardsArchived = $bm->getCardsArchived($this->id);
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



    /**
     * Get the value of cardsArchived
     */
    public function getCardsArchived()
    {
        return $this->cardsArchived;
    }

    /**
     * Set the value of cardsArchived
     *
     * @return  self
     */
    public function setCardsArchived($cardsArchived)
    {
        $this->cardsArchived = $cardsArchived;

        return $this;
    }

    /**
     * Get the value of listsArchived
     */
    public function getListsArchived()
    {
        return $this->listsArchived;
    }

    /**
     * Set the value of listsArchived
     *
     * @return  self
     */
    public function setListsArchived($listsArchived)
    {
        $this->listsArchived = $listsArchived;

        return $this;
    }

    /**
     * Get the value of usersList
     */
    public function getUsersList()
    {
        $bm = new BoardsManager();
        return $bm->getUsers($this->id);
    }

    /**
     * Set the value of usersList
     *
     * @return  self
     */
    public function setUsersList($usersList)
    {
        $this->usersList = $usersList;;
        return $this;
    }
}
