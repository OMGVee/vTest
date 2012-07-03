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
$ldap->SetBase("");
$ret = $ldap->Search("uid=".$_SERVER['PHP_AUTH_USER'],array("cn"));
$full_name = $ret[0]['cn'][0];
?>
<script language="JavaScript" src="cssCalendar/datetimepicker_css.js"></script>

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
<?php
include_once "lib/ldaphandler.class.php";
$ldap = new ldaphandler;
$ldap->AddHost("",true);
$ldap->Connect();
$ldap->SetBase("ou=classifieds,o=ebay");
$ret = $ldap->Search("uid=".$_SERVER['PHP_AUTH_USER'],array("cn"));
$full_name = $ret[0]['cn'][0];

//vlog($message,$logtype) //1-access,2-error,3-activity

//$today=getdate();

//vlog("$today:$full_name logged in\n",1);

?>	
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
		<a href="#" onclick="LoadContent('maincontent','kb.php');">	
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
		echo("$full_name"); 
	?>
		<a href="logout.php">(logout)</a>
	</div>
</HEAD>
<?php
//at some point around here I should be including fixes for Intarnet Exploder, but I'm not going to, if you're using it... well FFFUUUUU :P
?>
<!-- CONTENT -->
<BODY>
<div id="maincontent"></div>

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
