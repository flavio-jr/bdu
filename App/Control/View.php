<?php
use Work\Control\Page;
use Work\Database\Transaction;
use Work\Database\Filter;
use Work\Database\Criterion;
use Work\Database\Multi;

  class View extends Page {
  /**
    * Number of total pages of the current requisition
    *
    * @var int
   */
  protected $pages;
  /**
    * Current page
    *
    * @var int
   */
  protected $pag_atual;

  /**
    * Builder method, sets the current page as 1
   */
  public function __construct() {
    $this->pag_atual = 1;
  }
  /**
   * @method setPages set the number of pages
   *
   * @param float $many result of the operation done in a View class
   */
  public function setPages($many) {
    $this->pages = $many;
  }

  /**
   * @method replace Shows the results for the queries of the child classes
   * @param array $posts Array of Post Objects to show
   *
   */
  public function replace($posts) {
    $template = file_get_contents('App/Templates/home.html');

    if(is_array($posts)) {
      $i = 4;
      $j = 1;
      while($i >= 0) {
        $post = new Post($posts[$i]->id);

        $tag = utf8_encode($post->getTag()->tag_name);
        $date = $this->formatDate($post->date);
        $tittle = utf8_encode($post->tittle);
        $cover = "'$post->img'";
        $desc = utf8_encode($post->description);
        $subject = explode(";",utf8_encode($post->subject));

        $template = str_replace("{{tag"."{$j}"."}}",$tag,$template);
        $template = str_replace("{{dt"."{$j}"."}}",$date,$template);
        $template = str_replace("{{t"."{$j}"."}}",$tittle,$template);
        $template = str_replace("{{i"."{$j}"."}}",$cover,$template);
        $template = $this->about($subject,$template,$j);
        $template = str_replace("{{d"."{$j}"."}}",$desc,$template);

        $j++;
        $i--;
      }
      //Now, let's give to index the modified template
      return $template;
    }
  }

  /**
   * @method formatDate Transform the date format from mysql to a new one
   *
   * @param string $date to format
   * @return the transformed date
   */
  public function formatDate($date) {
    $foo = explode('-',$date);
    $newDate = $foo[2] . '/' . $foo[1] . '/' . substr($foo[1],2);
    return $newDate;
  }

  /**
   * @method about Replaces the content of subjects in the posts
   *
   * @param array $subject The subjects of the post
   * @param string $template The template to make replaces
   * @param int $pos The current position of the loop in the replace method
   *
   * @return string $page Returns the template replaced with new content
   */
  public function about($subject,$template,$pos) {
    $page = $template;
    $i = (count($subject)<=4) ? count($subject) : 4;
    $j = $pos;

    while ($i > 0) {
      $page = str_replace("{{sub"."{$j}"."{$i}"."}}",$subject[$i-1],$page);
      $i--;
    }

    return $page;
  }

  /**
   * @method flip Changes the $pag_atual value and refresh the page
   *
   * @param array $get The array $_GET to receive the value of the current page
   */
  public function flip($get) {
    $this->pag_atual = $get['num_page'];
    $class = get_class($this);
    $object = new $class;
    echo $object->view();
  }

  public function show() {
    parent::show();
  }

  public function showPages() {
    $template = file_get_contents('App/Templates/pages.html');
    if($this->pages<=10) {
      $pg = 1;
      $this->pages = (($this->pages<1)&&($this->pages!=0)) ? 1 : $this->pages;
      while($pg<=$this->pages) {
        $template = str_replace('{{pg'.$pg.'}}',"{$pg}",$template);
        $pg++;
      }
    }
    return $template;
  }
}
 ?>
