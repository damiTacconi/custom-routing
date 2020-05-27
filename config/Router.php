<?php

namespace config;

require_once('../controller/IController.php');
use controller\IController;

class Router {
   public static function connect(Request $request) {
        if(is_callable(array($request->controller,$request->method))){
          if(empty($request->parameters))
            call_user_func(array($request->controller, $request->method));
          else
            call_user_func_array(array($request->controller,$request->method),
            array($request->parameters));
        }
        else echo 'ERROR 404 NOT FOUND';
   }


}
