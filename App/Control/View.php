<?php

interface View {
  public function flip($param);
  public function formatDate($date);
  public function about($subject,$page,$current_post);
  public function showPages($file);
}
 ?>
