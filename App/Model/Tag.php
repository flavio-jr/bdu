<?php
use Work\Database\Record;
use Work\Database\Criterion;
use Work\Database\Filter;
use Work\Database\Multi;
use Work\Database\Transaction;

class Tag extends Record {
  const TABLENAME = 'tag';

  public function getPosts($offset) {
    $c1 = new Criterion;
    $c1->add(new Filter('tag_id','=',$this->id));
    $c1->setProperty('limit',5);
    $c1->setProperty('offset',$offset);
    $regs = new Multi('PostTag');

    $vinculos = $regs->load($c1);
    if($vinculos) {
      foreach($vinculos as $post_tag) {
        $posts[] = new Post($post_tag->post_id);
      }
    }
    return $posts;
  }

}
 ?>
