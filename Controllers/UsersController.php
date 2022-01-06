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
    $user = new UsersManager();
    $users = $user->findAll();
    
    $this->view('user.php', [
      'users' => $users,
    ]);
  }

}
