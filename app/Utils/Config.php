<?php

namespace App\Utils;

// Design Pattern : Singleton
class Config {

  private $config;
  private static $_instance;
  private function __construct() {
      try {
        $this->config = parse_ini_file(__DIR__.'/../config.ini');
      }
      catch(\Exception $exception) {
          echo $exception->getMessage().'<br>';
          exit;
      }
  }
  // the unique method you need to use
  public static function getInstance() {
      // If no instance => create one
      if (empty(self::$_instance)) {
          self::$_instance = new Config();
      }
      return self::$_instance->config;
  }

}