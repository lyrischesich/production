<?php

class PlanController extends AppController {
	
	//public $uses = array('Specialdate','ColumnsUser','ColumnsText');
	public $uses = array('Plan');
	public $helpers = array('Js','Time');
	public $components = array('Paginator','Session');

	public function index() {
		
		debug($this->Plan->getCurrentMonth());
		
	}
}
?>
