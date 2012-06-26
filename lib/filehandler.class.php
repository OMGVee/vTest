<?php

class FileHandler {
	
	public function __construct() { }
	public function __destruct() { }
	
	
	/* Helper functions */
	
	/* Begin Locking functions */
	
	private function __GetLock($type='rw') {
		$type == 'r' ? define("LOCK",LOCK_SH) : define("LOCK",LOCK_EX);
		while (!flock($this->fp, LOCK | LOCK_NB)) {
			usleep(round(rand(0, 100)*1000));
		}
		return(TRUE);
	}
	
	private function __ReleaseLock() {
		return(flock($this->fp, LOCK_UN));
	}
	
	private function __CheckLock() {
		
		$fp_try = fopen($this->file,'r');
		$try=0;
		while (!flock($fp_try, LOCK | LOCK_NB)) {
		        usleep(round(rand(0, 100)*1000));
		        if($try > 5) {
		                return(TRUE);
		        }
		        $try++;
		}
		if($try < 5) {
		        flock($fp_try,LOCK_UN);
			$this->error[] = "Don't have a lock";
			return(FALSE);
		}
		fclose($fp_try);
	}
	
	/*  End Locking functions */
	
	private function __CloseFile() {
		return(fclose($this->fp));
	}
	
	private function __HaveFileOpen() {
		return(is_resource($this->fp));
		
	}
	
	private function __OpenFile($file,$mode) {
		if($this->__CheckFile($file,$mode)==TRUE) {
			$this->fp = fopen($file,$mode);
			if(!$this->fp) {
				$this->error[] = "unable to open file";
				return(FALSE);
			} else {
				return(TRUE);
			}
		} else {
			return(FALSE);
		}
	}
	
	private function __CheckFile($file,$mode) {
		$this->lock = $mode == 'r' ? 'r' : 'rw';
		if($mode == "r" || $mode == "r+" ) {
	                if(file_exists($file)) {
        	                if(($this->lock == 'r' || $this->lock == 'rw') && is_readable($file) == FALSE) {
                	                //error
                        	        $this->error[] = "File is not readable";
                                	return(FALSE);
	                        }
        	                if($this->lock == 'rw' && is_writeable($file) == FALSE) {
                	                // Error
                        	        $this->error[] = "File is not writeable";
                                	return(FALSE);
	                        }
        	        } else {
                	        $this->error[] = "File does not exist";
                        	return(FALSE);
	                }
		}
		return(TRUE);
	}	
	
	
	private function __ReadFile() {
		$buff="";
		while(!feof($this->fp)) {
			$buff.=fread($this->fp,2048);
		}
		return($buff);
	}
	
	/* Filehandler functions */
	
	public function Open($file,$mode) {
		$this->file = $file;
		$this->mode = $mode;
                if($this->__OpenFile($this->file,$this->mode) == TRUE) {
			if($this->__HaveFileOpen() == TRUE) {
				if($this->__GetLock($this->lock) == TRUE ) {
					return(TRUE);
				}
			}
		}
		return(FALSE);
        }

        public function Close() {
		if($this->__HaveFileOpen() == TRUE) {
	               	if($this->__ReleaseLock() == FALSE) {
				$this->error[] = "Error in releasing lock";
			} else {
				if($this->__CloseFile() == FALSE) {
					$this->error[] = "Error in closing file";
				} else {
					return(TRUE);
				}
			}
		}
		return(FALSE);
	}
	
	public function Write($data) {
		if($this->__CheckLock() == TRUE && $this->__HaveFileOpen() == TRUE) {
			return(fwrite($this->fp,$data,strlen($data)));
		}
	}
	
	public function Read($line='') {
		if($this->__CheckLock() == TRUE && $this->__HaveFileOpen() == TRUE) {
			$buffer = "";
			while(!feof($this->fp)) {
				if($line != "") {
					$buffer[]=fgets($this->fp,1024);
				} else {
					$buffer.=fgets($this->fp,1024);
				}
			}
			if($line != "") {
				return(str_replace("\n","",$buffer[$line]));
			} else {
				return($buffer);
			}
		} else {
			return(FALSE);
		}
	}
	
