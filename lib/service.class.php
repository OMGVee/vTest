<?php

class Service extends Db {

	protected $table = 'service';

  protected $fields = array('id', 'name');
  public $id = NULL;
  public $name = NULL;

	public function __construct() {	
    parent::__construct();
	}
}

?>
