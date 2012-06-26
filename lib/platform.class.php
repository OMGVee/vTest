<?php

class Platform extends Db {

	protected $table = 'lu_platform';

  protected $fields = array('id', 'name', 'prefix');
  public $id = NULL;
  public $name = NULL;
  public $prefix = NULL;

	public function __construct() {	
    parent::__construct();
	}

}

?>
