<?php
App::uses('AppController', 'Controller');
/**
 * Answers Controller
 *
 * @property Answer $Answer
 * @property PaginatorComponent $Paginator
 */
class AnswersController extends AppController {

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
		$this->Answer->recursive = 0;
		$this->set('answers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Answer->exists($id)) {
			throw new NotFoundException(__('Invalid answer'));
		}
		$options = array('conditions' => array('Answer.' . $this->Answer->primaryKey => $id));
		$this->set('answer', $this->Answer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Answer->create();
			if ($this->Answer->save($this->request->data)) {
				$this->Session->setFlash(__('The answer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The answer could not be saved. Please, try again.'));
			}
		}
		$questions = $this->Answer->Question->find('list');
		$this->set(compact('questions'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Answer->exists($id)) {
			throw new NotFoundException(__('Invalid answer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Answer->save($this->request->data)) {
				$this->Session->setFlash(__('The answer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The answer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Answer.' . $this->Answer->primaryKey => $id));
			$this->request->data = $this->Answer->find('first', $options);
		}
		$questions = $this->Answer->Question->find('list');
		$this->set(compact('questions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Answer->id = $id;
		if (!$this->Answer->exists()) {
			throw new NotFoundException(__('Invalid answer'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Answer->delete()) {
			$this->Session->setFlash(__('The answer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The answer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
