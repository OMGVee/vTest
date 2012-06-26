<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<body>
<form id='frmGrabHandover' action="grab_handover.php" method="post">
<script language="JavaScript" src="calendar/calendar_eu.js"></script>
<link rel="stylesheet" href="calendar/calendar.css">


	startDate<input type="text" id="startDate" name="startDate" />
	<script language="JavaScript">
	var o_cal1 = new tcal ({
		// form name
		'formname': 'frmGrabHandover',
		// input name
		'controlname': 'startDate'
	});
	// individual template parameters can be modified via the calendar variable
	o_cal1.a_tpl.yearscroll = true;
	o_cal1.a_tpl.weekstart = 1;	
	</script>
	
	endDate<input type="text" id="endDate" name="endDate" />
	<script language="JavaScript">
	var o_cal1 = new tcal ({
		// form name
		'formname': 'frmGrabHandover',
		// input name
		'controlname': 'endDate'
	});
	// individual template parameters can be modified via the calendar variable
	o_cal1.a_tpl.yearscroll = true;
	o_cal1.a_tpl.weekstart = 1;	
	</script>
	
	<input type="submit" onclick="LoadContent('maincontent','./grab_handover.php');" name="submit" value="Submit">
	

</form>
</body>
</html>