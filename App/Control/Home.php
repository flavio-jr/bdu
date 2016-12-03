<?php
use Work\Database\Transaction;
use Work\Database\Criterion;
use Work\Database\Filter;
use Work\Database\Multi;
use Work\Loggers\LoggerXML;

class Home extends View implements PageInterface {

  /**
   * @method __construct Activate the parent builder
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * @method view Get the last records and show to the user
   *
   */
  public function view() {
    Transaction::open('bdu');
    Transaction::setLogger(new LoggerXML('nova_estrutura'));
    $regs = new Multi('Post');
    $this->pages = $regs->count()/5;
    $lastID = $this->pag_atual * 5;

    $filter = new Criterion;
    $filter->add(new Filter('id','<=',$lastID));
    $filter->setProperty('limit',5);
    $filter->setProperty('offset',($lastID-5));

    $posts = $regs->load($filter);

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
