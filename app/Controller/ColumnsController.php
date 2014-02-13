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
			
			$options = array('fields' => 'MAX(`order`) AS max');
			$maxOrder = $this->Column->find('first', $options);
			$this->request->data['Column']['order'] = $maxOrder[0]['max']+1;
			$this->Column->create();
			if ($this->Column->save($this->request->data)) {
				$this->Session->setFlash('Die Spalte wurde angelegt.', 'alert-box', array('class' => 'alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Die Spalte konnte nicht gespeichert werden.', 'alert-box', array('class' => 'alert-error'));
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
		if (!$this->Column->exists($id)) {
			throw new NotFoundException('Unbekannte Spalte');
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Column->save($this->request->data)) {
				$this->Session->setFlash('Die Spalte wurde gespeichert.', 'alert-box', array('class' => 'alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Die Spalte konnte nicht gespeichert werden.', 'alert-box', array('class' => 'alert-error'));
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
			throw new NotFoundException('Unbekannte Spalte');
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Column->delete()) {
			$this->Session->setFlash('Die Spalte wurde gelöscht.', 'alert-box', array('class' => 'alert-success'));
		} else {
			$this->Session->setFlash('Die Spalte konnte nicht gelöscht werden.', 'alert-box', array('class' => 'alert-error'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
