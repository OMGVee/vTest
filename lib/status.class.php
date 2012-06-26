<?php

class Status extends Db {

	protected $table = 'lu_status';

  protected $fields = array('id', 'name', 'description');
  public $id = NULL;
  public $name = NULL;
  public $desription = NULL;

	public function __construct() {	
    parent::__construct();
	}
}

?>
