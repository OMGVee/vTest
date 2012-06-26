<?php

class html {

	public function __construct() { }
	
	public function __destruct() { }
	
	/*
        * array = array(
        *       array("name" => "", "value" => ""),
        *       array("name" => "", "value" => "")
        *       )
	*
	* selected = array("","","","");
        */
	public function checkboxes($array,$name,$rows,$selected='') {
		
		echo "<table border=0 cellpadding=1 cellspacing=1 align=left>";
		$cols = ceil(count($array)/$rows);
		$i=0;
		for($r=0; $r < $rows; $r++) {
			echo "<tr>\n";
			for($c=0; $c < $cols; $c++) {
				$data = $array[$i];
				$fname = $data['name'];
				$fvalue = $data['value'];
				echo "<td>";
				if(!empty($fname)) {
				echo "<input type=\"checkbox\" name=\"".$name."[]\" value=\"".$fvalue."\" ";
				if(!empty($selected)) {
				if(in_array($fvalue,$selected) == TRUE) {
					echo " CHECKED ";
				}
				}
				echo "> ".$fname;
				} else {
					echo "&nbsp;";
				}
				echo "</td>\n";
				$i++;
			}
			echo "</tr>\n";
		}
		echo "</table>";
	}

	/*
	array = array(
		array("name" => "", "value" => ""),
		array("name" => "", "value" => "")
		)
	*/
	public function dropdown($array,$name,$selected='') {

		echo "<select name=\"".$name."\" id=\"".$name."\">\n";
		echo "<option value=\"\">Select Option</option>\n";
		for($i=0; $i < count($array); $i++) {
			$data = $array[$i];
			$fname = $data['name'];
			$fvalue = $data['value'];
			echo "<option value=\"".$fvalue."\"";
			if($selected == $fvalue) echo " SELECTED ";
			echo ">".$fname."</option>\n";
		}
		echo "</select>\n";
		
	}

	public function textfield($name,$value='') {
		
		echo "<input type=\"text\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\" size=80>\n";
		
	}
	
	public function textarea($name,$value='') {
		
		echo "<textarea name=\"".$name."\" id=\"".$name."\" rows=20 cols=80>".$value."</textarea>";
		
	}

}
?>
