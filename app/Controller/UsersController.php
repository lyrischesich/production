<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		if ($this->request->is("post")) {
			$activeUsers = $this->User->find('all', array('recursive' => -1, 'conditions' => array('User.leave_date' => null)));
			$activeUsersList = array();
			foreach ($activeUsers as $activeUser) {
				array_push($activeUsersList, $activeUser['User']['id']);
			}


			foreach ($this->request->data['User'] as $id => $data) {
				$tmpArray = array();
				$tmpArray['User']['id'] = $id;
				$tmpArray['User']['admin'] = $data['admin'];	
				if ($data['leave_date'] == 0){
					if (in_array($id, $activeUsersList)){
						$tmpArray['User']['leave_date'] = date('Y-m-d');
					}
				} else {
					$tmpArray['User']['leave_date'] = null;
				}

				$this->User->create();
				if ($this->User->save($tmpArray)) {
					$this->Session->setFlash('Die Änderungen wurden gespeichert.', 'alert-box', array('class' => 'alert-success'));
				} else {
					$this->Session->setFlash('Die Änderungen konnten nicht gespeichert werden.', 'alert-box', array('class' => 'alert-error'));
				}
			}
		}

		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	public function beforeRender() {
		$this->set('enumValues',$this->User->getEnumValues('mo'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('Der Benutzer wurde angelegt.', "alert-box", array("class" => 'alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Der Benutzer konnte nicht gespeichert werden. Bitte versuchen Sie es noch einmal.', "alert-box", array("class" => 'alert-error'));
			}
		}
		$columns = $this->User->Column->find('list');
		$this->set(compact('columns'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id=-1) {
		if ($id == -1) $id = AuthComponent::user('id');
		if (!$this->User->exists($id)) {
			throw new NotFoundException('Unbekannter Benutzer');
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('Die Änderungen wurden gespeichert.');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Die Änderungen konnten nicht gespeichert werden. Bitte versuchen Sie es noch einmal.');
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$columns = $this->User->Column->find('list');
		$this->set(compact('columns'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
