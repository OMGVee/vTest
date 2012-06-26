<?php

require_once('config.constants.php');
require_once('nocsmarty.class.php');

$tables = array( 'db', 'event', 'eventtype', 'host', 'platform',
  'service', 'session', 'sourcetype', 'status' );

foreach($tables as $table) {
  require_once($table . '.class.php');
}

?>
