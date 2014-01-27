<?php
App::uses('AppController', 'Controller');
/**
 * Specialdates Controller
 *
 * @property Specialdate $Specialdate
 * @property PaginatorComponent $Paginator
 */
class SpecialdatesController extends AppController {

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
		$this->Specialdate->recursive = 0;
		$this->set('specialdates', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Specialdate->exists($id)) {
			throw new NotFoundException(__('Invalid specialdate'));
		}
		$options = array('conditions' => array('Specialdate.' . $this->Specialdate->primaryKey => $id));
		$this->set('specialdate', $this->Specialdate->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Specialdate->create();
			if ($this->Specialdate->save($this->request->data)) {
				$this->Session->setFlash(__('The specialdate has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The specialdate could not be saved. Please, try again.'));
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
		if (!$this->Specialdate->exists($id)) {
			throw new NotFoundException(__('Invalid specialdate'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Specialdate->save($this->request->data)) {
				$this->Session->setFlash(__('The specialdate has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The specialdate could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Specialdate.' . $this->Specialdate->primaryKey => $id));
			$this->request->data = $this->Specialdate->find('first', $options);
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
		$this->Specialdate->id = $id;
		if (!$this->Specialdate->exists()) {
			throw new NotFoundException(__('Invalid specialdate'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Specialdate->delete()) {
			$this->Session->setFlash(__('The specialdate has been deleted.'));
		} else {
			$this->Session->setFlash(__('The specialdate could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
