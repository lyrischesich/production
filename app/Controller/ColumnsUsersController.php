<?php
App::uses('AppController', 'Controller');
/**
 * ColumnsUsers Controller
 *
 * @property ColumnsUser $ColumnsUser
 * @property PaginatorComponent $Paginator
 */
class ColumnsUsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ColumnsUser->recursive = 0;
		$this->set('columnsUsers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ColumnsUser->exists($id)) {
			throw new NotFoundException(__('Invalid columns user'));
		}
		$options = array('conditions' => array('ColumnsUser.' . $this->ColumnsUser->primaryKey => $id));
		$this->set('columnsUser', $this->ColumnsUser->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ColumnsUser->create();
			if ($this->ColumnsUser->save($this->request->data)) {
				$this->Session->setFlash(__('The columns user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The columns user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ColumnsUser->exists($id)) {
			throw new NotFoundException(__('Invalid columns user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ColumnsUser->save($this->request->data)) {
				$this->Session->setFlash(__('The columns user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The columns user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ColumnsUser.' . $this->ColumnsUser->primaryKey => $id));
			$this->request->data = $this->ColumnsUser->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ColumnsUser->id = $id;
		if (!$this->ColumnsUser->exists()) {
			throw new NotFoundException(__('Invalid columns user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ColumnsUser->delete()) {
			$this->Session->setFlash(__('The columns user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The columns user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
