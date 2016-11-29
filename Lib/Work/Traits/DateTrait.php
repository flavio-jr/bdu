<?php
namespace Work\Traits;

trait DateTrait {
  public function formatDate($date) {
    $foo = explode('-',$date);
    $newDate = $foo[2] . '|' . $foo[1] . '|' .substr($foo[0],2);
    return $newDate;
  }
}
 ?>
