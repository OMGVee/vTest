<?php    

$dbh = mysqli_connect("localhost","nagios","blergh666","noc") OR die(mysql_error());

require_once("Smarty-3.0.8/libs/Smarty.class.php");

$smarty = new Smarty();
$smarty->template_dir = $_SERVER['DOCUMENT_ROOT'] . "/noc/lib/templates";
$smarty->compile_dir = $_SERVER['DOCUMENT_ROOT'] . "/noc/lib/templates_c";
$smarty->config_dir = $_SERVER['DOCUMENT_ROOT'] . "/noc/lib/configs";
$smarty->cache_dir = $_SERVER['DOCUMENT_ROOT'] . "/noc/lib/cache";

$menu = array();
$menu[] = array (
	'title' => 'View Stats',
	'link'	=> 'view.php',
	'order'	=> 10,
);

$menu[] = array (
	'title' => 'Alert Stats',
	'link'	=> 'stats.php',
	'order'	=> 20,
);

$menu[] = array (
	'title' => 'Active Alerts',
	'link'	=> 'active.php',
	'order'	=> 30,
);

?>
