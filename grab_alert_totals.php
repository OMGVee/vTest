<head>
<link rel="stylesheet" type="text/css" href="css/vStyle.css" />
</head>
<body>
</body>
<?
include("../lib/bootstrap.php");
//include "lib/session.class.php";
include "../lib/html.class.php";
include "../lib/mailhandler.class.php";
include "../lib/ldaphandler.class.php";

$startDate = $_REQUEST['startDate'];
$endDate = $_REQUEST['endDate'];


$ldap = new ldaphandler;
$ldap->AddHost("",true);
$ldap->Connect();
$ldap->SetBase("");
$ret = $ldap->Search("uid=".$_SERVER['PHP_AUTH_USER'],array("cn"));
$full_name = $ret[0]['cn'][0];

echo("welcome <b><a href='http://www.google.com'>$full_name</a></b><br>");

$host = "127.0.0.1";
$user = "";
$pass = "";

$link = mysql_connect($host,$user,$pass);
if (!$link) die("<br> a connection to <b>$host</b> could not be accomplished<br>" . mysql_error()); //die() bitch :))
$selecteddb = mysql_select_db("noc");
if (!$selecteddb) die (mysql_error());





$DataSet = new pData();
$platform = new Platform();
$query = "select distinct(p.name) as platform, count(e.id) as count from event e, lu_platform p
where e.platform_id = p.id and p.prefix != 'mo'  AND e.event_datetime between '"
. $startDate . "' and '" . $endDate . "' and e.sender_id NOT IN ( 759, 73 ) group by platform 
order by count desc";

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
 $Test = new pChart(480,250);  
 $Test->drawFilledRoundedRectangle(7,7,473,293,5,240,240,240);  
 $Test->drawRoundedRectangle(5,5,475,295,5,230,230,230);  
  
 // Draw the pie chart  
 $Test->drawFromPNG("images/ecglogo.png",280,20);
 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);  
 $Test->drawTitle(170,22,"Nagios Alerts by Platform ($startDate-> $endDate)",50,50,50,285);
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,150,110,PIE_PERCENTAGE,TRUE,50,20,5);  
 $Test->drawPieLegend(300,125,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
// $Test->Stroke();
 $Test->Render("tmpImages/AlertTotalsPie.png"); //due to the permissions on the filesystem, the files must be there and writable before they can be altered by this script 

//display the created image, not using the .Stroke() method because of stupid php limited output requirements
echo("<img src='tmpImages/AlertTotalsPie.png' />");


 ?>
