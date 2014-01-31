<?php
App::uses('AppController', 'Controller');
/**
 * Columns Controller
 *
 * @property Column $Column
 * @property PaginatorComponent $Paginator
 */
class ColumnsController extends AppController {

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
		$this->Column->recursive = 0;
		$this->set('columns', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Column->exists($id)) {
			throw new NotFoundException(__('Invalid column'));
		}
		$options = array('conditions' => array('Column.' . $this->Column->primaryKey => $id));
		$this->set('column', $this->Column->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Column->create();
			if ($this->Column->save($this->request->data)) {
				$this->Session->setFlash(__('The column has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The column could not be saved. Please, try again.'));
			}
		}
		$users = $this->Column->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Column->exists($id)) {
			throw new NotFoundException(__('Invalid column'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Column->save($this->request->data)) {
				$this->Session->setFlash(__('The column has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The column could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Column.' . $this->Column->primaryKey => $id));
			$this->request->data = $this->Column->find('first', $options);
		}
		$users = $this->Column->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Column->id = $id;
		if (!$this->Column->exists()) {
			throw new NotFoundException(__('Invalid column'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Column->delete()) {
			$this->Session->setFlash(__('The column has been deleted.'));
		} else {
			$this->Session->setFlash(__('The column could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}