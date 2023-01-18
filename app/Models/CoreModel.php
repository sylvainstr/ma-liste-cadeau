<?php

namespace App\Models;

class CoreModel
{
  protected $id;
  protected $created_at;
  protected $updated_at;
  

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
   * Get the value of created_at
   */ 
  public function getCreatedAt()
  {
    return $this->created_at;
  }

  /**
   * Set the value of created_at
   *
   * @return  self
   */ 
  public function setCreatedAt($created_at)
  {
    $this->created_at = $created_at;

    return $this;
  }

  /**
   * Get the value of updated_at
   */ 
  public function getUpdatedAt()
  {
    return $this->updated_at;
  }

  /**
   * Set the value of updated_at
   *
   * @return  self
   */ 
  public function setUpdatedAt($updated_at)
  {
    $this->updated_at = $updated_at;

    return $this;
  }

}