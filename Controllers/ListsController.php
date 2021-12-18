<?php

namespace Controllers;

use Models\ListsManager;
use Models\CardManager;


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

    public function editCards($card,$list,$oldList,$pos)
    {
        $cm = new CardManager();
        $oldPos = $cm->getPos($card)['positions'];
        //$isChanging = $list != $oldList;
        //var_dump($isChanging);die();
        $cm->edit($card,$list,$oldList,$pos,$oldPos);
    }
    public function edit($list,$pos)
    {
        $lm = new ListsManager();
        $oldPos = $lm->getPos($list)['listPosition'];
        //var_dump($oldPos);die();
        $lm->edit($list,$pos,$oldPos);
    }
}
