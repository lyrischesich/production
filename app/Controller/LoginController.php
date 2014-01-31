<?php

App::uses('Controller', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');


/**
 * Login Controller
 */
class LoginController extends AppController {
	
	public $components = array('Session');
	
	public function index() {		
		$pwh = new SimplePasswordHasher();
		$this->set('abc', $pwh->hash("kuchen"));
		debug($this->Auth->login());
// 		$this->set('eingelogt', $this->Auth->loggedIn());
		if ($this->request->is('post')) {
			if ($this->Auth->login()) { 
// 				$this->set('eingelogt', $this->Auth->loggedIn());
				return $this->redirect(array('controller' => 'users', 'action' => 'abc'));				
			}
			$this->set('eingelogt', $this->Auth->loggedIn());
			$this->Session->setFlash(__('Invalid username or password, try again'));
		} else {
			$this->set('eingelogt', $this->request->method());
		}
	}
	
	public function beforeFilter() {
		$this->Auth->allow('index');
	}	
	
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
}

