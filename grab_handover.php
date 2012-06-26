<?php
/*<!-- HEADER -->*/
include_once('includes/config.php');
include_once('includes/functions.php');
include_once('lib/ldaphandler.class.php');
include_once('lib/bootstrap.php');
include_once('lib/html.class.php');
include_once('lib/mailhandler.class.php');

$ldap = new ldaphandler;
$ldap->AddHost("10.32.4.40",true);
$ldap->Connect();
$ldap->SetBase("ou=classifieds,o=ebay");
$ret = $ldap->Search("uid=".$_SERVER['PHP_AUTH_USER'],array("cn"));
$full_name = $ret[0]['cn'][0];



?>
<script language="JavaScript" src="calendar/calendar_eu.js"></script>
<script language="JavaScript" src="cssCalendar/datetimepicker_css.js"></script>
<link rel="stylesheet" href="calendar/calendar.css">
<script language="javascript"> 
function LoadContent(id, url){
var xmlHttp;
	try {// Firefox, Opera 8.0+, Safari, Chrome
		xmlHttp = new XMLHttpRequest();	
	} 
	catch (e) {// Internet Explorer
					try {
					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
					} 
					catch (e) {
						try {
						xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
						} 
						catch (e) {
							alert("Your browser does not support AJAX!");
							return false;
						}
					}
	}
xmlHttp.onreadystatechange = function(){
	if (xmlHttp.readyState == 4) {
		//Get the response from the server and extract the section that comes in the body section of the second html page avoid inserting the 		header part of the second page in your first page's element
		var respText = xmlHttp.responseText.split('<body>');
		elem.innerHTML = "";
		elem.innerHTML = respText[1].split('</body>')[0];
	}
}

var elem = document.getElementById(id);
if (!elem) {
	alert('The element with the passed ID doesn\'t exists in your page');
	return;
}

xmlHttp.open("GET", url, true);
xmlHttp.send(null);
}	
</script> 
<script language="JavaScript" src="./calendar/calendar_eu.js"></script>
<link rel="stylesheet" href="./calendar/calendar.css">
<HEAD>
<LINK href="css/vStyle.css" rel="stylesheet" type="text/css">
	
	<div id='header'>
		<div id='logo' align="left">
			<div id='logotxt'>
				<b><font size='72px'>NOC</font></b><font color='red' size='12px'>+</font><font face="trebuchet MS" size='2px'>VIEW</font>	
			</div>
		</div>
		<a href="#" onclick="LoadContent('maincontent','ongoing.php');">
			<div id='tab1' align="middle">
			ongoing alerts
			</div>
		</a>
		<a href="#" onclick="LoadContent('maincontent','index.php');">	
			<div id='tab2' align="right">
			knowledge base
			</div>
		</a>
		<a href="#" onclick="LoadContent('maincontent','./prep_handover.php');">		
			<div id='tab3' align="right">
			give handover
			</div>
		</a>
		<a href="#" onclick="LoadContent('maincontent','prep_toptalkers.php');">
                        <div id='tab4' align="right">
                        reporting & graphs
                        </div>
                </a>
	</div>
	<div id='headerbar'>
	&nbsp; 

<?php
echo("welcome <b><a href='http://www.google.com'>$full_name</a></b>");
?>
<a href="logout.php">(logout)</a>
	</div>
</HEAD>
<?php
//at some point around here I should be including fixes for Intarnet Exploder, but I'm not going to, if you're using it... well FFFUUUUU :P
?>
<!-- CONTENT -->
<BODY>
<center><div id="maincontent"></div></center>
<?php
	include_once('includes/functions.php');
	mysql_connect('localhost','','');
if  (!mysql_select_db('noc')) die (mysql_error());
	$startDate = $_REQUEST['startDate'];
	$endDate = $_REQUEST['endDate'];

$sqlquery = "
SELECT e.id, pl.name, src.name, srv.name, h1.name, e.event_datetime, data, h2.name FROM event e left join lu_platform pl on e.platform_id=pl.id left join lu_sourcetype src on e.sourcetype_id = src.id
left join service srv on e.service_id=srv.id
left join host h1 on e.host_id = h1.id
left join host h2 on e.sender_id = h2.id
WHERE e.event_datetime BETWEEN '$startDate' AND '$endDate'
  AND e.serviceproblem_id <> 0 
  AND e.platform_id <> '7' 
  AND NOT EXISTS (
        SELECT 1
        FROM event e1
        WHERE e.serviceproblem_id = e1.serviceproblem_id
          AND e1.eventtype_id = '2'
          AND ( e1.status_id <> '0' AND e1.status_id <> '6' )
  )
  AND e.sender_id NOT IN ( 759, 73 )
  AND e.status_id NOT IN (0, 6 )
ORDER BY e.event_datetime ASC
";
  
  $result = mysql_query($sqlquery);
  if (!$result) die (mysql_error());
echo("All alerts between $startDate and $endDate:<br>");
?>
<hr><br>
Who is working<br>
--------------<br>
This shift:<br>
Next shift:<br>
<br><br>

Actions for the next shift<br>
==========================<br>
<br><br>

Key observations<br>
================<br>
<br><br>

Incidents<br>
=========<br>

Changes<br>
=======<br>
<br><br>
Alerts<br>
======<br>

<table>

<?php
$counter = 0;
while ($rows = mysql_fetch_array($result))
{
$counter++;
	$event_id = $rows[0];
	$platform = $rows[1];
	$sourcetype = $rows[2];
	$service = $rows[3];
	$host = $rows[4];
	$datetime = $rows[5];
	$alerttext = $rows[6];
	$sender = $rows[7];
echo("
<tr><td>Time:</td><td>$datetime</td></tr>
<tr><td>Platform:</td><td>$platform</td></tr>
<tr><td>Source(sender):</td><td>$sourcetype($sender)</td></tr>
<tr><td>Service:</td><td>$service</td></tr>
<tr><td>Host:</td><td>$host</td></tr>
<tr><td>Documented:</td><td>No</td></tr>
<tr><td>Docs provided:</td><td>No</td></tr>
<tr><td>eCG NOC Solved:</td><td>No</td></tr>
<tr><td>Text:</td><td>$alerttext</td></td>
<tr><td>NOC Comment/solution:</td><td>self recovered</td></tr>
<tr><td colspan=2>---------</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
");

}
echo ("<hr>Total: " . $counter . "<hr>");
?>
</table>
</form> 
</BODY>


<!-- FOOTER -->
<footer>
<div id='footerbar'>
last message: none
<?php
?>
</div>
</footer>







<LINK href="css/vStyle.css" rel="stylesheet" type="text/css">
