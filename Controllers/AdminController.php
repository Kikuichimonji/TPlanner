<?php

namespace Controllers;

use Models\BoardsManager;
use Models\UsersManager;


class AdminController extends Controller
{
  /**
   * Admincontroller constructor.
   */
  public function __construct()
  {
    // Vérifie si l'utilisateur est connecté sinon redirection
    //var_dump("ddd");die();
    $this->authRequired();
    $this->adminRequired();
  }

  /**
   * Affiche une vue.
   * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
   */
  public function index()
  {
    $um = new UsersManager();
    $users = $um->findAll();
    $bm = new BoardsManager();
    $boards = $bm->getOrphan();

    $this->view('admin.php', [
      'users' => $users,
      'boards' => $boards,
    ]);
  }

  public function deleteUser($id)
  {
    //var_dump($id);die();
    $um = new UsersManager();
    if($id != "null"){
      $result = $um->deleteUser($id,$um->getBoards($id));
      echo $result;
    }
    header("Location: admin~LP9fsDOQnEuHPRbTHfn5.php");
  }
}
