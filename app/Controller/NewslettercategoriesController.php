<?php
App::uses('AppController', 'Controller');
/**
 * Newslettercategories Controller
 *
 * @property Newslettercategory $Newslettercategory
 * @property PaginatorComponent $Paginator
 */
class NewslettercategoriesController extends AppController {

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
		$this->Newslettercategory->recursive = 0;
		$this->set('newslettercategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Newslettercategory->exists($id)) {
			throw new NotFoundException(__('Invalid newslettercategory'));
		}
		$options = array('conditions' => array('Newslettercategory.' . $this->Newslettercategory->primaryKey => $id));
		$this->set('newslettercategory', $this->Newslettercategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Newslettercategory->create();
			if ($this->Newslettercategory->save($this->request->data)) {
				$this->Session->setFlash(__('The newslettercategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newslettercategory could not be saved. Please, try again.'));
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
		if (!$this->Newslettercategory->exists($id)) {
			throw new NotFoundException(__('Invalid newslettercategory'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Newslettercategory->save($this->request->data)) {
				$this->Session->setFlash(__('The newslettercategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newslettercategory could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Newslettercategory.' . $this->Newslettercategory->primaryKey => $id));
			$this->request->data = $this->Newslettercategory->find('first', $options);
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
		$this->Newslettercategory->id = $id;
		if (!$this->Newslettercategory->exists()) {
			throw new NotFoundException(__('Invalid newslettercategory'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Newslettercategory->delete()) {
			$this->Session->setFlash(__('The newslettercategory has been deleted.'));
		} else {
			$this->Session->setFlash(__('The newslettercategory could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
