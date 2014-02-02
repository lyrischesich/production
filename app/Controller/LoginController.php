<?php

App::uses('Controller', 'Controller');

/**
 * Login Controller
 */
class LoginController extends AppController {
	
	public $components = array('Session');
	
	public function index() {		
		
		//Wenn bereits eingeloggt, dann Umleitung
		if ($this->Auth->loggedIn()) return $this->redirect(array('controller' => 'plan', 'action' => 'index'));
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Auth->login()) {
				
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Session->setFlash(__('Login fehlgeschlagen!'));
		}
	}
	
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'logout');
	}	
	
	public function isAuthorized($user) {
		if (in_array($this->request->action, array ('index', 'logout'))) {
			return true;
		}
		
		return parent::isAuthorized($user);
	}
}