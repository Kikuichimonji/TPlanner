<?php

namespace Controllers;

class Controller
{
  /**
   * Chemin du dossier des vues à partir de la racine
   */
  const VIEW_PATH = '/Views/';

  /**
   * Page de redirection si non connecté
   */
  const REDIRECT_GUEST = 'login.php';

  /**
   * Détermine si la session a déjà été "start"
   *
   * @var bool
   */
  static protected $session = false;

  /**
   * Détermine si l'utilisateur est connecté dans la session
   * Voir function isAuth() plus bas
   *
   * @var null
   */
  static protected $isAuth = null;

  /**
   * Import le fichier PHP d'une vue
   *
   * @param string $fileName
   * @param array $data Contient les données fournies par le contrôleur
   * @return void
   */
  protected function view(string $fileName, array $data = []): void
  {
    $filePath = ROOT . self::VIEW_PATH . $fileName;

    if (file_exists($filePath)) {
      require $filePath; // Importe/Charge le code php de la vue
    }
  }

  /**
   * Redirige la requête HTTP utilisateur si l'utilisateur n'est pas connecté
   *
   * @return void
   */
  protected function authRequired(): void
  {
    if ( !$this->isAuth() ) {
      header('Location: '.self::REDIRECT_GUEST.'?err=1');
      exit();
    }
  }

  /**
   * Détermine si l'utilisateur est authentifié via les données de sessions.
   *
   * @return bool
   */
  protected function isAuth()
  {
    return empty(self::$isAuth)
      ? (self::$isAuth = !empty($this->getCurrentUserId()))
      : self::$isAuth;
  }

  /**
   * @return int|string|null
   */
  protected function getCurrentUserId()
  {
    /*var_dump('controler');
    var_dump($this->session());die();*/
    return $this->session()['id'] ?? null;
  }

  /**
   * La fonction renvoie une référence à $_SESSION
   * On peut se servir d'elle un peu comme si ont utilisé $_SESSION
   *
   * @return array
   */
  protected function session($key = null,$value = null)
  {
    // Activation de la session
    // + référence vers $_SESSION
    if ( !self::$session ) {
      session_start();
      self::$session = TRUE;
    }
    if($key){
      $_SESSION[$key] = $value;
    }

    return $_SESSION;
  }

  /**
   * Create a random token
   * 
   * @return void
   */
  protected function setToken() //CSRF Token creation
  {
    /*var_dump($this->session());die();*/
    $this->session();
    if(isset($_SESSION["token"])){
      if($_SESSION["token"] === null){
        return $this->session('token',bin2hex(random_bytes(32)));
      }
    }else{
      return $this->session('token',bin2hex(random_bytes(32)));
    }
  }

  /**
   * Get the actual CSRF token of the user
   * 
   * @return string
   */
  protected function getToken() //CSRF Token recuperation
  {
    //var_dump($this->session());die();
    //$this->session();
    if(isset($_SESSION["token"])){
      return $_SESSION["token"];
    }else{
      $this->setToken();
      //var_dump($this->session());die();
    }
  }

  /**
   * Compare the CSRF token between the user and the form
   * 
   * 
   */
  protected function csrfCheck($token) //CSRF Token recuperation
  {
    try{
      if(!empty($_POST)){
        if(isset($_POST['token']) && !hash_equals($_POST['token'],$token)){
          return false;
        }
        return true;
      }
    }catch(\Exception $e){
      echo $e->getMessage();
      die();
    }
  }
}
