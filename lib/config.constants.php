<?php

// database connection info
define('DBHOST', 'localhost');
define('DBUSER', 'nagios');
define('DBPASS', 'blergh666');
define('DBNAME', 'noc');

// smarty base configuration
define('SMARTY_TEMPLATE_DIR', $_SERVER['DOCUMENT_ROOT'] . "/noc/lib/templates");
define('SMARTY_COMPILE_DIR', $_SERVER['DOCUMENT_ROOT'] . "/noc/lib/templates_c");
define('SMARTY_CONFIG_DIR', $_SERVER['DOCUMENT_ROOT'] . "/noc/lib/configs");
define('SMARTY_CACHE_DIR', $_SERVER['DOCUMENT_ROOT'] . "/noc/lib/cache");

?>
