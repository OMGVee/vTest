<?php

class Db extends mysqli {

	protected $dbh = NULL;
  public  $sth = NULL;
	private $dbhost = DBHOST;
	private $dbuser = DBUSER;
	private $dbpass = DBPASS;
	private $dbname = DBNAME;
	

  public function __construct() {
    parent::__construct(
      $this->dbhost, 
      $this->dbuser,
      $this->dbpass,
      $this->dbname
    );
    $this->sth = parent::stmt_init();
	}

  public function __destruct() {
    parent::close();
  }

  public function bind_param(/* variable arg list*/) {
    $stack = debug_backtrace();
    $args = array();
    if (isset($stack[0]['args'])) {
      for ($i = 0; $i < count($stack[0]['args']); $i++) {
        $args[$i] = & $stack[0]['args'][$i];
      }
      call_user_func_array(array(&$this->sth, 'bind_param'), $args);
    }
  }

  public function bind_result(/* variable arg list*/) {
    $stack = debug_backtrace();
    $args = array();
    if (isset($stack[0]['args'])) {
      for ($i = 0; $i < count($stack[0]['args']); $i++) {
        $args[$i] = & $stack[0]['args'][$i];
      }
      call_user_func_array(array(&$this->sth, 'bind_result'), $args);
    }
  }

  public function prepare($query) {
    $return = $this->sth->prepare($query);
    if(!$return) {
      throw new Exception('query: ' . $query . ', Error: ' . $this->error);
    }
    return $return;
  }

  public function execute() {
    return $this->sth->execute();
  }

  public function next() {
    return $this->fetch();
  }

  public function fetch() {
    return $this->sth->fetch();
  }

  protected function allFields() {
    foreach($this->fields as $field) {
      $return .= ', ' . $field;
    }
    return preg_replace('/^, /', '', $return);
  }

  public function listAll($limit=0) {
    $query = 'SELECT ' . $this->allFields() . ' FROM ' . $this->table;
    if($limit) { $query .= ' LIMIT ' . $limit; }
    if($this->sth->prepare($query)) {
      foreach ($this->fields as $field) {
        $argstring .= ', $this->'.$field;
      }
      $argstring = preg_replace('/^, /', '', $argstring);
      eval("\$this->sth->bind_result($argstring);"); 
      $this->execute();
      return TRUE;
    } else {
      throw new Exception('query: ' . $query . ', error: ' . $this->error);
    }
  }

  public function getByField($field, $value, $type='s') {
    $query = 'SELECT ' . $this->allFields() . ' FROM ' . $this->table . " WHERE $field = ?";
    if($this->sth->prepare($query)) {
      $this->sth->bind_param($type, $value);
      foreach ($this->fields as $field) {
        $argstring .= ', $this->'.$field;
      }
      $argstring = preg_replace('/^, /', '', $argstring);
      eval("\$this->sth->bind_result($argstring);"); 
      $this->execute();
      return $this->fetch();
    } else {
      throw new Exception('query: ' . $query . ', error: ' . $this->error);
    }
  }

  public function getById($id) {
    return $this->getByField('id', $id, 'i');
  }
}

?>
