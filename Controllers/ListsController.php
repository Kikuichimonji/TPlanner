<?php

namespace Controllers;

use Models\ListsManager;
use Models\CardsManager;


class ListsController extends Controller
{
    /**
     * ListsController constructor.
     */
    public function __construct() // check if the user is connected
    {
        $this->authRequired();
    }

    public function editPosition($list,$pos,$idBoard,$isArchive) //Function that change the list position
    {
        $lm = new ListsManager();
        $oldPos = $lm->getPos($list)['listPosition'];
        $lm->edit($list,$pos,$oldPos,$idBoard,$isArchive);
    }

    public function add($id,$title) //Function that add a new list
    {
        $lm = new ListsManager();
        $f_text= trim($title);
        $lm->add($id,$f_text);
    }

    public function deleteList($id,$pos,$board) //Function that delete a list
    {
        $lm = new ListsManager();
        return $lm->deleteList($id,$pos,$board);
    }

    public function archiveDeleteList($id,$board) //Function that delete a list from archive list
    {
        $lm = new ListsManager();
        return $lm->archiveDeleteList($id,$board);
    }

    public function updateListTitle($id,$text,$board) //Function that update the list title
    {
        $f_text= trim($text);
        $lm = new ListsManager();
        $lm->updateTitle($id,$f_text,$board);
    }
}
