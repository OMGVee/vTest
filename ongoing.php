<head>
<link rel="stylesheet" href="calendar/calendar.css">
</head>
<body>

<?php

/*<!-- HEADER -->*/
include_once('includes/config.php');
include_once('includes/functions.php');
include_once('lib/ldaphandler.class.php');
include_once('lib/bootstrap.php');
include_once('lib/html.class.php');
include_once('lib/mailhandler.class.php');
$ldap = new ldaphandler;
$ldap->AddHost("",true);
$ldap->Connect();
$ldap->SetBase("ou=,o=");
$ret = $ldap->Search("uid=".$_SERVER['PHP_AUTH_USER'],array("cn"));
$full_name = $ret[0]['cn'][0];

?>



<?php

$startDate=$_REQUEST['startDate'];
$endDate=$_REQUEST['endDate'];
//echo("working on it");

$today=getdate();
$y=$today['year'];
$m=$today['mon'];
$d=$today['mday'];
$h=$today['hours'];
$min=$today['minutes'];
$s=$today['seconds'];

$now = $y . "-" . $m . "-" . "d" . " " . $h . ":" . $min . ":" . $s;

$link = mysql_connect('127.0.0.1','nagios','somepass');
mysql_select_db('noc');

$sql = "
SELECT e.id, pl.name, src.name, srv.name, h1.name, e.event_datetime, data, h2.name FROM event e left join lu_platform pl on e.platform_id=pl.id left join lu_sourcetype src on e.sourcetype_id = src.id
left join service srv on e.service_id=srv.id
left join host h1 on e.host_id = h1.id
left join host h2 on e.sender_id = h2.id
WHERE event_datetime between (SELECT DATE_ADD(NOW(), INTERVAL -1 DAY)) and NOW() 
AND e.id in
(SELECT e.id
FROM event e
WHERE e.serviceproblem_id <> 0  AND e.platform_id <> '7'
  AND NOT EXISTS ( SELECT 1 FROM event e1 WHERE e.serviceproblem_id =
        e1.serviceproblem_id AND e1.eventtype_id = '2' AND e1.status_id = '0'
        AND e1.status_id <> '6' ) )
AND e.sender_id NOT IN ( 759, 73 )
AND e.status_id NOT IN ( 0, 6 )
ORDER BY e.event_datetime ASC
";

$res = mysql_query($sql);

if (!$res) die (mysql_error()."$sql");
?>
Alerts in the last 24 hours:<hr>
<table>
<tr>
	<th>id</th>
	<th>timestamp</th>
	<th>host</th>
	<th>service</th>
	<th>alert_txt</th>
	<th>platform</th>
	<th>from</th>
	<th>source</th>
</tr>
<?php

while ($row = mysql_fetch_array($res))
{
	$event_id = $row[0];
	$platform_name = $row[1];
	$source = $row[2];
	$service = $row[3];
	$host = $row[4];
	$datetime = $row[5];
	$txt = $row[6];
	$sender = $row[7];
echo("
	<tr>
		<td>$event_id</td>
		<td>$datetime</td>
		<td>$host</td>
		<td>$service</td>
		<td>$txt</td>
		<td>$platform_name</td>
		<td>$sender</td>
		<td>$source</td>
	</tr>
");

}

?>
</table>
</body>
