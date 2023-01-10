<?php

namespace App\Repository;

use PDO;
use App\Utils\Database;
use App\Models\Gift;
use Exception;

class GiftRepository
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getPDO();
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


    $pdoStatement = $this->pdo->query($sql);
    $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Gift::class, ['url_product', 'name', 'price', 'shop', 'url_image_product', 'rank', 'user_id']);

    return $result;
  }

  /**
   * affiche les cadeaux d'un utilisateur
   *
   * @param [int] $userId : identifiant de l'utilisateur
   * @return array
   */
  public function findByUserId($userId)
  {
    $sql = "
    SELECT *
    FROM gift where user_id = '$userId'
    ";

    $pdoStatement = $this->pdo->query($sql);
    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Gift::class, ['url_product', 'name', 'price', 'shop', 'url_image_product', 'rank', 'user_id']);
    $result = $pdoStatement->fetchAll();

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


    $pdoStatement = $this->pdo->query($sql);
    $pdoStatement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Gift::class, ['url_product', 'name', 'price', 'shop', 'url_image_product', 'rank', 'user_id']);
    $result = $pdoStatement->fetch();

    return $result;
  }

  /**
   * Ajoute un cadeau
   *
   * @param [string] $gift : différents champs du cadeau
   * @return void
   */
  public function save($gift)
  {
    if ($gift->getRank() !== null) {
      $fields['rank'] = $gift->getRank();
    }

    $sql = "
            INSERT INTO gift (
              url_product,
              name,
              price,
              shop,
              url_image_product,
              rank,
              created_at,
              updated_at,       
              user_id
            )
            VALUES (
              :url_product,
              :name,
              :price,
              :shop,
              :url_image_product,
              :rank,
              NOW(),
              NOW(),      
              :user_id
              )
           ";

    $pdoStatement = $this->pdo->prepare($sql);
    $pdoStatement->bindValue('url_product', $gift->getUrlProduct());
    $pdoStatement->bindValue('name', $gift->getName());
    $pdoStatement->bindValue('price', $gift->getPrice());
    $pdoStatement->bindValue('shop', $gift->getShop());
    $pdoStatement->bindValue('url_image_product', $gift->getUrlImageProduct());
    $pdoStatement->bindValue('rank', $gift->getRank());
    $pdoStatement->bindValue('user_id', $gift->getUserId());

    $result = $pdoStatement->execute();
    if (!$result) {
      throw new Exception($this->pdo->getMessage());
    }
  }

  /**
   * Modifie un cadeau
   *
   * @param [string] $gift : différents champs du cadeau
   * @return void
   */
  public function edit($gift)
  {
    $sql = "
            UPDATE gift SET 
              url_product = :url_product,
              name = :name,
              price = :price,
              shop = :shop,
              url_image_product = :url_image_product,
              rank = :rank,
              updated_at = NOW(),       
              user_id = :user_id
            WHERE 
              id = :id
          ";

    $pdoStatement = $this->pdo->prepare($sql);
    $pdoStatement->bindValue('url_product', $gift->getUrlProduct());
    $pdoStatement->bindValue('name', $gift->getName());
    $pdoStatement->bindValue('price', $gift->getPrice());
    $pdoStatement->bindValue('shop', $gift->getShop());
    $pdoStatement->bindValue('url_image_product', $gift->getUrlImageProduct());
    $pdoStatement->bindValue('rank', $gift->getRank());
    $pdoStatement->bindValue('user_id', $gift->getUserId());
    $pdoStatement->bindValue('id', $gift->getId());

    $result = $pdoStatement->execute();
    if (!$result) {
      throw new Exception($this->pdo->getMessage());
    }
  }

  /**
   * Supprime un cadeau
   *
   * @param [type] $idGift : identifiant d'un cadeau
   * @return void
   */
  public function delete($idGift)
  {
    $sql = "
          DELETE from gift where id = '$idGift'
      ";

    $this->pdo->query($sql);
  }
}
