<?php

namespace Controllers;

use Models\UserManager;


class UserController extends Controller
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
    $user = new UserManager();
    $users = $user->findAll();
    
    $this->view('user.php', [
      'users' => $users,
    ]);
  }

}
