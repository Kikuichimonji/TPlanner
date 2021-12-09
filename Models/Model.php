<?php

namespace Models;

use PDO;
use PDOException;
use App\AbstractEntity;

abstract class Model extends AbstractEntity
{
  /**
   * @var PDO
   */
  protected $db;

  /**
   * @var string
   */
  protected $table;

  /**
   * fetch() + hydrate()
   *
   * @return self
   */
  abstract public function find($id): self;

  /**
   * Recupère les données d'une ligne en base de données via son $id
   *
   * @return self
   */
  abstract public function fetch($id): self;

  /**
   * Hydrate l'instance d'un object via un fetch
   *
   * @param array|object
   * @return bool
   */
//  abstract public function hydrate($data): bool;

  /**
   * @return PDO
   */
  public function db()
  {
    if ($this->db === null) {
      $this->openConnection();
    }

    return $this->db;
  }

  /**
   * @return array
   */
  public function all()
  {
    $req = $this->db()->prepare("SELECT * FROM ".$this->getTable());
    $req->execute();
    $this->closeConnection();

    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * @return void
   */
  public function closeConnection()
  {
    $this->db = null;
  }

  /**
   * @return string
   */
  public function getTable()
  {
    if ($this->table === null) {
      echo 'Error: Table is not defined !';
      exit();
    }

    return $this->table;
  }

  /**
   * @return void
   */
  protected function openConnection()
  {
    $dsn = 'mysql:host=localhost;port=3306;dbname=mysiteweb';
    try {
      $this->db = new PDO($dsn, 'admin', 'rootroot');
    } catch (PDOException $e) {
      echo $e->getMessage() . '<br>';
      exit();
    }
  }
}
