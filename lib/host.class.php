<?php

class Host extends Db {

	protected $table = 'host';

  protected $fields = array('id', 'platform_id', 'name');
  public $id = NULL;
  public $platform_id = NULL;
  public $name = NULL;

	public function __construct() {	
    parent::__construct();
	}
}

?>
