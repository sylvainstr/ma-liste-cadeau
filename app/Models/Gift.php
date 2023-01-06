<?php

namespace App\Models;

use App\Models\CoreModel;
use DateTime;

class Gift extends CoreModel
{

  private $url_product;
  private $name;
  private $price;
  private $shop;
  private $url_image_product;
  private $rank;
  private $createdAt;
  private $updatedAt;
  private $user_id;

  public function __construct($url_product, $name, $price, $shop, $url_image_product, $rank, $user_id)
  {
    $this->url_product = $url_product;
    $this->name = $name;
    $this->price = $price;
    $this->shop = $shop;
    $this->url_image_product = $url_image_product;
    $this->rank = $rank;
    $this->user_id = $user_id;
    $this->createdAt = new DateTime();
    $this->updatedAt = new DateTime();
  }

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
  public function setUrlProduct($url_product)
  {
    $this->url_product = $url_product;

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
  public function setName($name)
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
  public function setPrice($price)
  {
    $this->price = $price;

    return $this;
  }

  /**
   * Get the value of shop
   */
  public function getShop()
  {
    return $this->shop;
  }

  /**
   * Set the value of shop
   *
   * @return  self
   */
  public function setShop($shop)
  {
    $this->shop = $shop;

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
  public function setUrlImageProduct($url_image_product)
  {
    $this->url_image_product = $url_image_product;

    return $this;
  }

  /**
   * Get the value of rank
   */
  public function getRank()
  {
    return $this->rank;
  }

  /**
   * Set the value of rank
   *
   * @return  self
   */
  public function setRank($rank)
  {
    $this->rank = $rank;

    return $this;
  }

  /**
   * Get the value of createdAt
   */
  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  /**
   * Set the value of createdAt
   *
   * @return  self
   */
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  /**
   * Get the value of updatedAt
   */
  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  /**
   * Set the value of updatedAt
   *
   * @return  self
   */
  public function setUpdatedAt($updatedAt)
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  /**
   * Get the value of userId
   */
  public function getUserId()
  {
    return $this->user_id;
  }

  /**
   * Set the value of userId
   *
   * @return  self
   */
  public function setUserId($user_id)
  {
    $this->user_id = $user_id;

    return $this;
  }
}
