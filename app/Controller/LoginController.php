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
				if ($this->Auth->user('leave_date') != null) {
					//Der Benutzeraccount wurde deaktiviert
					$this->Session->setFlash('Ihre Logindaten sind zwar korrekt, allerdings wurde Ihr Zugang deaktiviert.<br/>Sollten Sie wieder in der Cafeteria arbeiten wollen, wenden Sie sich bitte an das <a href="mailto:humboldt-cafeteria@versanet.de">Cafeteria-Team</a>.','alert-box',array('class' => 'alert alert-block'));
					return $this->logout();
				}
				
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Session->setFlash(__('Login fehlgeschlagen!'),'alert-box',array('class' => 'alert-error'));
		}
	}
	
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}
	
	
	public function beforeFilter() {
// 		if ($this->User->)
		
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
