<?php
use Work\Database\Transaction;
use Work\Database\Criterion;
use Work\Database\Filter;
use Work\Database\Multi;
use Work\Loggers\Logger;
use Work\Loggers\LoggerXML;
use Work\Control\Page;

class Home extends Page implements View{

  private $pages;
  private static $pag_atual;

  public function __construct(){
    Transaction::setLogger(new LoggerXML('novo_home'));
    self::$pag_atual = 1;
  }

  public function view() {
    Transaction::open('bdu');
    $regs = new Multi('Post');
    $lastID = $regs->count();
    $filter = new Criterion;
    $filter->add(new Filter('id','<=',$lastID));
    $filter->setProperty('limit',5);
    $filter->setProperty('offset',(int)$lastID-5);

    $posts = $regs->load($filter);

    $this->pages = $lastID/5;

    $pag_post = file_get_contents('App/Templates/home.html');

    $i = 5;
    $j = 0;
    while($i>=0) {
      $post = new Post($posts[$i]->id);
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

      $j++;
      $i--;
    }
    echo $pag_post;
  }

  public function about($subject,$page,$current_post) {
    $pg = $page;
    $i = (count($subject)<=4) ? count($subject) : 4;
    $j = $current_post;
    while($i>0) {
      $pg = str_replace("{{sub"."{$j}"."{$i}"."}}",$subject[$i-1],$pg);
      $i--;
    }
    return $pg;
  }

  public function formatDate($date) {
    $foo = explode('-',$date);
    $newDate = $foo[2] . '|' . $foo[1] . '|' .substr($foo[0],2);
    return $newDate;

  }

  public function flip($param) {
    self::$pag_atual = $param['num_page'];
    Transaction::log("num".$this->pag_atual);
    echo $this->view();
  }

  public function showPages($file) {
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
