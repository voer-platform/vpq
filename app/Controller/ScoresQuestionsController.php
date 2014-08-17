<?php
App::uses('AppController', 'Controller');
/**
 * ScoresQuestions Controller
 *
 * @property ScoresQuestion $ScoresQuestion
 * @property PaginatorComponent $Paginator
 */
class ScoresQuestionsController extends AppController {

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
		$this->ScoresQuestion->recursive = 0;
		$this->set('scoresQuestions', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ScoresQuestion->exists($id)) {
			throw new NotFoundException(__('Invalid scores question'));
		}
		$options = array('conditions' => array('ScoresQuestion.' . $this->ScoresQuestion->primaryKey => $id));
		$this->set('scoresQuestion', $this->ScoresQuestion->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ScoresQuestion->create();
			if ($this->ScoresQuestion->save($this->request->data)) {
				$this->Session->setFlash(__('The scores question has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The scores question could not be saved. Please, try again.'));
			}
		}
		$scores = $this->ScoresQuestion->Score->find('list');
		$questions = $this->ScoresQuestion->Question->find('list');
		$this->set(compact('scores', 'questions'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ScoresQuestion->exists($id)) {
			throw new NotFoundException(__('Invalid scores question'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ScoresQuestion->save($this->request->data)) {
				$this->Session->setFlash(__('The scores question has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The scores question could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ScoresQuestion.' . $this->ScoresQuestion->primaryKey => $id));
			$this->request->data = $this->ScoresQuestion->find('first', $options);
		}
		$scores = $this->ScoresQuestion->Score->find('list');
		$questions = $this->ScoresQuestion->Question->find('list');
		$this->set(compact('scores', 'questions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ScoresQuestion->id = $id;
		if (!$this->ScoresQuestion->exists()) {
			throw new NotFoundException(__('Invalid scores question'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ScoresQuestion->delete()) {
			$this->Session->setFlash(__('The scores question has been deleted.'));
		} else {
			$this->Session->setFlash(__('The scores question could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
