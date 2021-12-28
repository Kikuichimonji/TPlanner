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
    public function editCardDesc($id,$text)
    {
        //var_dump($id,$text);die();
        $f_text= trim(filter_var($text,FILTER_SANITIZE_STRING));
        $cm = new CardsManager();
        $cm->editCardDesc($id,$f_text);
    }

    public function deleteCard($id,$pos,$list)
    {
        $cm = new CardsManager();
        $cm->deleteCard($id,$pos,$list);
    }
}
