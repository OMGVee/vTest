<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<body>
<form id='frmGrabToptalkers' action="grab_toptalkers.php" method="post">
<script language="JavaScript" src="cssCalendar/datetimepicker_css.js"></script>

<table>
<tr>
	<td>Start Date</td>
	<td><input type="text" id="startDate" name="startDate"/>
		<img src="cssCalendar/images/cal.gif" onclick="javascript:NewCssCal('startDate','yyyyMMdd','arrow','yes',24,'yes')" 						style="cursor:pointer"/></td>
</tr>

<tr>
	<td>End Date</td>
	<td><input type="text" id="endDate" name="endDate"/>
<img src="cssCalendar/images/cal.gif" onclick="javascript:NewCssCal('endDate','yyyyMMdd','arrow','yes',24,'yes')" style="cursor:pointer"/></td>
		
	
</tr>	
</table>	
<input type="submit" onclick="LoadContent('maincontent','./grab_toptalkers.php');" name="submit" value="Submit">
</form>
</body>
</html>
