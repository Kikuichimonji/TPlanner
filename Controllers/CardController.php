<?php

namespace Controllers;


use Models\CardsManager;


class CardController extends Controller
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

    public function add($id,$title)
    {
        $cm = new CardsManager();
        //var_dump($oldPos);die();
        $cm->add($id,$title);
    }
    public function edit($list,$pos)
    {
        //var_dump($oldPos);die();
        
    }

    public function deleteCard($id,$pos,$list)
    {
        $cm = new CardsManager();
        $cm->deleteCard($id,$pos,$list);
    }
}
