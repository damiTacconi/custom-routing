<?php

namespace config;

class Route {
    private static $endpoints = [
      'GET'    => [],
      'POST'   => [],
      'DELETE' => [],
      'PUT'    => []
    ];

    private static $allowsParams = [
      'ANY'     => '[a-zA-Z0-9\_\-]+',
      'CHARS'  => '[a-zA-Z\_\-]+',
      'INTEGERS' => '[0-9]+'
    ];

    private static function cleanMatches($matches){
      $array = array();

      foreach($matches as $key => $value)
        $array[$key] = explode(':',$value)[0];

      return $array;
    }

    private static function setRoute($path,$controller, $method){
        preg_match_all("/{(.*?)}/", $path, $matches);
        return [
          'regex'      => self::getRegex($path),
          'controller' => $controller,
          'method'     => $method,
          'parameters' => self::cleanMatches($matches[1])
        ];
    }

    public static function get($path , $controller, $method){
        array_push(self::$endpoints['GET'], self::setRoute($path,$controller,$method));
    }

    public static function post($path, $controller, $method){
        array_push(self::$endpoints['POST'], self::setRoute($path,$controller,$method));
    }

    public static function postMatch($requestUrl){
      return self::getData(self::$endpoints['POST'], $requestUrl);
    }

    public static function getMatch($requestUrl){
      return self::getData(self::$endpoints['GET'], $requestUrl);
    }

    private static function getData($array, $requestUrl){
      $data = [];
      foreach ($array as $value) {
        if(preg_match($value['regex'], $requestUrl,$matches)){
          $data['controller'] = $value['controller'];
          $data['method']     = $value['method'];

          foreach ($value['parameters'] as $param) {
            $data['parameters'][$param] = $matches[$param];
          }
          break;
        }
      }
      return $data;
    }
    
    private static function getRegex($pattern){
      if (preg_match('/[^-:\/_{}()a-zA-Z\d]/', $pattern))
          return false; // Invalid pattern
      // Create capture group for '{parameter}'
      $pattern = self::replaceWith('any'    , self::$allowsParams['ANY'], $pattern, true);
      $pattern = self::replaceWith('string' , self::$allowsParams['CHARS'], $pattern);
      $pattern = self::replaceWith('integer', self::$allowsParams['INTEGERS'], $pattern);
      // Add start and end matching
      return "@^" . $pattern . "$@D";
    }

    private static function replaceWith($type, $regexAllowed, $pattern, $optional = false){
      $type = $optional ? "(:${type})?" : ":${type}";
      return preg_replace(
          '/{([a-zA-Z0-9\_\-]+)'. $type . '}/',    # Replace "{parameter}"
          '(?<$1>' . $regexAllowed . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
          $pattern
        );
    }
}
