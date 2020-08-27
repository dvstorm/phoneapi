<?php

class initdbController extends Controller{
  public function index(){
    $db = Database::getInstance()->_instance;

    $max_name_size = Config::get('MAX_NAME_SIZE');
    $max_email_size = Config::get('MAX_EMAIL_SIZE');

    $sql = "
DROP TABLE IF EXISTS `phones`;
CREATE TABLE `phones` (
  `phone` bigint(10) NOT NULL,
  `name` varchar(" . $max_name_size . ") NOT NULL,
  `email` varchar(" . $max_email_size . ") NOT NULL,
  `source_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `phones` ADD INDEX( `phone`);

DROP TABLE IF EXISTS `lastaddtime`;
CREATE TABLE `lastaddtime` (
  `phone` bigint(10) NOT NULL,
  `source_id` tinyint(4) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `lastaddtime` ADD INDEX( `phone`);
";

$result = $db->exec($sql);

echo 'Database created' . PHP_EOL;

if (array_key_exists('records', $_GET)){
  $records_num = $_GET['records'];
  var_dump($records_num);
  for($i=0;$i<$records_num;$i++){
    $name = ucfirst(self::gen(rand(3,8))) . " " . ucfirst(self::gen(rand(3,8)));
    $email = self::gen(rand(3,8)) . "@" . self::gen(rand(3,8)) . '.' .self::gen(3);
    // $phone = rand(1111111111, 9999999999);
    $phone = rand(9999999990, 9999999999);
    $source_id = rand(1,15);
    $phoneRecord = new Phonerecord(
      $source_id, 
      [
        'name' => $name,
        'phone' => $phone,
        'email' => $email,  
      ]);
    $phoneRecord->save();
  }
}
  }

  private static function gen($charNumber){
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $charNumber; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $randomString .= $characters[$index];
    }

    return $randomString;
  }
}

