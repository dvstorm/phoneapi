<?php


function autoloader($class_name){
  $lib_path = ROOT.DS.'lib'.DS.strtolower($class_name).'.class.php';
  $controllers_path = ROOT.DS.'controllers'.DS.str_replace('controller', '', strtolower($class_name)).'.controller.php';
  $model_path = ROOT.DS.'models'.DS.strtolower($class_name).'.php';

  if( file_exists($lib_path) ) {
    require_once($lib_path);
  } elseif ( file_exists($controllers_path) ){
    require_once($controllers_path);
  } elseif ( file_exists($model_path) ){
    require_once($model_path);
  } else {
    throw new Exception('Failed to include class '.$classname);
  }
};

spl_autoload_register('autoloader');

require_once(ROOT.DS.'config'.DS.'config.php');