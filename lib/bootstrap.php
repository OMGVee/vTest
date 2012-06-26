<?php

require_once('config.class.php');
include('pChart/pCache.class');
include('pChart/pChart.class');
include('pChart/pData.class');

$tpl = new NocSmarty();

$menu = array();
$menu[] = array (
  'title' => 'View Stats',
  'link'  => 'view.php',
  'order' => 10,
);

$menu[] = array (
  'title' => 'Alert Stats',
  'link'  => 'stats.php',
  'order' => 20,
);

$menu[] = array (
  'title' => 'Active Alerts',
  'link'  => 'active.php',
  'order' => 30,
);

$tpl->assign('menu', $menu);

function pr($var) {
  print "<PRE>\n" . print_r($var, true) . "</PRE>\n";
}
?>
