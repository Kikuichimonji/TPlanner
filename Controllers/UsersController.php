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
    $id = $this->isAuthorised() ? ($id ? $id : $_SESSION['user']->getId()) : $_SESSION['user']->getId(); //$id only exist if the user is an admin, we also check if the admin check it's profile from the menu
    $user = $um->getOneById($id);

    $this->view('user.php', [
      'user' => $user,
    ]);
  }

}
