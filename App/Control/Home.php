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
  private $pag_atual;

  public function __construct(){
    Transaction::open('bdu');
    Transaction::setLogger(new LoggerXML('novo_home'));
    $regs = new Multi('Post');
    $this->pages = $regs->count();
    $this->pag_atual = 1;
    echo $this->view();
  }

  public function view() {
    Transaction::open('bdu');
    $lastID = $this->pag_atual * 5;
    Transaction::log($lastID);
    $filter = new Criterion;
    $filter->add(new Filter('id','<=',$lastID));
    $filter->setProperty('limit',5);
    $filter->setProperty('offset',(int)$lastID-5);

    $regs = new Multi('Post');
    $posts = $regs->load($filter);

    $pag_post = file_get_contents('App/Templates/home.html');

    $i = $lastID;
    $j = $lastID-5;
    while($i>=$lastID-5) {
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
    Transaction::log($pag_post);
    echo $pag_post;
  }

  /*
   * homePage(): método utilizado para quando não há requisições
  */
  public static function homePage() {

    /*Transaction::open('bdu');
    Transaction::setLogger(new LoggerXML('homepage'));

    $exibicao = new Criterion;

    $regs = new Multi('Post');
    $lastID = $regs->count();
    $this->pages = (int) $regs->count()/5;

    $exibicao->add(new Filter('id','<=',$lastID));
    $exibicao->setProperty('limit',5);
    $exibicao->setProperty('offset',$lastID-5);

    $home = $regs->load($exibicao);

    $j = 1;
    $i = 4;
    $pag_post = file_get_contents("App/Templates/home.html");
    while($i>=0) {
      //Implementar o design pattern MVC aqui
      $post = new Post($home[$i]->id);
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

    return $pag_post;*/
  }
  private static function formatDate($date) {
    $foo = explode('-',$date);
    $newDate = $foo[2] . '|' . $foo[1] . '|' .substr($foo[0],2);
    return $newDate;

  }

  public function flip($num_page) {
    $this->pag_atual = (int)$num_page;
    echo $this->view();
  }

}

 ?>
