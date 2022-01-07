<?php

namespace Controllers;

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
    $this->view('admin.php', [
      'user' => $users,
    ]);
  }

}
