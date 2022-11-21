<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Gift extends CoreModel
{

  private $url_product;
  protected $name;
  private $price;
  private $description;
  private $url_image_product;
  private $preference;


  /**
   * Get the value of urlProduct
   */
  public function getUrlProduct()
  {
    return $this->url_product;
  }

  /**
   * Set the value of urlProduct
   *
   * @return  self
   */
  public function setUrlProduct($urlProduct)
  {
    $this->url_product = $urlProduct;

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
    return $this->url_image_product;
  }

  /**
   * Set the value of urlImageProduct
   *
   * @return  self
   */
  public function setUrlImageProduct($urlImageProduct)
  {
    $this->url_image_product = $urlImageProduct;

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

  /**
   * Récupére tous les cadeaux
   *
   * @return array
   */
  public function findAll(): array
  {
    $sql = '
          SELECT *
          FROM gift
      ';

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Lists::class);

    return $result;
  }

  /**
   * Affiche les cadeaux d'une liste
   *
   * @param [int] $id : identifiant d'une liste
   * @return array
   */
  public function findByListId($idList): array
  {
    $sql = "
          SELECT *
          FROM gift where lists_id = '$idList'
      ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Gift::class);

    return $result;
  }

  /**
   * Affiche un cadeau
   *
   * @param [int] $idGift : identifiant d'un cadeau
   * @return void
   */
  public function findOne($idGift)
  {
    $sql = "
          SELECT *
          FROM gift where id = '$idGift'
      ";

    $pdo = Database::getPDO();
    $pdoStatement = $pdo->query($sql);
    $result = $pdoStatement->fetchObject(Gift::class);

    $verif = $pdoStatement->rowCount();
    $badId = false;
    if ($verif <= 0) {
      $badId = true;
    }

    return $result;
  }

  /**
   * Ajoute un cadeau
   *
   * @param [int] $idList : identifiant d'une liste
   * @param [string] $urlProduct : lien du cadeau
   * @param [string] $name : nom du cadeau
   * @param [int] $price : prix du cadeau
   * @param [string] $description : description du cadeau
   * @param [string] $urlImgProduct : lien de l'image du cadeau
   * @param [int] $preference : préférence du cadeau
   * @return void
   */
  public function addGift($idList, $urlProduct, $name, $price, $description, $urlImgProduct, $preference)
  {
    $fields = [
      'lists_id' => $idList,
      'url_product' => $urlProduct,
      'name' => $name,
      'price' => $price,
      'url_image_product' => $urlImgProduct,
      'description' => $description
    ];

    if ($preference !== null) {
      $fields['preference'] = $preference;
    }

    $sql = "
          INSERT INTO gift (" . implode(", ", array_keys($fields)) . ")
          VALUES ('" . implode("', '", array_values($fields)) . "')
      ";
      
    $pdo = Database::getPDO();
    $pdo->exec($sql) or die(print_r($pdo->errorInfo(), true));
  }

  /**
   * Modifie un cadeau
   *
   * @param [type] $idList : identifiant d'une liste
   * @param [type] $urlProduct : lien du cadeau
   * @param [type] $name : nom du cadeau
   * @param [type] $price : prix du cadeau
   * @param [type] $description : description du cadeau
   * @param [type] $urlImgProduct : lien de l'image du cadeau
   * @param [type] $preference : préférence du cadeau
   * @return void
   */
  public function editGift($idList, $urlProduct, $name, $price, $description, $urlImgProduct, $preference)
  {
    $sql = "
          UPDATE gift set
          url_product = '$urlProduct',
          name = '$name',
          price = '$price',
          description = '$description',
          url_image_product = '$urlImgProduct',
          preference = '$preference',
          updated_at = NOW()
          where id = '$idList'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }

  /**
   * Supprime un cadeau
   *
   * @param [type] $idGift : identifiant d'un cadeau
   * @return void
   */
  public function deleteGift($idGift)
  {
    $sql = "
          DELETE from gift where id = '$idGift'
      ";

    $pdo = Database::getPDO();
    $pdo->query($sql);
  }
}
