<?php

namespace Controllers;

use Models\UsersManager;


class UsersController extends Controller
{
  /**
   * HomeController constructor.
   */
  public function __construct()
  {
    // Vérifie si l'utilisateur est connecté sinon redirection
    //var_dump("ddd");die();
    $this->authRequired();
  }

  /**
   * Affiche une vue.
   * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
   */
  public function index($id = null)
  {
    $um = new UsersManager();
    //var_dump($_SESSION);die();
    $id = $this->isAuthorised() ? $id : $_SESSION['user']->getId(); //$id only exist if the user is an admin
    $user = $um->getOneById($id);
    
    $this->view('user.php', [
      'user' => $user,
    ]);
  }

}
