<?php

class contactsController extends Controller{
  public function index(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data = json_decode(file_get_contents('php://input'), true);
      if( array_key_exists('source_id', $data) && array_key_exists('items', $data) ){
        $source_id = $data['source_id'];
        $items = $data['items'];

        foreach ($items as $item) {
          $phoneRecord = new Phonerecord($item);
          $phoneRecord->save();
        }
      }

    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){

    }
    echo 'This is contactsController' . PHP_EOL;
    // var_dump($_SERVER['REQUEST_METHOD']);
    // var_dump($_GET);
    // var_dump($_POST);
    // var_dump($_REQUEST);
  }
}
