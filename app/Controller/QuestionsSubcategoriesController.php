<?php
App::uses('AppController', 'Controller');
/**
 * QuestionsSubcategories Controller
 *
 * @property QuestionsSubcategory $QuestionsSubcategory
 * @property PaginatorComponent $Paginator
 */
class QuestionsSubcategoriesController extends AppController {

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
		$this->QuestionsSubcategory->recursive = 0;
		$this->set('questionsSubcategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->QuestionsSubcategory->exists($id)) {
			throw new NotFoundException(__('Invalid questions subcategory'));
		}
		$options = array('conditions' => array('QuestionsSubcategory.' . $this->QuestionsSubcategory->primaryKey => $id));
		$this->set('questionsSubcategory', $this->QuestionsSubcategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->QuestionsSubcategory->create();
			if ($this->QuestionsSubcategory->save($this->request->data)) {
				$this->Session->setFlash(__('The questions subcategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The questions subcategory could not be saved. Please, try again.'));
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
		if (!$this->QuestionsSubcategory->exists($id)) {
			throw new NotFoundException(__('Invalid questions subcategory'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->QuestionsSubcategory->save($this->request->data)) {
				$this->Session->setFlash(__('The questions subcategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The questions subcategory could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('QuestionsSubcategory.' . $this->QuestionsSubcategory->primaryKey => $id));
			$this->request->data = $this->QuestionsSubcategory->find('first', $options);
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
		$this->QuestionsSubcategory->id = $id;
		if (!$this->QuestionsSubcategory->exists()) {
			throw new NotFoundException(__('Invalid questions subcategory'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->QuestionsSubcategory->delete()) {
			$this->Session->setFlash(__('The questions subcategory has been deleted.'));
		} else {
			$this->Session->setFlash(__('The questions subcategory could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
