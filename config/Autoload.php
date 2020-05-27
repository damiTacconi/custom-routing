<?php

namespace config;

class Autoload {

  public static function autoload(){
    spl_autoload_register(function ($class) {
      $classPath = ROOT . str_replace('\\', '/' ,$class) . '.php';

      if(file_exists($classPath))
              include_once $classPath;
      else header("Location: /");
    });
  }
}
