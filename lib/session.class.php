<?php

class sessionhandler {

	private $lifetime=604800; // Lifetime
	
	public function __construct($sess_name='') {
		$this->sess_name = "eCG_".$sess_name;
		ini_set("session.gc_maxlifetime",$this->lifetime);
		
	}
	
	public function __destruct() { }
	
	public function SetSavepath($path) {
		session_save_path($path);
	}
	
	public function StartNewSession() {
		session_name($this->sess_name);
		session_set_cookie_params($this->lifetime);
		session_start();
	}
	
	public function StartExistingSession() {
		session_name($this->sess_name);
		session_start();
	}
	
	public function CheckSession() {
		if(isset($_SESSION[$this->sess_name])) {
			return(TRUE);
		}
	}
	
	public function ListSessions() {
		$keys = array_keys($_COOKIE);
		for($i=0; $i < count($_COOKIE); $i++) {
			$key = $keys[$i];
			if(stristr($key,"eCG_")) {
				$list[]=$key;
			}
		}
		return($list);
	}
	
	public function ClearSession() {
		session_unset();
		session_destroy();
	}
	
	public function GetData($name) {
		if(isset($_SESSION[$this->sess_name][$name]) && !empty($_SESSION[$this->sess_name][$name])) {
			return($_SESSION[$this->sess_name][$name]);
		}
	}
	
	public function SetData($name,$value) {
		$_SESSION[$this->sess_name][$name] = $value;
	}
	
}

?>
