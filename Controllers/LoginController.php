<?php

namespace Controllers;

use App\UserManager;
use Models\UserManager as ModelsUserManager;

class LoginController extends Controller
{
  /**
   * Affiche une vue.
   * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
   *
   * @return void
   */
  public function index()
  {
    $this->view('login.php', [
      'test' => 'Mon login !',
      'var' => 45,
    ]);
  }

  public function login($data)
  {
    // ...

    // $this->session()['id'] = ...;
    $um = new ModelsUserManager();
    $user = $um->getMembre($data['pseudo']);
    $this->session("id",$user->getId());
    $this->session('user',$user);

    /*echo 'loginController ';
    var_dump($user->getId());die();*/

    header("Location:dashboard.php");
    $this->view('dashboard.php', [
      'test' => 'Mon dasboard !',
      'user' => $this->session(),
    ]);

  }
}
