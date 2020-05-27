<?php

namespace controller;

class PersonController implements IController {

  public function index(){

  }
  public function message($request){
      ['name' => $name , 'message' => $message] = $request;
      echo "${name}!! Tienes un mensaje: ${message}";
  }
}
