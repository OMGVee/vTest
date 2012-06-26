<?php

class mailhandler {
	
	public $version = "0.1";
	private $headers;
	private $content;
	private $subject;
	private $to;
	private $multipart = FALSE;
	private $encoding;
	
	public function __construct($encoding='') { 
		$this->encoding = $encoding;
		
		$this->SetHeader("MIME-Version","1.0");
		$this->SetHeader("Content-Type","text/plain; charset=iso-8859-1");
	}
	
	public function __destruct() { }
	
	private function SetHeader($name,$value) {
		$this->headers[$name]=$value;
	}
	
	
	public function From($name,$email) {
		$this->SetHeader("From","\"$name\" <$email>");
		$this->SetHeader("Reply-To","\"$name\" <$email>");
		$this->SetHeader("Return-Path",$email);
		$this->SetHeader("Errors-To",$email);
		
	}
	
	public function Subject($subject) {
		$this->subject = $subject;
        }
	
	public function AddTo($name,$email) {
		$this->to[]= "\"$name\" <$email>";
	}

	public function AddCc($name,$email) {
		if(!empty($this->headers['Cc'])) {
                        $org = $this->headers['Cc'];
                        $this->SetHeader("Cc",$org.",\"$name\" <$email>");
                } else {
                        $this->SetHeader("Cc","\"$name\" <$email>");
                }
	}
	
	public function AddBcc($name,$email) {
		if(!empty($this->headers['Bcc'])) {
                        $org = $this->headers['Bcc'];
                        $this->SetHeader("Bcc",$org.",\"$name\" <$email>");
                } else {
                        $this->SetHeader("Bcc","\"$name\" <$email>");
                }
	}
	
	public function SetPriority($prio='normal') {
		switch($prio) {
			case'low':
				$this->SetHeader("X-Priority","5 (Lowest)");
				$this->SetHeader("Importance","Low");
			break;
			case'normal':
				$this->SetHeader("X-Priority","3 (Normal)");
                                $this->SetHeader("Importance","Normal");
			break;
			case'high':
				$this->SetHeader("X-Priority","1 (Highest)");
				$this->SetHeader("Importance","High");
			break;
		}
	}
	
	public function AddContent($content,$type='plain') {
		$this->content[$type]=$content;
	}
	
	public function AddAttachment($file) {
	}
	
	private function BuildHeaders() {
		$header = "";
		$header_keys = array_keys($this->headers);
		for($i=0; $i < count($this->headers); $i++) {
			$key = $header_keys[$i];
			$header.= $key.": ".$this->headers[$key]." \n";
		}
		return($header);
	}
	
	private function BuildContent() {
		$content = $this->content['plain'];
		return($content);
	}
	
	private function BuildTo() {
		$to = "";
		for($i=0; $i < count($this->to); $i++) {
			$data = $this->to[$i];
			$to.=$data.",";
		}
		$to = substr($to,0,-1);
		return($to);
	}
	
	private function BuildSubject() {
		$subject = $this->subject;
		return($subject);
	}

	public function Send() {
		if(!empty($this->to) && !empty($this->subject) && !empty($this->headers['From']) && !empty($this->content)) {
			return(mail($this->BuildTo(),$this->BuildSubject(),$this->BuildContent(),$this->BuildHeaders()));
		} else {
			echo "Sendmail error";
		}
	}
	
	

}

?>
