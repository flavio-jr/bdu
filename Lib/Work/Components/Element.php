<?php
namespace Work\Components;

class Element {
  protected $tag;
  protected $attributes;
  protected $content;

  public function __construct($tagname) {
    $this->tag = $tagname;
  }


  public function __set($attr,$value) {
    $this->attributes[$attr] = $value;
  }
  public function getAttribute($attr) {
    if(isset($this->attributes[$attr])) {
      return $this->attributes[$attr];
    }
  }

  public function setValue($value) {
    $this->content = $value;
  }
  public function getValue() {
    return $this->content;
  }

  public function show() {
    
  }

  public function open() {
    echo "<{$this->tag} ";

    if($this->attributes) {
      foreach($this->attributes as $attr=>$value) {
        echo "$attr=$value ";
      }
    }
    echo ">";
    if($this->content) {
      if(is_object($this->content)) {
        $this->content->open();
      }
      else {
        echo $this->content;
      }
    }
    $this->close();
  }

  public function close() {
    echo "</{$this->tag}>";
  }
}
 ?>
