<?php

namespace Models;
use App\AbstractEntity;


class Note extends AbstractEntity
{
  /**
   * @inheritdoc
   */
  protected $table = 'notes';

  public $id;
  public $user_id;
  public $title;
  public $text;

  public function __construct($data)
  {
    parent::hydrate($data,$this);
  }
  /**
   * @param int|string $userId
   * @return array
   */
  public function userNotes($userId)
  {
    $req = $this->db()->prepare("SELECT * FROM {$this->getTable()} WHERE user_id = :user_id");
    $req->execute([
      ':user_id' => $userId,
    ]);
    $this->closeConnection();

    return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * @inheritDoc
   */
  public function find($id): Model
  {
    // TODO: Implement find() method.
  }

  /**
   * @inheritDoc
   */
  public function fetch($id): Model
  {
    // TODO: Implement fetch() method.
  }

  /**
   * @inheritDoc
   */
  /*public function hydrate($data): bool
  {
    // TODO: Implement hydrate() method.
  }*/
}
