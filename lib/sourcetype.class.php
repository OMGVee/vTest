<?php

class SourceType extends Db {

	protected $table = 'lu_sourcetype';

  protected $fields = array('id', 'name');
  public $id = NULL;
  public $name = NULL;

	public function __construct() {	
    parent::__construct();
	}
}

?>
