<?php
App::uses('AppController', 'Controller');
/**
 * Subcategories Controller
 *
 * @property Subcategory $Subcategory
 * @property PaginatorComponent $Paginator
 */
class SubcategoriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/*
 * beforeFilter
 */
    public function beforeFilter(){
        parent::beforeFilter();
        // Allow users to
        $this->Auth->allow('viewScoresSubcategory');

        Security::setHash('md5');
    }	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Subcategory->recursive = 0;
		$this->set('subcategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
		$this->set('subcategory', $this->Subcategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Subcategory->create();
			if ($this->Subcategory->save($this->request->data)) {
				$this->Session->setFlash(__('The subcategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subcategory could not be saved. Please, try again.'));
			}
		}
		$grades = $this->Subcategory->Grade->find('list');
		$categories = $this->Subcategory->Category->find('list');
		$questions = $this->Subcategory->Question->find('list');
		$this->set(compact('grades', 'categories', 'questions'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Subcategory->save($this->request->data)) {
				$this->Session->setFlash(__('The subcategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subcategory could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
			$this->request->data = $this->Subcategory->find('first', $options);
		}
		$grades = $this->Subcategory->Grade->find('list');
		$categories = $this->Subcategory->Category->find('list');
		$questions = $this->Subcategory->Question->find('list');
		$this->set(compact('grades', 'categories', 'questions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Subcategory->id = $id;
		if (!$this->Subcategory->exists()) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Subcategory->delete()) {
			$this->Session->setFlash(__('The subcategory has been deleted.'));
		} else {
			$this->Session->setFlash(__('The subcategory could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * view scores on one subcategories
 *
 * @param string $id
 * @return void
 */
	public function viewScoresSubcategory($id) {
		$this->layout = 'question_bank';
		$this->set('title_for_layout',__("History"));

		$this->loadModel('Score');
		$result = $this->Score->getScoresForSubcategory($this->Session->read('Auth.User')['id'], $id);
		$this->set('scores', $result);
		$this->set('subcategory_id', $id);
	}

}
