<?php

class Router{

  protected $uri;
  protected $controller;
  protected $action;
  protected $params;

  public function getUri(){
    return $this->uri;
  }

  public function getController(){
    return $this->controller;
  }

  public function getAction(){
    return $this->action;
  }

  public function getParams(){
    return $this->params;
  }

  public function __construct($uri){
    $this->uri = urldecode(trim($uri, '/'));

    $uri_parts = explode('?', $this->uri);
    $path = $uri_parts[0];
    $params = array_key_exists(1, $uri_parts) ? $uri_parts[1] : Config::get('default_params');
    $this->params = $params;

    $path_parts = explode('/', $path);

    $this->controller = array_key_exists(0, $path_parts) ? $path_parts[0] : Config::get('default_controller');
    $this->action = array_key_exists(1, $path_parts) ? $path_parts[1] : Config::get('default_action');

    // print_r(' Router called with uri: ' . $this->uri);
    // print_r(' Controller: ' . $this->controller);
    // print_r(' Action: ' . $this->action);
    // print_r(' Params: ' . $this->params);

  }
}

