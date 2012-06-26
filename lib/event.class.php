<?php

/*
+-------------------+---------------+------+-----+-------------------+----------------+
| Field             | Type          | Null | Key | Default           | Extra          |
+-------------------+---------------+------+-----+-------------------+----------------+
| id                | int(11)       | NO   | PRI | NULL              | auto_increment | 
| platform_id       | int(11)       | NO   | MUL | NULL              |                | 
| sourcetype_id     | int(11)       | NO   | MUL | NULL              |                | 
| host_id           | int(11)       | NO   | MUL | NULL              |                | 
| service_id        | int(11)       | YES  | MUL | NULL              |                | 
| eventtype_id      | int(11)       | NO   | MUL | NULL              |                | 
| status_id         | int(11)       | NO   | MUL | NULL              |                | 
| event_datetime    | timestamp     | NO   |     | CURRENT_TIMESTAMP |                | 
| data              | varchar(2048) | YES  |     | NULL              |                | 
| sender_id         | int(11)       | NO   | MUL | NULL              |                | 
| hostproblem_id    | int(11)       | YES  |     | NULL              |                | 
| serviceproblem_id | int(11)       | YES  |     | NULL              |                | 
+-------------------+---------------+------+-----+-------------------+----------------+
*/

class Event extends Db {

	protected $table = 'event';

  protected $fields = array('id', 'platform_id', 'sourcetype_id', 'host_id', 'service_id',
    'eventtype_id', 'status_id', 'eventtype_id', 'status_id', 'event_datetime', 'data',
    'sender_id', 'hostproblem_id', 'serviceproblem_id');

  protected $idfields = array('platform', 'sourcetype', 'host', 'service', 'eventtype',
    'status', 'sender');

  public $id = NULL;
  public $platform_id = NULL;
  public $sourcetype_id = NULL;
  public $host_id = NULL;
  public $service_id = NULL;
  public $eventtype_id = NULL;
  public $status_id = NULL;
  public $event_datetime = NULL;
  public $data = NULL;
  public $sender_id = NULL;
  public $hostproblem_id = NULL;
  public $serviceproblem_id = NULL;

  public $platform = NULL;
  public $sourcetype = NULL;
  public $host = NULL;
  public $service = NULL;
  public $eventtype = NULL;
  public $status = NULL;
  public $sender = NULL;
  
	public function __construct() {	
    parent::__construct();
    
    $this->platform = new Platform();
    $this->sourcetype = new SourceType();
    $this->host = new Host();
    $this->service = new Service();
    $this->eventtype = new EventType();
    $this->status = new Status();
    $this->sender = new Host();
	}

  public function refreshObjects() {
    foreach($this->idfields as $object) {
      $idfield = $object . "_id";
      $this->$object->getById($this->$idfield);
    }
  }

  public function getByField($field, $value, $type='s') {
    $result = parent::getByField($field, $value, $type);
    if ($result) {
      $this->refreshObjects();
    }
    return $result;
  }

  public function getById($id) {
    return $this->getByField('id', $id, 'i');
  }

  public function next() {
    $result = parent::next();
    if ($result) {
      $this->refreshObjects();
    }
    return $result;
  }
}

?>
