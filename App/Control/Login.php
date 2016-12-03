<?php
use Work\Control\Page;

class Login extends Page {

  public function view() {
    $login = file_get_contents('App/Templates/login.html');
    echo $login;
  }
}
 ?>
