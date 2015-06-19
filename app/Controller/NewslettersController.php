<?php
App::uses('AppController', 'Controller');
/**
 * Newsletters Controller
 *
 * @property Newsletter $Newsletter
 * @property PaginatorComponent $Paginator
 */
class NewslettersController extends AppController {

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
		$this->Newsletter->recursive = 0;
		$this->set('newsletters', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Newsletter->exists($id)) {
			throw new NotFoundException(__('Invalid newsletter'));
		}
		$options = array('conditions' => array('Newsletter.' . $this->Newsletter->primaryKey => $id));
		$this->set('newsletter', $this->Newsletter->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Newsletter->create();
			if ($this->Newsletter->save($this->request->data)) {
				$this->Session->setFlash(__('The newsletter has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newsletter could not be saved. Please, try again.'));
			}
		}
		$newsletterCategories = $this->Newsletter->NewsletterCategory->find('list');
		$this->set(compact('newsletterCategories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Newsletter->exists($id)) {
			throw new NotFoundException(__('Invalid newsletter'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Newsletter->save($this->request->data)) {
				$this->Session->setFlash(__('The newsletter has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newsletter could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Newsletter.' . $this->Newsletter->primaryKey => $id));
			$this->request->data = $this->Newsletter->find('first', $options);
		}
		$newsletterCategories = $this->Newsletter->NewsletterCategory->find('list');
		$this->set(compact('newsletterCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Newsletter->id = $id;
		if (!$this->Newsletter->exists()) {
			throw new NotFoundException(__('Invalid newsletter'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Newsletter->delete()) {
			$this->Session->setFlash(__('The newsletter has been deleted.'));
		} else {
			$this->Session->setFlash(__('The newsletter could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
