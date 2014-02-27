<?php

class PlanController extends AppController {
	
// 	public $uses = array('Specialdate','ColumnsUser','ColumnsText');
	public $helpers = array('Js','Time');
	public $components = array('Paginator','Session');

	public function index($month=-1, $year=-1) {
		$this->set('results', $this->Plan->getPlanData($month, $year));
	}
	
	
	public function isAuthorized($user) {
		//Alle angemeldeten Benutzer dürfen den Plan einsehen
		return true;
	}
}
?>
