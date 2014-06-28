<?php
App::uses('AppController', 'Controller');
/**
 * TestsQuestions Controller
 *
 * @property TestsQuestion $TestsQuestion
 * @property PaginatorComponent $Paginator
 */
class TestsQuestionsController extends AppController {

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
		$this->TestsQuestion->recursive = 0;
		$this->set('testsQuestions', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TestsQuestion->exists($id)) {
			throw new NotFoundException(__('Invalid tests question'));
		}
		$options = array('conditions' => array('TestsQuestion.' . $this->TestsQuestion->primaryKey => $id));
		$this->set('testsQuestion', $this->TestsQuestion->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TestsQuestion->create();
			if ($this->TestsQuestion->save($this->request->data)) {
				$this->Session->setFlash(__('The tests question has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tests question could not be saved. Please, try again.'));
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
		if (!$this->TestsQuestion->exists($id)) {
			throw new NotFoundException(__('Invalid tests question'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TestsQuestion->save($this->request->data)) {
				$this->Session->setFlash(__('The tests question has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tests question could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TestsQuestion.' . $this->TestsQuestion->primaryKey => $id));
			$this->request->data = $this->TestsQuestion->find('first', $options);
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
		$this->TestsQuestion->id = $id;
		if (!$this->TestsQuestion->exists()) {
			throw new NotFoundException(__('Invalid tests question'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TestsQuestion->delete()) {
			$this->Session->setFlash(__('The tests question has been deleted.'));
		} else {
			$this->Session->setFlash(__('The tests question could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
