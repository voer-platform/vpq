<?php
App::uses('AppController', 'Controller');
/**
 * TestsCategories Controller
 *
 * @property TestsCategory $TestsCategory
 * @property PaginatorComponent $Paginator
 */
class TestsCategoriesController extends AppController {

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
		$this->TestsCategory->recursive = 0;
		$this->set('testsCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TestsCategory->exists($id)) {
			throw new NotFoundException(__('Invalid tests category'));
		}
		$options = array('conditions' => array('TestsCategory.' . $this->TestsCategory->primaryKey => $id));
		$this->set('testsCategory', $this->TestsCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TestsCategory->create();
			if ($this->TestsCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The tests category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tests category could not be saved. Please, try again.'));
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
		if (!$this->TestsCategory->exists($id)) {
			throw new NotFoundException(__('Invalid tests category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TestsCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The tests category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tests category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TestsCategory.' . $this->TestsCategory->primaryKey => $id));
			$this->request->data = $this->TestsCategory->find('first', $options);
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
		$this->TestsCategory->id = $id;
		if (!$this->TestsCategory->exists()) {
			throw new NotFoundException(__('Invalid tests category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TestsCategory->delete()) {
			$this->Session->setFlash(__('The tests category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The tests category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
