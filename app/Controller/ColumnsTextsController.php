<?php
App::uses('AppController', 'Controller');
/**
 * ColumnsTexts Controller
 *
 * @property ColumnsText $ColumnsText
 * @property PaginatorComponent $Paginator
 */
class ColumnsTextsController extends AppController {

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
		$this->ColumnsText->recursive = 0;
		$this->set('columnsTexts', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ColumnsText->exists($id)) {
			throw new NotFoundException(__('Invalid columns text'));
		}
		$options = array('conditions' => array('ColumnsText.' . $this->ColumnsText->primaryKey => $id));
		$this->set('columnsText', $this->ColumnsText->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ColumnsText->create();
			if ($this->ColumnsText->save($this->request->data)) {
				$this->Session->setFlash(__('The columns text has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The columns text could not be saved. Please, try again.'));
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
		if (!$this->ColumnsText->exists($id)) {
			throw new NotFoundException(__('Invalid columns text'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ColumnsText->save($this->request->data)) {
				$this->Session->setFlash(__('The columns text has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The columns text could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ColumnsText.' . $this->ColumnsText->primaryKey => $id));
			$this->request->data = $this->ColumnsText->find('first', $options);
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
		$this->ColumnsText->id = $id;
		if (!$this->ColumnsText->exists()) {
			throw new NotFoundException(__('Invalid columns text'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ColumnsText->delete()) {
			$this->Session->setFlash(__('The columns text has been deleted.'));
		} else {
			$this->Session->setFlash(__('The columns text could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
