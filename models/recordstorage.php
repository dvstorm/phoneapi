<?php

class Recordstorage{

  private $db;

  public function __construct(){
    $this->db = Database::getInstance()->_instance;
  }

  public function phone($num){
    if(is_string($num)){
      $num = intval(substr($num, -10));
    }
    $result = [];

    $stm= $this->db->prepare(' SELECT * FROM phones WHERE phone = :phone ');

    $params = [
      'phone'     => $num,
    ];

    $stm->execute($params);

    foreach ($stm as $row) {
      $phone  = "+7" . sprintf('%010d', $row['phone']);
      $row['phone'] = $phone;
      $result[] = $row;
    }
    return $result;
  }
}
