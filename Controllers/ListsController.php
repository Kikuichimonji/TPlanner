<?php

namespace Controllers;

use Models\ListsManager;
use Models\CardsManager;


class ListsController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        // Vérifie si l'utilisateur est connecté sinon redirection
        $this->authRequired();
    }

    /**
     * Affiche une vue.
     * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
     */
    public function index()
    {
    }

    public function editCardsPosition($card,$list,$oldList,$pos,$idBoard)
    {
        $cm = new CardsManager();
        $oldPos = $cm->getPos($card)['positions'];
        //var_dump($isChanging);die();
        $cm->edit($card,$list,$oldList,$pos,$oldPos,$idBoard);
    }
    public function editPosition($list,$pos,$idBoard)
    {
        $lm = new ListsManager();
        $oldPos = $lm->getPos($list)['listPosition'];
        //var_dump($oldPos);die();
        $lm->edit($list,$pos,$oldPos,$idBoard);
    }

    public function add($id,$title)
    {
        $lm = new ListsManager();
        //var_dump($oldPos);die();
        $f_text= trim(filter_var($title,FILTER_SANITIZE_SPECIAL_CHARS));
        $lm->add($id,$f_text);
    }

    public function deleteList($id,$pos,$board)
    {
        $lm = new ListsManager();
        $lm->deleteList($id,$pos,$board);
    }

    public function updateListTitle($id,$text,$board)
    {
        $f_text= trim(filter_var($text,FILTER_SANITIZE_SPECIAL_CHARS));
        $lm = new ListsManager();
        $lm->updateTitle($id,$f_text,$board);
    }
}
