<?php

namespace Controllers;

use Models\ListsManager;


class ListsController extends Controller
{
    /**
     * ListsController constructor.
     */
    public function __construct() // check if the user is connected
    {
        $this->authRequired();
    }

    /**
    * Change list position
    *
    * @param int $list List ID
    * @param int $pos New list position
    * @param int $idBoard Board ID
    * @param bool $isArchive Do we archive it?
    * @return void
    */
    public function editPosition($list,$pos,$idBoard,$isArchive)
    {
        $lm = new ListsManager();
        $oldPos = $lm->getPos($list)['listPosition'];
        $lm->edit($list,$pos,$oldPos,$idBoard,$isArchive);
    }

    /**
    * Create a new list
    *
    * @param int $id Board ID
    * @param string $title List title
    * @return void
    */
    public function add($id,$title) //Function that add a new list
    {
        $lm = new ListsManager();
        $f_text= trim($title);
        $lm->add($id,$f_text);
    }

    /**
    * Delete a list
    *
    * @param int $id List ID
    * @param int $pos List position
    * @param int $board board ID
    * @return bool
    */
    public function deleteList($id,$pos,$board) 
    {
        $lm = new ListsManager();
        return $lm->deleteList($id,$pos,$board);
    }

    /**
    * Delete a list from archive list
    *
    * @param int $id List ID
    * @param int $board board ID
    * @return bool
    */
    public function archiveDeleteList($id,$board) 
    {
        $lm = new ListsManager();
        return $lm->archiveDeleteList($id,$board);
    }

    /**
    * Update the list's title
    *
    * @param int $id List ID
    * @param string $text List new title
    * @param int $board board ID
    * @return void
    */
    public function updateListTitle($id,$text,$board) 
    {
        $f_text= trim($text);
        $lm = new ListsManager();
        $lm->updateTitle($id,$f_text,$board);
    }
}
