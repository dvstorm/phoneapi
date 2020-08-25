<?php

class Database
{
  protected static $instance = null;
  
  private function __construct()
  {
    $db_host = Config::get('DB_HOST');
    $db_name = Config::get('DB_NAME');
    $db_user = Config::get('DB_USER');
    $db_pass = Config::get('DB_PASS');

    $this->_instance = new PDO(
			'mysql:host=' . $db_host . ';dbname=' . $db_name,
	    	$db_user,
	    	$db_pass,
        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
      );
  }
 
  public static function getInstance()
  {
      if (static::$instance == null)
      {
          static::$instance = new static;
      }
 
      return static::$instance;
  }

  protected function __clone() { }

  protected function __wakeup() { }
		
}
