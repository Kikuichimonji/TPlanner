<?php

namespace Controllers;

class WelcomeController extends Controller
{
  /**
   * Affiche une vue.
   * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
   *
   * @return void
   */
  public function index()
  {
    $this->view('index.php', [
      'test' => 'Mon texte',
      'var' => 45,
    ]);
  }
}
