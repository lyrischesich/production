<?php
App::uses("User", "Model");
class InstallController extends AppController {
	
	public $uses = array('User');
	public $components = array('Session');
	
	public function index() {
		
	}
	
	public function import() {
		
	}
	
	public function create() {
		
		if ($this->request->is('post')) {
			$this->request->data['User']['lname'] = $this->request->data['User']['username'];
			$this->request->data['User']['admin'] = 1;
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('Benutzer wurde angelegt.'));
			} else {
				$this->Session->setFlash(__('Benutzer konnte nicht angelegt werden.'));
			}
			
		}

	}
	
	public function beforeFilter() {
		$this->Auth->allow("index", "import", "create", "fehla");
	}
	
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
}

?>