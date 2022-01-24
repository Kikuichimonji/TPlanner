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
     * @return void
     */
    public function add($id, $title, $idBoard)
    {
        $cm = new CardsManager();
        $f_text = trim($title);
        $cm->add($id, $f_text, $idBoard);
    }

    /**
     * Change the card infos
     * @param int $id The card ID
     * @param string $text The description of the card 
     * @param int $idBoard The board ID
     * @param string $color The hexa code of the card
     * @return void
     */
    public function editCardDesc($id, $text, $idBoard,$color)
    {
        $f_text = trim($text);
        $cm = new CardsManager();
        $cm->editCardDesc($id, $f_text, $idBoard,$color);
    }

    /**
     * Delete the card
     * @param int $id The card ID
     * @param int $pos The position of the card inside the list
     * @param int $list The list ID
     * @param int $idBoard The board ID
     * @return void
     */
    public function deleteCard($id, $pos, $list, $idBoard)
    {
        $cm = new CardsManager();
        return $cm->deleteCard($id, $pos, $list, $idBoard);
    }

    /**
     * Update the card title
     * @param int $id The card ID
     * @param string $text The new title
     * @param int $board The board ID
     * @return void
     */
    public function updateCardTitle($id, $text, $board)
    {
        $f_text = trim($text);
        $lm = new CardsManager();
        $lm->updateTitle($id, $f_text, $board);
    }

    /**
     * Change the card position
     * @param int $card Card id
     * @param int $list List id where the card landed
     * @param int $oldList List id where the card came from
     * @param int $pos Card position
     * @param int $idBoard Board id
     * @param bool $isArchive If the card will be archived
     */
    public function editCardsPosition($card,$list,$oldList,$pos,$idBoard,$isArchive)
    {
        $cm = new CardsManager();
        $oldPos = $cm->getPos($card)['positions'];
        $cm->edit($card,$list,$oldList,$pos,$oldPos,$idBoard,$isArchive);
    }
}
