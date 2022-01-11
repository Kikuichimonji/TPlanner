<?php

namespace Controllers;

use Models\BoardsManager;
use Models\UsersManager;
use Models\CardsManager;
use Models\User;

class BoardsController extends Controller
{
  /**
   * HomeController constructor.
   */
  public function __construct()
  {
    // Vérifie si l'utilisateur est connecté sinon redirection
    $this->authRequired();
    // $this->isAuthorised(); 
  }

  /**
   * Affiche une vue.
   * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
   */
  public function index($idBoard = null)
  {
    $um = new UsersManager();
    $user = $um->getOneById($_SESSION['user']->getId());
    if($idBoard !== null){
      
      $bm = new BoardsManager();
      $board = $bm->getOneById($idBoard);
      if($board){
        $this->view('board.php', [
          'user' => $user,
          'board' => $board,
        ]);
      }else{
        $this->view('dashboard.php', [
          'user' => $user
        ]);
      }
    }else{
      $this->view('dashboard.php', [
        'user' => $user
      ]);
    }
  }

  public function updateTitle($id,$text)
  {
    $f_text= trim($text);
    $bm = new BoardsManager();
    $bm->updateTitle($id,$f_text);
  }

  public function inviteUser($idBoard,$mail)
  {
    $f_mail= trim($mail);
    $um = new UsersManager();
    $bm = new BoardsManager();
    $user = $um->getOneByMail($f_mail);
    $isInvited = false;
    if($user !== null && $user->getId() != $_SESSION['user']->getId()){
      $boards = $user->getInvitedBoards();
      foreach($boards as $board){
        $isInvited = $board->getId() == $idBoard ? true : false ;
      }
      if(!$isInvited){
        $bm = new BoardsManager();
        $bm->inviteUser($idBoard,$user->getId());
      }else{
        return "errorSameUser";
      }
    }else{
      if($user !== null){
        if($user->getId() == $_SESSION['user']->getId()){
          return "errorSameUser";
        }
      }else{
        return "errorNoUser";
      }
      
    }
    
  }

  public function reload($id)
  {
    $um = new UsersManager();
    $user = $um->getOneById($_SESSION['user']->getId());
    $bm = new BoardsManager();
    $board = $bm->getOneById($id);
    
    $this->view('boardContent.php', [
      'user' => $user,
      'board' => $board,
    ]);
  }
}
