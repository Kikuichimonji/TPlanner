<?php

namespace Controllers;

class Controller
{
  /**
   * View folder path
   */
  const VIEW_PATH = '/Public/Views/';

  /**
   * Where the user is redirected if not connected
   */
  const REDIRECT_GUEST = 'login.php';

  /**
   * Check if the session has been started
   * @var bool
   */
  static protected $session = false;

  /**
   * Check if the user is connected
   * See isAuth() function under
   * @var null
   */
  static protected $isAuth = null;

  /**
   * Check if the user is an admin
   * See isAdmin() function under
   * @var null
   */
  static protected $isAdmin = null;

  /**
   * Import a view file
   *
   * @param string $fileName
   * @param array $data Contain datas given throught the controller
   * @return void
   */
  protected function view(string $fileName, array $data = []): void
  {
    $filePath = ROOT.self::VIEW_PATH.$fileName;
    
    if (file_exists($filePath)) {
      require $filePath;
    }else{
      require ROOT.self::VIEW_PATH."404.php";
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
  protected function adminRequired(): void
  {
    if ( !$this->isAuthorised() ) {
      header('Location: '.self::REDIRECT_GUEST.'?err=1');
      exit();
    }
  }

  protected function isAuthorised()
  {
    return in_array("admin",$this->getCurrentUserRole());
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
    return $this->session()['id'] ?? null;
  }

  /**
   * @return array
   */
  protected function getCurrentUserRole()
  {
    return json_decode($this->session()['user']->getRole()) ?? null;
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
      self::$session = true;
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

  protected function isDisabled($user) 
  {
    try{
        if(is_array(json_decode($user->getRole()))){
          return in_array("user",json_decode($user->getRole()));
        }else{
          return false;
        }

    }catch(\Exception $e){
      echo $e->getMessage();
      die();
    }
  }
}
