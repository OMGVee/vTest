<?php   
include("lib/bootstrap.php");
$startDate = $_REQUEST['startDate'];
$endDate = $_REQUEST['endDate'];

//make the dates in the format we need it for the MySQL timestamp format, e.g. amsterdam type dd-mm-yyy hh:mm:ss :P
$startDateArray = explode("-", $startDate);
$sdDay = $startDateArray[0];
$sdMonth = $startDateArray[1];
$sdYear = $startDateArray[2];
$startDateSQL = "{$sdYear}-{$sdMonth}-{$sdDay} 00:00:00";

$endDateArray = explode("-", $endDate);
$edDay = $endDateArray[0];
$edMonth = $endDateArray[1];
$edYear = $endDateArray[2];
$endDateSQL = "{$edYear}-{$edMonth}-{$edDay} 00:00:00";

//echo "<hr>$startDateSQL<br>$endDateSQL<hr>";

//if chosen start date is earlier than 18-07-2011, then bork it, because that's when we started collecting alerts in the noc db
$continue = false;
if ($sdYear>=2011)
{
	if ($sdMonth>7)
	{	
		$continue=true;	
	}
	if ($sdMonth=7)
	{
		if ($sdDay>=18)
		{
			$continue=true;
		}
	}
	else
	{
		$continue = false;
	}
}
else 
{
	$continue = false;
}
if ($continue == false) die("Chosen start date: " . $startDateSQL . " is earlier than 18-07-2011, so there's no data to show, go back and choose wisely :)"); //bitch



 // Standard inclusions      

$DataSet = new pData();
$platform = new Platform();
$query = "select distinct(p.name) as platform, count(e.id) as count from event e, lu_platform p
where e.platform_id = p.id and p.prefix != 'mo'  AND e.event_datetime between '"
. $startDateSQL . "' and '" . $endDateSQL . "' group by platform";

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
  
 // Draw the title

 // Draw the pie chart  
 $Test->drawFromPNG("images/ecglogo.png",280,3);
 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",10);  
 $Test->drawTitle(50,22,"Nagios Alerts by Platform ($startDate-> $endDate)",50,50,50,285);
 //$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,150,110,PIE_PERCENTAGE,TRUE,50,20,5);  
 $Test->drawPieLegend(300,124,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
 $Test->Stroke();
 $Test->Render("Nagioses_current_image_export.png"); //due to the permissions on the filesystem, the files must be there and writable before they can be altered by this script 
?>  
