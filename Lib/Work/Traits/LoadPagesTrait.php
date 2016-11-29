<?php
namespace Work\Traits;

trait LoadPagesTrait {
  public function showPages($file)
  {
    $template = $file;
    if($this->pages<=10) {
      $pg = 1;
      while($pg<=$this->pages) {
        $template = str_replace('{{pg'.$pg.'}}',"{$pg}",$template);
        $pg++;
      }
    }
    return $template;
  }

}
 ?>
