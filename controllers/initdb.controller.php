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

    echo 'This is initdbController' . PHP_EOL;
    echo 'Database created' . PHP_EOL;
  }
}

