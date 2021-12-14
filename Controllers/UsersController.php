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
    $this->authRequired();
  }

  /**
   * Affiche une vue.
   * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
   */
  public function index()
  {
    $um = new UsersManager();
    //var_dump($_SESSION);die();
    $user = $um->getOneById($_SESSION['user']->getId());
    
    $this->view('user.php', [
      'user' => $user,
    ]);
  }

}
