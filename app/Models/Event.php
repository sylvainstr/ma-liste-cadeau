<?php

namespace App\Models;

use App\Models\CoreModel;

class Event extends CoreModel
{
  private $name;
  private $description;
  private $target_user;
  private $created_by;
  private $end_at;

  public function __construct($name, $description, $target_user, $created_by, $end_at)
  {
    $this->name = $name;
    $this->description = $description;
    $this->target_user = $target_user;
    $this->created_by = $created_by;
    $this->end_at = $end_at;
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
   * Get the value of targetUser
   */ 
  public function getTargetUser()
  {
    return $this->target_user;
  }

  /**
   * Set the value of targetUser
   *
   * @return  self
   */ 
  public function setTargetUser($target_user)
  {
    $this->target_user = $target_user;

    return $this;
  }

  /**
   * Get the value of created_by
   */ 
  public function getCreatedBy()
  {
    return $this->created_by;
  }

  /**
   * Set the value of created_by
   *
   * @return  self
   */ 
  public function setCreatedBy($created_by)
  {
    $this->created_by = $created_by;

    return $this;
  }

  /**
   * Get the value of end_at
   */ 
  public function getEndAt()
  {
    return $this->end_at;
  }

  /**
   * Set the value of end_at
   *
   * @return  self
   */ 
  public function setEndAt($end_at)
  {
    $this->end_at = $end_at;

    return $this;
  }
}
