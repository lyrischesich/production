<?php
App::uses('AppController', 'Controller');
/**
 * Changelogs Controller
 *
 * @property Changelog $Changelog
 * @property PaginatorComponent $Paginator
 */
class ChangelogsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
	public $paginate = array(
			'fields' => array('Changelog.for_date','Changelog.change_date','Changelog.value_before','Changelog.value_after','Changelog.column_name','Changelog.user_did'),
			'limit' => 25,
			'order' => array(
					'Changelog.change_date' => 'desc'
			),
	);

/**
 * index method
 *
 * @return void
 */
	public function index($count=50) {
		$this->Changelog->recursive = 0;
		$this->paginate['limit'] = $count;
		$this->Paginator->settings = $this->paginate;				
		$this->set('changelogs', $this->Paginator->paginate());
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Changelog->exists($id)) {
			throw new NotFoundException(__('Invalid changelog'));
		}
		$options = array('conditions' => array('Changelog.' . $this->Changelog->primaryKey => $id));
		$this->set('changelog', $this->Changelog->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Changelog->create();
			if ($this->Changelog->save($this->request->data)) {
				$this->Session->setFlash(__('The changelog has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The changelog could not be saved. Please, try again.'));
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
		if (!$this->Changelog->exists($id)) {
			throw new NotFoundException(__('Invalid changelog'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Changelog->save($this->request->data)) {
				$this->Session->setFlash(__('The changelog has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The changelog could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Changelog.' . $this->Changelog->primaryKey => $id));
			$this->request->data = $this->Changelog->find('first', $options);
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
		$this->Changelog->id = $id;
		if (!$this->Changelog->exists()) {
			throw new NotFoundException(__('Invalid changelog'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Changelog->delete()) {
			$this->Session->setFlash(__('The changelog has been deleted.'));
		} else {
			$this->Session->setFlash(__('The changelog could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
