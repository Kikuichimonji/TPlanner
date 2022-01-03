<?php

namespace Controllers;

use Models\BoardsManager;
use Models\UsersManager;
use Models\CardsManager;


class BoardController extends Controller
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
  public function index($idBoard = null)
  {
    $um = new UsersManager();
    $user = $um->getOneById($_SESSION['user']->getId());
    if($idBoard !== null){
      
      $bm = new BoardsManager();
      $board = $bm->getOneById($idBoard);
      if($board){
        $this->view('board.php', [
          'user' => $user,
          'board' => $board,
        ]);
      }else{
        $this->view('dashboard.php', [
          'user' => $user
        ]);
      }
    }else{
      $this->view('dashboard.php', [
        'user' => $user
      ]);
    }
  }

  public function updateTitle($id,$text)
  {
    $f_text= trim(filter_var($text,FILTER_SANITIZE_SPECIAL_CHARS ));
    //var_dump($f_text);die();
    $bm = new BoardsManager();
    $bm->updateTitle($id,$f_text);
  }

  public function reload($id)
  {
    $um = new UsersManager();
    $user = $um->getOneById($_SESSION['user']->getId());
    $bm = new BoardsManager();
    $board = $bm->getOneById($id);
    
    $this->view('boardContent.php', [
      'user' => $user,
      'board' => $board,
    ]);
  }
}
