<?php
App::uses('AppController', 'Controller');
/**
 * ScoresAnswers Controller
 *
 * @property ScoresAnswer $ScoresAnswer
 * @property PaginatorComponent $Paginator
 */
class ScoresAnswersController extends AppController {

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
		$this->ScoresAnswer->recursive = 0;
		$this->set('scoresAnswers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ScoresAnswer->exists($id)) {
			throw new NotFoundException(__('Invalid scores answer'));
		}
		$options = array('conditions' => array('ScoresAnswer.' . $this->ScoresAnswer->primaryKey => $id));
		$this->set('scoresAnswer', $this->ScoresAnswer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ScoresAnswer->create();
			if ($this->ScoresAnswer->save($this->request->data)) {
				$this->Session->setFlash(__('The scores answer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The scores answer could not be saved. Please, try again.'));
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
		if (!$this->ScoresAnswer->exists($id)) {
			throw new NotFoundException(__('Invalid scores answer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ScoresAnswer->save($this->request->data)) {
				$this->Session->setFlash(__('The scores answer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The scores answer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ScoresAnswer.' . $this->ScoresAnswer->primaryKey => $id));
			$this->request->data = $this->ScoresAnswer->find('first', $options);
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
		$this->ScoresAnswer->id = $id;
		if (!$this->ScoresAnswer->exists()) {
			throw new NotFoundException(__('Invalid scores answer'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ScoresAnswer->delete()) {
			$this->Session->setFlash(__('The scores answer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The scores answer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
