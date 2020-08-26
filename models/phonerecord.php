<?php

class Phonerecord{

  private $name;
  private $phone;
  private $email;
  private $source_id;
  private $saved = false;

  public function __construct($source_id, $data){

    $max_name_size = Config::get('MAX_NAME_SIZE');
    $max_email_size = Config::get('MAX_EMAIL_SIZE');

    $this->source_id = intval($source_id);

    if( strlen( $data['name']) <= $max_name_size  ){
      $this->name = $data['name'];
    }

    if( filter_var($data['email'], FILTER_VALIDATE_EMAIL) ){
      $this->email = $data['email'];
    }

    $phone = self::phoneNormalize($data['phone']);
    $this->phone = $phone;
  }

  public function save(){
    if(self::canSaverecord($this)){
      $this->savePhoneTable();
      $this->saveLastTimeTable();
      $this->saved = true;
    } else {
      // echo 'Not saving' . PHP_EOL;
      // var_dump($this);
    }
    return $this->saved;
  }

  private function savePhoneTable(){
    $db = Database::getInstance()->_instance;

    $phones_stm = $db->prepare('
                      INSERT INTO phones (phone, name, email, source_id)
                      VALUES (:phone, :name, :email, :source_id)
                      ');
      $phones_params = [
              'phone'     => $this->phone,
              'name'      => $this->name,
              'email'     => $this->email,
              'source_id' => $this->source_id,
      ];

    try {
     $res = $phones_stm->execute( $phones_params );
         } catch (PDOException $e){
          echo $e->getMessage();
     };
  }

  private function saveLastTimeTable(){
    $db = Database::getInstance()->_instance;

    $time_stm= $db->prepare('
                      INSERT INTO lastaddtime (phone, source_id)
                      VALUES (:phone, :source_id)
                      ');
      $time_params = [
              'phone'     => $this->phone,
              'source_id' => $this->source_id,
      ];

    try {
     $res = $time_stm->execute( $time_params );
         } catch (PDOException $e){
          echo $e->getMessage();
     };
  }

  private static function phoneNormalize($phone){
    return intval(substr(strval($phone), -10));
  }

  private static function canSaveRecord($record){
    return (
      $record->name &&
      $record->email &&
      ( $record->phone != NULL) &&
      self::timeToSaveIsOK($record)
    );
  }

  private static function timeToSaveIsOK($record){
    return true;
  }

}
