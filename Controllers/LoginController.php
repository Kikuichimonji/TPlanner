<?php

namespace Controllers;

use Models\UsersManager;

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
    if(isset($this->session()['auth'])){
      header("Location: dashboard.php");
      die();
    }
    $token = hash_hmac("sha256","tralala",$this->getToken());
    $this->view('login.php', [
      'test' => 'Mon login !',
      'token' => $token,
    ]);
  }

  public function login($data)
  {
    if(!$this->csrfCheck($data['token'])){
      header("Location:index.php");
    }
    
    $um = new UsersManager();
    $user = $um->getOneByUsername($data['pseudo']);
    $this->session("id",$user->getId());
    $this->session('user',$user);
    $this->session('auth',true);

    /*echo 'loginController ';
    var_dump($user->getId());die();*/

    header("Location:dashboard.php");
   /* $this->view('dashboard.php', [
      'test' => 'Mon dasboard !',
      'user' => $this->session('user'),
    ]);*/

  }
}