	public function GetLineNo($string,$searchtype='is',$multi=FALSE,$sensitive=FALSE) {
		if($this->__CheckLock() == TRUE && $this->__HaveFileOpen() == TRUE) {
			$buffer = "";
			$found=0;
			$line=0;
			$found_lines = "";
			
			if($sensitive==TRUE) {
				$strsearch="strstr";
			} else {
				$strsearch="stristr";
			}
			
			while(!feof($this->fp)) {
				$buffer = fgets($this->fp,1024);
				switch($searchtype) {
					case'contains':
						if($strsearch(str_replace("\n","",$buffer),$string) == TRUE) $found=1;
					break;
					case'is':
						if(str_replace("\n","",$buffer) == $string) $found=1;
					break;
					case'notcontains':
						if(strsearch(str_replace("\n","",$buffer),$string) == FALSE) $found=1;
					break;
					case'notis':
						if(str_replace("\n","",$buffer) != $string) $found=1;
					break;
					default:
						$this->error[] = "Invalid Searchtype given";
						return(FALSE);
					break;
				}
				if($found==1) {
					if($multi==FALSE) {
						return($line);
					} else {
						$found_lines[]=$line;
					}
					$found=0;
				}
				$line++;
			}
			if($multi==TRUE) {
				return($found_lines);
			}
		} else {
			return(FALSE);
		}
	}
	
	public function ReplaceLine($lineno,$string) {
		if($this->__CheckLock() == TRUE && $this->__HaveFileOpen() == TRUE) {
			$multi = FALSE;
	                $replace = FALSE;
	                $buffer = "";
	                $line = 0;
	                $count = 0;
	
	                if(is_array($lineno) && is_array($string)) {
	                        if(count($lineno) == count($string)) {
	                                $this->error[] = "Number of lines is not the same as number of strings";
	                                return(FALSE);
	                        }
	                        $multi = TRUE;
	                }
			
			while(!feof($this->fp)) {
				if($multi == TRUE) {
					if($key = array_search($line,$lineno)) {
						$replace=TRUE;
						$buffer.=$string[$key];
					}
				} else {
					if($line == $lineno) {
						$replace=TRUE;
						$buffer.=$string;
					}
				}
				if($replace==FALSE) {
					$buffer.= fgets($this->fp,1024);
				} else {
					fgets($this->fp,1024);
				}
				$replace=FALSE;
				$line++;
			}
			$this->EmptyFile();
			$this->Write($buffer."\n");
			
			return(TRUE);
		} else {
			return(FALSE);
		}
	}
	
	Public function EmptyFile() {
		if($this->__CheckLock() == TRUE && $this->__HaveFileOpen() == TRUE) {
			return(ftruncate($this->fp,0));
		}
	}
	
	public function RemoveLine($lineno) {
		if($this->__CheckLock() == TRUE && $this->__HaveFileOpen() == TRUE) {
			$replace = FALSE;
	                $multi = FALSE;
	                $line = 0;
	                $buffer = "";
	
	                if(is_array($lineno)) $multi = TRUE;

			while(!feof($this->fp)) {
				if($multi == TRUE){
					if(array_search($line,$lineno)) {
						$replace = TRUE;
					}
				} else {
					if($line == $lineno) {
						$replace = TRUE;
					}
				}
				if($replace == FALSE) {
					$buffer.=fgets($this->fp,1024);
				} else {
					fgets($this->fp,1024);
					$replace = FALSE;
				}
				$line++;
			}
			$this->EmptyFile();
			$this->Write($buffer);
			return(TRUE);
		} else {
			return(FALSE);
		}
	}
	
	public function FileInfo() {
		if($this->__HaveFileOpen() == TRUE) {
			$fileinfo = fstat($this->fp);
			clearstatcache();
			return($fileinfo);
		}
	}
	
	public function GetErrors() {
		if(isset($this->error) && is_array($this->error) && !empty($this->error)) {
			for($i=0; $i < count($this->error); $i++) {
				echo "Error [$i]: ".$this->error[$i]."<br />\n";
			}
			return(TRUE);
		} else {
			return(FALSE);
		}
	}
}

?>
