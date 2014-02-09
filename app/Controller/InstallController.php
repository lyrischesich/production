<?php

class InstallController extends AppController {
	
	public function index() {
		
	}
	
	public function import() {
		
	}
	
	public function create() {
		
	}
	
	public function beforeFilter() {
		$this->Auth->allow("index", "import", "create");
	}
	
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}

?>