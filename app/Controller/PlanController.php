<?php

class PlanController extends AppController {
	
	public $uses = array('Specialdate','ColumnsUser','ColumnsText');
	public $helpers = array('Js','Time');
	public $components = array('Paginator','Session');

	public function index() {
		$time = time();
		debug($this->Time->nice($time));
		
	}
}
?>
