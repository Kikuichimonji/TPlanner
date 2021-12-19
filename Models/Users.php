<?php

namespace Models;
use App\AbstractEntity;
use Models\UsersManager;

class Users extends AbstractEntity
{
  /**
   * @inheritdoc
   */
  protected $table = 'users';

  private $id;
  private $username;
  private $password;
  private $mail;
  private $role;
  private $dateCreation;
  private $color;
  private $listBoards;

  public function __construct($data)
  {
    parent::hydrate($data,$this);
    $um = new UsersManager();
    $this->listBoards = $um->getBoards($this->id);
  }
  
  public function __toString()
  {
    return "Cet utilisateur s'appel {$this->getUsername()} et est {$this->getRole()}";
  }

  /**
   * Get the value of id
   */ 
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */ 
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of mail
   */ 
  public function getMail()
  {
    return $this->mail;
  }

  /**
   * Set the value of mail
   *
   * @return  self
   */ 
  public function setMail($mail)
  {
    $this->mail = $mail;

    return $this;
  }

  /**
   * Get the value of role
   */ 
  public function getRole()
  {
    return $this->role;
  }

  /**
   * Set the value of role
   *
   * @return  self
   */ 
  public function setRole($role)
  {
    $this->role = $role;

    return $this;
  }

  /**
   * Get the value of password
   */ 
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */ 
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Get the value of username
   */ 
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * Set the value of username
   *
   * @return  self
   */ 
  public function setUsername($username)
  {
    $this->username = $username;

    return $this;
  }

  /**
   * Get the value of dateCreation
   */ 
  public function getDateCreation()
  {
    return $this->dateCreation;
  }

  /**
   * Set the value of dateCreation
   *
   * @return  self
   */ 
  public function setDateCreation($dateCreation)
  {
    $this->dateCreation = $dateCreation;

    return $this;
  }

  /**
   * Get the value of listBoards
   */ 
  public function getListBoards()
  {
    return $this->listBoards;
  }

  /**
   * Set the value of listBoards
   *
   * @return  self
   */ 
  public function setListBoards($listBoards)
  {
    $this->listBoards = $listBoards;

    return $this;
  }

  /**
   * Get the value of color
   */ 
  public function getColor()
  {
    return $this->color;
  }

  /**
   * Set the value of color
   *
   * @return  self
   */ 
  public function setColor($color)
  {
    $this->color = $color;

    return $this;
  }
}
