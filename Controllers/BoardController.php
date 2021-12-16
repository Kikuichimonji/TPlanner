<?php

namespace Controllers;

use Models\BoardManager;
use Models\UsersManager;
use Models\CardManager;


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
  public function index($idBoard)
  {
    $um = new UsersManager();
    //var_dump($_SESSION);die();
    $user = $um->getOneById($_SESSION['user']->getId());
    $bm = new BoardManager();
    $board = $bm->getOneById($idBoard);
    
    $this->view('board.php', [
      'user' => $user,
      'board' => $board,
    ]);
  }

}
