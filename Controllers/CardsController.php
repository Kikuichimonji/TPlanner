<?php

namespace Controllers;


use Models\CardsManager;


class CardsController extends Controller
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

    public function add($id,$title,$idBoard)
    {
        $cm = new CardsManager();
        $f_text= trim(filter_var($title,FILTER_SANITIZE_SPECIAL_CHARS));
        //var_dump($title);die();
        $cm->add($id,$f_text,$idBoard);
    }
    public function editCardDesc($id,$text,$idBoard)
    {
        //var_dump($id,$text);die();
        $f_text= trim(filter_var($text,FILTER_SANITIZE_SPECIAL_CHARS));
        $cm = new CardsManager();
        $cm->editCardDesc($id,$f_text,$idBoard);
    }

    public function deleteCard($id,$pos,$list,$idBoard)
    {
        $cm = new CardsManager();
        $cm->deleteCard($id,$pos,$list,$idBoard);
    }
}
