<?php

namespace App\Models;

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
}