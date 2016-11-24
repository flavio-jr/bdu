<?php
use Work\Database\Transaction;
use Work\Database\Criterion;
use Work\Database\Filter;
use Work\Database\Multi;
use Work\Loggers\Logger;
use Work\Loggers\LoggerXML;
use Work\Control\Page;
class Home extends Page {

  private $pages;
  private static $pag_atual;

  public function __construct(){
    Transaction::open('bdu');
    Transaction::setLogger(new LoggerXML('novo_home'));
    $regs = new Multi('Post');
    $this->pages = $regs->count();
    self::$pag_atual = 1;
  }

  public function view() {
    Transaction::open('bdu');
    $lastID = self::$pag_atual * 5;
    Transaction::log($lastID);
    $filter = new Criterion;
    $filter->add(new Filter('id','<=',$lastID));
    $filter->setProperty('limit',5);
    $filter->setProperty('offset',(int)$lastID-5);

    $regs = new Multi('Post');
    $posts = $regs->load($filter);

    $pag_post = file_get_contents('App/Templates/home.html');

    $i = 5;
    $j = 0;
    while($i>=0) {
      $post = new Post($posts[$i]->id);
      $tag = $post->getTag();
      $date = self::formatDate($post->date);
      $tittle = utf8_encode($post->tittle);
      $cover = "'$post->img'";
      $desc = utf8_encode($post->description);

      $pag_post = str_replace("{{tag"."{$j}"."}}",utf8_encode($tag->tag_name),$pag_post);
      $pag_post = str_replace("{{dt"."{$j}"."}}",$date,$pag_post);
      $pag_post = str_replace("{{t"."{$j}"."}}",$tittle,$pag_post);
      $pag_post = str_replace("{{i"."{$j}"."}}",$cover,$pag_post);
      $pag_post = str_replace("{{d"."{$j}"."}}",$desc,$pag_post);

      $j++;
      $i--;
    }
    echo $pag_post;
  }

  private static function formatDate($date) {
    $foo = explode('-',$date);
    $newDate = $foo[2] . '|' . $foo[1] . '|' .substr($foo[0],2);
    return $newDate;

  }

  public function flip($param) {
    self::$pag_atual = $param['num_page'];
    Transaction::log("num".self::$pag_atual);
    echo $this->view();
  }

}

 ?>
