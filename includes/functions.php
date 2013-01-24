<?php
include_once('config.php');
include_once("./lib/bootstrap.php");
//include "lib/session.class.php";
include_once "./lib/html.class.php";
include_once "./lib/mailhandler.class.php";
include_once "./lib/ldaphandler.class.php";
define ('INCLUDEPATH',dirname(__FILE__).'/../includes/');
define ('IMAGEPATH',dirname(__FILE__).'/../images/');
define ('LIBPATH',dirname(__FILE__).'/../lib/');
define ('TMPIMGPATH',dirname(__FILE__).'/../tmpImages/');
define ('LOGPATH','../log/');


function dateToSqlFormat($inputDate)
{
	$inputDateArray = explode("-", $inputDate);
	$outputDay = $inputDateArray[0];
	$outputMonth = $inputDateArray[1];
	$outputYear = $inputDateArray[2];
	$outputDate = "{$outputYear}-{$outputMonth}-{$outputDay} 00:00:00";
	return $outputDate;
}

function dbConnect()
{
	$link = mysql_connect($dbhost, $dbuser, $dbpass);
	if (!$link) 
	{
		log(mysql_error(),2);
		die (mysql_error($link));
	}
	$usedb = mysql_select_db($dbname);
	if (!$usedb) 
	{
		log(mysql_error(),2);
		die (mysql_error($link));
	}
}

function sessionManagement()
{
}

function vlog($message,$logtype) //1-access,2-error,3-activity
//log('you messed up',2);
{
	if ($logtype=='1')
	{
		$file = constant('LOGPATH') . 'access.log'; 
	}
	else if ($logtype=='2')
	{
		$file = $logpath . 'error.log';
	}
	else $file = $logpath . 'activity.log';

	if(!file_exists('$file'))
  	{
  		die("File <b>$file</b> not found, or I don't have permissions to append to it. Spank Vic or Armand to fix it!");
  	}
	else
  	{
  		$loghandle=fopen($file,'a');
  	}
  	fwrite($loghandle, getdate() . ':' . $message . '\n');
}

?>
