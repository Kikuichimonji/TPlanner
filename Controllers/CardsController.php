<?php

namespace Controllers;


use Models\CardsManager;


class CardsController extends Controller
{
    /**
     * CardsController constructor.
     */
    public function __construct()  // check if the user is connected
    {
        $this->authRequired();
    }

    /**
     * Add a new card to the list
     * @param int $id The list ID
     * @param string $title The title of the card 
     * @param int $idBoard The board ID
     */
    public function add($id, $title, $idBoard)
    {
        $cm = new CardsManager();
        $f_text = trim($title);
        $cm->add($id, $f_text, $idBoard);
    }

    public function editCardDesc($id, $text, $idBoard) //Function that change the card Description
    {
        $f_text = trim($text);
        $cm = new CardsManager();
        $cm->editCardDesc($id, $f_text, $idBoard);
    }

    public function deleteCard($id, $pos, $list, $idBoard) //Function that delete the card
    {
        $cm = new CardsManager();
        $cm->deleteCard($id, $pos, $list, $idBoard);
    }

    public function updateCardTitle($id, $text, $board)//Function that update the card title
    {
        $f_text = trim($text);
        $lm = new CardsManager();
        $lm->updateTitle($id, $f_text, $board);
    }
}
