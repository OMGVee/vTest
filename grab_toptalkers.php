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



<?php


	$startDate = $_REQUEST['startDate'];
	$endDate = $_REQUEST['endDate'];
//	echo("STARTDATE:$startDate<br>");
//	echo("ENDDATE:$endDate<br>");
?>
<script language="JavaScript" src="cssCalendar/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/vStyle.css">
<script language="javascript"> 
function LoadContent(id, url){
var xmlHttp;
	try {// Firefox, Opera 8.0+, Safari
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

<HEAD>
<LINK href="css/vStyle.css" rel="stylesheet" type="text/css">
	
	<div id='header'>
		<div id='logo' align="left">
			<div id='logotxt'>
				<b><font size='72px'>NOC</font></b><font color='red' size='12px'>+</font><font face="trebuchet MS" size='2px'>VIEW</font>	
			</div>
		</div>
		<a href="#" onclick="LoadContent('maincontent','index.php');">
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
		<a href="#" onclick="LoadContent('maincontent','./prep_toptalkers.php');">
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
<div id="maincontent" style="align:center; width='100%'"></div>
<?php
	include_once('includes/functions.php');
	mysql_connect('localhost','nagios','blergh666');
if  (!mysql_select_db('noc')) die (mysql_error().":could not connect to NOC db");

$totalsql = "
SELECT DISTINCT (p.name) AS platform, count( e.id ) AS count
FROM event e, lu_platform p
WHERE e.platform_id = p.id
AND e.event_datetime
BETWEEN '$startDate'
AND '$endDate'
AND e.sender_id NOT
IN ( 759, 73 )
GROUP BY p.name
ORDER BY count DESC;
;
";
$totalsresult = mysql_query($totalsql);
echo("<table align='center'><tr><td width='300px' align='center'>
<b><u>ALERT TOTALS</u></b><br>
<table><tr><th>Platform</th><th>Total</th></tr>
");
if (!$totalsresult) die (mysql_error()."$totalsql<br>");

	while ($totalrows=mysql_fetch_array($totalsresult))
	{
		$platform_name=$totalrows['platform'];
		$numofalerts=$totalrows['count'];
		echo("<tr><td>$platform_name</td><td>$numofalerts</td></tr>");
	}

echo("
</table></td><td>
");
drawAlertTotals($startDate, $endDate,"Alert TOTALS per platform");
echo("
</td></tr><br><hr><br>
");


echo("<div align='center' width='100%'><b><u>TOTALS & TOPTALKERS</u></b> (per platform between $startDate and $endDate)</div><br>");

define('STARTDATE',$startDate);
define('ENDDATE',$endDate);

function drawAlertTotals($strdt,$endt,$title)
{
$DataSet = new pData();
$platform = new Platform();
$query = "select distinct(p.name) as platform, count(e.id) as count from event e, lu_platform p where e.platform_id = p.id  AND e.event_datetime between '"
. $strdt . "' and '" . $endt . "' and e.sender_id NOT IN ( 759, 73 ) group by platform order by count desc";
//echo "query:" . $query . "<hr>";
$platform->sth->prepare($query);
$platform->sth->bind_result($p, $count);
$platform->execute();
while ($platform->next()) {
  $DataSet->AddPoint($count, "Series1");
  $DataSet->AddPoint($p, "Series2");
  }
  
 $DataSet->AddAllSeries();  
 $DataSet->SetAbsciseLabelSerie("Series2");  
  
 // Initialise the graph  
 $Test = new pChart(480,300);  
 $Test->drawFilledRoundedRectangle(7,7,473,293,5,240,240,240);  
 $Test->drawRoundedRectangle(5,5,475,295,5,230,230,230);  
  
 // Draw the pie chart  
 $Test->drawFromPNG("images/ecglogo.png",280,20);
 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);  
 $Test->drawTitle(170,22,"$title ($strdt-> $endt)",50,50,50,285);
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,150,110,PIE_PERCENTAGE,TRUE,50,20,5);  
 $Test->drawPieLegend(300,125,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
// $Test->Stroke();
 $Test->Render("tmpImages/AlertTotalsPie.png"); //due to the permissions on the filesystem, the files must be there and writable before they can be altered by this script  
echo("<img src='tmpImages/AlertTotalsPie.png' />");
}

function toptalkers($platf_id)
{

	
	$titlequery  = "select name from lu_platform where id='$platf_id'";
	$titleresult = mysql_query($titlequery);
	if (!$titleresult) die (mysql_error());
	while ($titlerow = mysql_fetch_array($titleresult))
	{
	$pltf = $titlerow[0];

	}
	
	$sqlquery = "
SELECT count(event.id) cnt , host.name hn
FROM `event`
LEFT JOIN host ON event.host_id = host.id
WHERE event_datetime
BETWEEN '".constant('STARTDATE')."'
AND '".constant('ENDDATE')."'
AND event.id
IN (
SELECT e.id
FROM event e
WHERE e.serviceproblem_id <>0
)
AND event.sender_id NOT
IN ( 759, 73 )
AND event.platform_id='$platf_id'
group by event.host_id 
order by cnt desc
limit 10
";

$DataSet = new pData();
$platform = new Platform();
/*$query = "select distinct(p.name) as platform, count(e.id) as count from event e, lu_platform p where e.platform_id = p.id and p.prefix != 'mo'  AND e.event_datetime between '"
. $strdt . "' and '" . $endt . "' and e.sender_id NOT IN ( 759, 73 ) group by platform order by count desc"; */
//echo "query:" . $query . "<hr>";
$query = $sqlquery;
/*
$platform->sth->prepare($query);
$platform->sth->bind_result($hn_draw, $cnt_draw);
$platform->execute();
while ($platform->next()) {
  $DataSet->AddPoint($cnt_draw, "Series1");
 // $DataSet->AddPoint($hn_draw, "Series2");
  }
  
 $DataSet->AddAllSeries();  
 $DataSet->SetAbsciseLabelSerie("Series2");  
  
 // Initialise the graph  
 $Test = new pChart(480,250);  
 $Test->drawFilledRoundedRectangle(7,7,473,293,5,240,240,240);  
 $Test->drawRoundedRectangle(5,5,475,295,5,230,230,230);  
  
 // Draw the pie chart  
 $Test->drawFromPNG("images/ecglogo.png",280,20);
 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);  
 $Test->drawTitle(170,22,"$title ($strdt-> $endt)",50,50,50,285);
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,150,110,PIE_PERCENTAGE,TRUE,50,20,5);  
 $Test->drawPieLegend(300,125,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
// $Test->Stroke();
 $Test->Render("tmpImages/AlertTotalsPie_$pltf.png"); //due to the permissions on the filesystem, the files must be there and writable before they can be altered by this script  
echo("<img src='tmpImages/AlertTotalsPie_$pltf.png' />");
*/
 

 $result = mysql_query($sqlquery);
  if (!$result) die (mysql_error().":$result<br>");

if (mysql_num_rows($result)>1)
{
//two tables, left numbers, right graph

echo("<table align='center'><tr><td width='300px' align='center'>");

		echo("TopTalkers for <b>$pltf</b>");
	echo("
		<br><table><tr><th>Hostname</th><th>count</th></tr>
	");


		$DataSet = new pData();
	while ($rows = mysql_fetch_array($result))
	{
		$count = $rows['cnt'];
		$hostname = $rows['hn'];

		echo("
			<tr><td align='right'>$hostname</td><td align='center'>$count</td></tr>
		");

		$DataSet->AddPoint($count, "count");
		$DataSet->AddPoint($hostname, "hostname");

	}
	
		$DataSet->AddAllSeries();
 		$DataSet->SetAbsciseLabelSerie("hostname");

 		// Initialise the graph
 		$Test = new pChart(500,300);
 		$Test->drawFilledRoundedRectangle(7,7,473,293,5,240,240,240);
 		$Test->drawRoundedRectangle(5,5,475,295,5,230,230,230);

 		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);
 		$Test->drawTitle(170,22,"toptalking hosts for $pltf",50,50,50,285);
 		$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),155,150,110,PIE_PERCENTAGE,TRUE,50,20,5);
 		$Test->drawPieLegend(310,35,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);		

		$Test->Render("tmpImages/AlertTotalsPie_$pltf.png"); //due to the permissions on the filesystem, the files must be there and writable before they can be altered by this script  


	echo("
		</table><br>"
	);
echo("</td><td width='505px' align='center'>");
	echo("<img src='tmpImages/AlertTotalsPie_$pltf.png' />");
//graphs here
//echo("<img src='tmpImages/TopTalkersPerPlatform.png' />");



echo("</td></tr></table>");
}



}

//iterate through platforms and grab top talkers and display using the above function
$getpltfsquery = "select * from lu_platform";
$getpltfresult = mysql_query($getpltfsquery);
if (!$getpltfresult) 
{
	die(mysql_error().":$getpltfsquery<br>");
}
else 
{
	while($getpltfrows = mysql_fetch_array($getpltfresult))
	{
		$pltfid = $getpltfrows[0];
		toptalkers($pltfid);
	}
}



?>
</form> 
</BODY>









<LINK href="css/vStyle.css" rel="stylesheet" type="text/css">
