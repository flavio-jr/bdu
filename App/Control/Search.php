<?php
use Work\Control\Page;
use Work\Database\Transaction;
use Work\Database\Criterion;
use Work\Database\Filter;
use Work\Database\Multi;
use Work\Loggers\LoggerXML;

class Search extends View implements PageInterface {

  public function __construct() {
    parent::__construct();
  }
  /**
   * @method view Search in the database for the user request
   *
   * @param string $param the value from url
   */
  public function view($param) {
    Transaction::open('bdu');
    Transaction::setLogger(new LoggerXML('busca'));
    $regs = new Multi('Post');
    $condition1 = new Filter('description','like','%'.$param['search'].'%');
    $condition2 = new Filter('subject','like','%'.$param['search'].'%');
    $condition3 = new Filter('tittle','like','%'.$param['search'].'%');
    $lastID = $regs->count($condition);
    $filter = new Criterion;
    $filter->add($condition1,$filter::OR_OPERATOR);
    $filter->add($condition2,$filter::OR_OPERATOR);
    $filter->add($condition3,$filter::OR_OPERATOR);

    $filter->setProperty('limit',5);
    $filter->setProperty('order','id');
    $ofsset = ($this->pag_atual * 5) - 5;
    $filter->setProperty('offset',$offset);

    $posts = $regs->load($filter);

    $this->pages = $lastID/5;

    echo parent::replace($posts);
    echo parent::showPages();

  }
  
  /**
   * @method show leads to the show method of superclass
   *
   */
  public function show() {
    parent::show();
  }
}
 ?>
