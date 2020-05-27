<?php

namespace config;

use config\Route;

class Request {
    public $controller = 'controller\HomeController';
    public $method = 'index';
    public $parameters = [];

    function __construct(){
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];

        switch ($requestMethod) {
          case 'GET':
              $this->setMandatoryData(Route::urlMatch($url));
            break;
          case 'POST':
              $this->setMandatoryData(Route::urlMatch($url, 'POST'));
              $this->checkAndSetPostData();
            break;
          case 'DELETE':
              $this->setMandatoryData(Route::urlMatch($url, 'DELETE'));
              $this->checkAndSetPostData();
          case 'PUT':
              $this->setMandatoryData(Route::urlMatch($url, 'PUT'));
              $this->checkAndSetPostData();
          default:
            break;
        }
    }

    private function checkAndSetPostData(){
      if(!empty($_POST))
        $this->parameters = array_merge($this->parameters, $_POST);
      if(!empty($_FILES))
        $this->parameters = array_merge($this->parameters, $_FILES);
    }

    private function setMandatoryData($result){
        if(!empty($result)){
          $this->controller = 'controller\\'.$result['controller'];
          $this->method = $result['method'];
            if(!empty($result['parameters']))
            {
              foreach ($result['parameters'] as $key => $value)
                $this->parameters[$key]=$value;
            }
        }
        else {
          $this->method = "notFound";
        }
    }
}
