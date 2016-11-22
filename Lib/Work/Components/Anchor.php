<?php
namespace Work\Components;

class Anchor extends Element {
  public function __construct($link) {
    parent::__construct('a');
    $this->href = $link;
  }
}
 ?>
