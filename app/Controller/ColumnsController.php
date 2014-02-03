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
	public $components = array('Paginator', 'Session');

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
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$maxOrder = $this->Column->find('count');
			$this->request->data['Column']['order'] = ($maxOrder+1);
			$this->Column->create();
			if ($this->Column->save($this->request->data)) {
				$this->Session->setFlash(__('Die Spalte wurde angelegt.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Die Spalte konnte nicht gespeichert werden.'));
			}
			
			return $this->redirect(array('action' => 'index'));
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
		if (!$this->Column->exists($id)) {
			throw new NotFoundException(__('Unbekannte Spalte'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Column->save($this->request->data)) {
				$this->Session->setFlash(__('Die Spalte wurde gespeichert.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Die Spalte konnte nicht gespeichert werden.'));
			}
		} else {
			$options = array('conditions' => array('Column.' . $this->Column->primaryKey => $id));
			$this->request->data = $this->Column->find('first', $options);
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
		$this->Column->id = $id;
		if (!$this->Column->exists()) {
			throw new NotFoundException(__('Invalid column'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Column->delete()) {
			$this->Session->setFlash(__('Die Spalte wurde gelöscht.'));
		} else {
			$this->Session->setFlash(__('Die Spalte konnte nicht gelöscht werden.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
