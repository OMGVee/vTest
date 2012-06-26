<?php

class EventType extends Db {

	protected $table = 'lu_eventtype';

  protected $fields = array('id', 'name', 'description');
  public $id = NULL;
  public $name = NULL;
  public $description = NULL;

	public function __construct() {	
    parent::__construct();
	}
}

?>
