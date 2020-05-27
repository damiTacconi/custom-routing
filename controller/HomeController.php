<?php

namespace controller;

class HomeController implements IController{

  public function index(){
     require_once(URL_VIEW . 'index.php');
  }

  public function greetings($request){
    echo "Hola {$request['name']}";
  }

  public function info($request){
    ['name' => $name, 'age' => $age] = $request;
    echo "Hola ${name}! tienes ${age} años !";
  }
}
