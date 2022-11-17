<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Gift extends CoreModel
{

  private $urlProduct;
  protected $name;
  private $price;
  private $description;
  private $urlImageProduct;
  private $preference;


  /**
   * Get the value of urlProduct
   */ 
  public function getUrlProduct()
  {
    return $this->urlProduct;
  }

  /**
   * Set the value of urlProduct
   *
   * @return  self
   */ 
  public function setUrlProduct($urlProduct)
  {
    $this->urlProduct = $urlProduct;

    return $this;
  }

  /**
   * Get the value of name
   */ 
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set the value of name
   *
   * @return  self
   */ 
  public function setName(string $name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the value of price
   */ 
  public function getPrice()
  {
    return $this->price;
  }

  /**
   * Set the value of price
   *
   * @return  self
   */ 
  public function setPrice(int $price)
  {
    $this->price = $price;

    return $this;
  }

  /**
   * Get the value of description
   */ 
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @return  self
   */ 
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of urlImageProduct
   */ 
  public function getUrlImageProduct()
  {
    return $this->urlImageProduct;
  }

  /**
   * Set the value of urlImageProduct
   *
   * @return  self
   */ 
  public function setUrlImageProduct($urlImageProduct)
  {
    $this->urlImageProduct = $urlImageProduct;

    return $this;
  }

  /**
   * Get the value of preference
   */ 
  public function getPreference()
  {
    return $this->preference;
  }

  /**
   * Set the value of preference
   *
   * @return  self
   */ 
  public function setPreference(int $preference)
  {
    $this->preference = $preference;

    return $this;
  }

  public function findAll(): array
  {
    $sql = '
          SELECT *
          FROM lists
      ';

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Lists::class);

    return $result;
  }

  public function findById($id): array
  {
    $sql = "
          SELECT *
          FROM lists where user_id = '$id'
      ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Lists::class);

    return $result;
  }

  public function findOne($id)
  {
    $sql = "
          SELECT *
          FROM lists where id = '$id'
      ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchObject(Lists::class);

    $verif = $pdoStatement->rowCount();
    $badId = false;
    if ($verif <= 0) {
      $badId = true;
    }

    return $result;
  }

  public function addList($event, $title, $subtitle, $message)
  {
    $sql = "
          INSERT INTO lists (event, title, subtitle, message, user_id)
          VALUES ('$event', '$title', '$subtitle', '$message', " . $_SESSION["user"]["id"] . ")
      ";

    $pdo = Database::getPDO();
    $pdo->exec($sql);
  }

  public function editList($id, $event, $title, $subtitle, $message)
  {
    $sql = "
          UPDATE lists set
          event = '$event',
          title = '$title',
          subtitle = '$subtitle',
          message = '$message',
          updated_at = NOW()
          where id = '$id'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }

  public function deleteList($id)
  {
    $sql = "
          DELETE from lists where id = '$id'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }
}