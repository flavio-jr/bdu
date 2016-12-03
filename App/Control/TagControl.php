<?php
use Work\Control\Page;
use Work\Database\Transaction;
use Work\Database\Criterion;
use Work\Database\Filter;

class TagControl extends View implements PageInterface {

  /**
   * @var $tag_id The tag id that corresponds to the Tag record
   */
  private $tag_id;

  public function __construct() {
    parent::__construct();
  }

  /**
   * @method view Show the records that have the tag_id atributte of this class
   *
   */
  public function view() {
    Transaction::open('bdu');
    $this->tag_id = $_GET['id'];
    $tag = new Tag($this->tag_id);
    $ofsset = ($this->pag_atual * 5) - 5;
    $tagPosts = $tag->getPosts($offset);

    $this->pages = count($tagPosts)/5;

    echo parent::replace($tagPosts);
    echo parent::showPages();

  }

  /**
   * @method show Leads to the show method of superclass
   *
   */
  public function show() {
    parent::show();
  }

}
 ?>
