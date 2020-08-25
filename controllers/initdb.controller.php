<?php

class initdbController extends Controller{
  public function index(){
    $db = Database::getInstance()->_instance;

    $sql = "
DROP TABLE IF EXISTS `phones`;
CREATE TABLE `phones` (
  `phone` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `source_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `phones`
  ADD KEY `phone` (`phone`);
";

    $result = $db->exec($sql);

    echo 'This is initdbController' . PHP_EOL;
    echo 'Database created' . PHP_EOL;
  }
}

