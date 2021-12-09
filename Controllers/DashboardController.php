<?php

namespace Controllers;


class DashboardController extends Controller
{
  /**
   * HomeController constructor.
   */
  public function __construct()
  {
    /*echo "dashboardcontroler ";
    var_dump($this->session());die();*/
    // Vérifie si l'utilisateur est connecté sinon redirection
    $this->authRequired();
  }

  /**
   * Affiche une vue.
   * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
   */
  public function index()
  {
    //var_dump($_SESSION);die();
    $this->view('dashboard.php', [
        'user' => $_SESSION['user'],
    ]);
  }

}
