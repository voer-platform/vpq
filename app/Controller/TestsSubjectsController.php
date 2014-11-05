<?php
App::uses('AppController', 'Controller');
/**
 * TestsSubjects Controller
 *
 * @property TestsSubject $TestsSubject
 * @property PaginatorComponent $Paginator
 */
class TestsSubjectsController extends AppController {

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
		$this->TestsSubject->recursive = 0;
		$this->set('testsSubjects', $this->Paginator->paginate());
	}

/*
 * authorization
 * 
 */
	public function isAuthorized($user) {
	    // only admin can do 
	    if (isset($user['role']) && $user['role'] === 'editor' ){
	    	return true;
	    }

	    return parent::isAuthorized($user);
	}    	

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TestsSubject->exists($id)) {
			throw new NotFoundException(__('Invalid tests subject'));
		}
		$options = array('conditions' => array('TestsSubject.' . $this->TestsSubject->primaryKey => $id));
		$this->set('testsSubject', $this->TestsSubject->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TestsSubject->create();
			if ($this->TestsSubject->save($this->request->data)) {
				$this->Session->setFlash(__('The tests subject has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tests subject could not be saved. Please, try again.'));
			}
		}
		$tests = $this->TestsSubject->Test->find('list');
		$subjects = $this->TestsSubject->Subject->find('list');
		$this->set(compact('tests', 'subjects'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TestsSubject->exists($id)) {
			throw new NotFoundException(__('Invalid tests subject'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TestsSubject->save($this->request->data)) {
				$this->Session->setFlash(__('The tests subject has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tests subject could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TestsSubject.' . $this->TestsSubject->primaryKey => $id));
			$this->request->data = $this->TestsSubject->find('first', $options);
		}
		$tests = $this->TestsSubject->Test->find('list');
		$subjects = $this->TestsSubject->Subject->find('list');
		$this->set(compact('tests', 'subjects'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TestsSubject->id = $id;
		if (!$this->TestsSubject->exists()) {
			throw new NotFoundException(__('Invalid tests subject'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TestsSubject->delete()) {
			$this->Session->setFlash(__('The tests subject has been deleted.'));
		} else {
			$this->Session->setFlash(__('The tests subject could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
