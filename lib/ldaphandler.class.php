<?php

class ldaphandler {

	private $conn;
	private $bind;
	private $readhost;
	private $nr_readhosts = 0;
	
	public function __construct() { }
	
	public function __destruct() { 
		ldap_unbind($this->conn);
	}
	
	public function AddHost($hostname,$ssl=false) {
		$this->readhost[$this->nr_readhosts]['hostname'] = $hostname;
		$this->readhost[$this->nr_readhosts]['ssl'] = $ssl;
		$this->nr_readhosts++;
	}
	
	public function SetAuth($username,$password) {
		if(!empty($username) && !empty($password)) {
			$this->auth['username']=$username;
			$this->auth['password']=$password;
			$this->auth['anonymous']=0;
		} else {
			$this->auth['anonymous']=1;
		}
	}
	
	public function SetBase($base) {
		$this->base = $base;
	}
	
	public function Connect() {
		$host_id = $this->__select_read_host();
		if($host_id['ssl']==true) { $port = "636"; } else { $port = "389"; }
		$this->conn = ldap_connect($this->readhost[$host_id]['hostname'],$port) or die("Could not connect");
		ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		if($this->auth['anonymous']==0) {
			$this->bind = ldap_bind($this->conn,$this->auth['username'],$this->auth['password']);
		} else {
			$this->bind = ldap_bind($this->conn);
		}
	}
	
	public function Search($search,$fields) {
		$ret = ldap_search($this->conn,$this->base,$search,$fields);
		$return = ldap_get_entries($this->conn,$ret);
		return($return);
	}

	private function __select_read_host() {
                $nr_hosts = count($this->readhost);
                $host_id = mt_rand(0,$nr_hosts-1);
                return($host_id);
        }
}

?>
