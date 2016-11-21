<?php
use Work\Database\Record;

class Post extends Record {
  const TABLENAME = 'post';
  private $tag;

  public function setTag(Tag $tag) {
    $this->tag = $tag;
    $tp = new PostTag;
    $tp->tag_id = $tag->id;
    $tp->post_id = $this->id;
    $tp->save();
  }

  public function getTag() {
    if(isset($this->tag)) {
      return $this->tag;
    }
    else {
      $tag = new Tag($this->tag_id);
      return $tag;
    }
  }

}
 ?>
