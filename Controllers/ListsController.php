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

    public function edit($card,$list,$pos)
    {

        $cm = new CardManager();
        $oldPos = $cm->getPos($card)['positions'];
        //var_dump($oldPos);die();
        $cm->edit($card,$list,$pos,$oldPos);
    }
}
