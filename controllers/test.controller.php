<?php

class testController extends Controller{
  public function index(){
    $db = new DB();


    echo 'This is testController' . PHP_EOL;
  }
}

