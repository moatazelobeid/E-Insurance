<?php
// message management
// class name: message
class message {
	
	// var
	public $msg;
	
	// methods
	public function __construct(){
		//unset($_SESSION['msg']);
	}
	
	public function setMsg($param,$sts=1){
		$_SESSION['msg'] = $this->msg = $param;
		$_SESSION['status'] = $this->msg = $sts;
	}

}
?>