<?php
	class ContactsController extends AppController {
		public $uses = array('User');
		public $helpers = array('Js');
		public $components = array('Paginator','Session');
		
		public function index() {
			$this->User->recursive = 0;
			$this->set('contacts',$this->Paginator->paginate());
		}
	}
?>