<?php

class Phonerecord{

  private $name;
  private $phone;
  private $email;
  private $source_id;

  public function __construct($data){
    $this->name = $data['name'];
    $this->email = $data['email'];
    $this->phone = intval($data['phone']);
  }

  public function save(){
    $db = Database::getInstance()->_instance;
    var_dump($this, $db);
    
  }

}
