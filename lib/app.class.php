<?php

class App{

  protected static $router;

  public static function getRouter(){
    return self::$router;
  }

  public static function run($uri){
    self::$router = new Router($uri);

    $controller_class = ucfirst(self::$router->getController()).'Controller';
    $controller_method = strtolower(self::$router->getAction());


    $controller_path = ROOT.DS.'controllers'.DS.str_replace('controller', '', strtolower($controller_class)).'.controller.php';
    
    if( !file_exists($controller_path) ) {
        $controller_class = Config::get('default_controller');
        $controller_method = Config::get('default_action');
    }

    $controller_object = new $controller_class();
    if( method_exists($controller_object, $controller_method) ) {
      $result = $controller_object->$controller_method();
    }
  }
}
