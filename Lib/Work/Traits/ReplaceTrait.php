<?php
namespace Work\Traits;

use Work\Database\Transaction;

trait ReplaceTrait {
  use DateTrait;
  public function replace($post,$iteration,$pag_post) {

      $tag = $post->getTag();
      $date = $this->formatDate($post->date);
      $tittle = utf8_encode($post->tittle);
      $cover = "'$post->img'";
      $desc = utf8_encode($post->description);
      $about = utf8_encode($post->subject);
      $subject = explode(";",$about);

      $pag_post = str_replace("{{tag"."{$j}"."}}",utf8_encode($tag->tag_name),$pag_post);
      $pag_post = str_replace("{{dt"."{$j}"."}}",$date,$pag_post);
      $pag_post = str_replace("{{t"."{$j}"."}}",$tittle,$pag_post);
      $pag_post = str_replace("{{i"."{$j}"."}}",$cover,$pag_post);
      $pag_post = $this->about($subject,$pag_post,$j);
      $pag_post = str_replace("{{d"."{$j}"."}}",$desc,$pag_post);

      return $pag_post;
  }
  private function about($subject,$page,$current_post) {
    $pg = $page;
    $i = (count($subject)<=4) ? count($subject) : 4;
    $j = $current_post;
    while($i>0) {
      $pg = str_replace("{{sub"."{$j}"."{$i}"."}}",$subject[$i-1],$pg);
      $i--;
    }
    return $pg;
  }
}
 ?>
