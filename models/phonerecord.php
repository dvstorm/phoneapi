<?php

class Phonerecord{

  private $name;
  private $phone;
  private $email;
  private $source_id;
  private $db;
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
    $this->db = Database::getInstance()->_instance;
    if($this->canSaverecord()){
      $this->savePhoneTable();
      $this->saved = true;
    }

    return $this->saved;
  }

  private function savePhoneTable(){

    $phones_stm = $this->db->prepare('
                      INSERT INTO phones (phone, name, email, source_id)
                      VALUES (:phone, :name, :email, :source_id)
                      ');
      $phones_params = [
              'phone'     => $this->phone,
              'name'      => $this->name,
              'email'     => $this->email,
              'source_id' => $this->source_id,
      ];

     $res = $phones_stm->execute( $phones_params );
  }

  private function getLastTimeSaved(){
    $time_stm= $this->db->prepare('
                      SELECT UNIX_TIMESTAMP(time) AS time FROM lastaddtime
                      WHERE (phone = :phone AND source_id = :source_id)
                      ');
    $time_params = [
              'phone'     => $this->phone,
              'source_id' => $this->source_id,
      ];
    $time_stm->execute($time_params);
    $last_time_saved = 0;

    foreach ($time_stm as $row) {
      if($last_time_saved < $row['time']){
        $last_time_saved = $row['time'];
      }
    }

    return $last_time_saved;
  }

  private function saveLastTimeTable(){

    $time_stm= $this->db->prepare('
                      INSERT INTO lastaddtime (phone, source_id)
                      VALUES (:phone, :source_id)
                      ');
      $time_params = [
              'phone'     => $this->phone,
              'source_id' => $this->source_id,
      ];

     $res = $time_stm->execute( $time_params );
  }

  private function updateLastTimeSaved(){

      $time_stm= $this->db->prepare('
                      UPDATE lastaddtime SET time = CURRENT_TIMESTAMP 
                      WHERE phone = :phone AND source_id = :source_id
                      ');
      $time_params = [
              'phone'     => $this->phone,
              'source_id' => $this->source_id,
      ];

      $time_stm->execute( $time_params );
  }

  private static function phoneNormalize($phone){
    return intval(substr(strval($phone), -10));
  }

  private function canSaveRecord(){
    return (
      $this->name &&
      $this->email &&
      ( $this->phone != NULL) &&
      $this->timeToSaveIsOK()
    );
  }

  private function timeToSaveIsOK(){

    $no_save_period = Config::get('NO_SAVE_PERIOD');

    $last_time_saved = $this->getLastTimeSaved();

    if(!$last_time_saved) {
      $this->saveLastTimeTable();
      return true;
    }

    if ((time() - $last_time_saved) > $no_save_period){
      $this->updateLastTimeSaved();
      return true;
    }

    return false;
  }

}
