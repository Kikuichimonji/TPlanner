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
    if($idBoard){
      
      $bm = new BoardsManager();
      $board = $bm->getOneById($idBoard);
      
      $this->view('board.php', [
      'user' => $user,
      'board' => $board,
    ]);
    }else{
      $this->view('dashboard.php', [
        'user' => $user
      ]);
    }
  }

  public function updateTitle($id,$text)
  {
    $bm = new BoardsManager();
    $bm->updateTitle($id,$text);
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
