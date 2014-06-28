<?php
App::uses('AppController', 'Controller');
/**
 * QuestionsCategories Controller
 *
 * @property QuestionsCategory $QuestionsCategory
 * @property PaginatorComponent $Paginator
 */
class QuestionsCategoriesController extends AppController {

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
		$this->QuestionsCategory->recursive = 0;
		$this->set('questionsCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->QuestionsCategory->exists($id)) {
			throw new NotFoundException(__('Invalid questions category'));
		}
		$options = array('conditions' => array('QuestionsCategory.' . $this->QuestionsCategory->primaryKey => $id));
		$this->set('questionsCategory', $this->QuestionsCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->QuestionsCategory->create();
			if ($this->QuestionsCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The questions category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The questions category could not be saved. Please, try again.'));
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
		if (!$this->QuestionsCategory->exists($id)) {
			throw new NotFoundException(__('Invalid questions category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->QuestionsCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The questions category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The questions category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('QuestionsCategory.' . $this->QuestionsCategory->primaryKey => $id));
			$this->request->data = $this->QuestionsCategory->find('first', $options);
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
		$this->QuestionsCategory->id = $id;
		if (!$this->QuestionsCategory->exists()) {
			throw new NotFoundException(__('Invalid questions category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->QuestionsCategory->delete()) {
			$this->Session->setFlash(__('The questions category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The questions category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
