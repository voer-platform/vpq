<?php
App::uses('AppController', 'Controller');
/**
 * StaticPages Controller
 *
 * @property StaticPage $StaticPage
 * @property PaginatorComponent $Paginator
 */
class StaticPagesController extends AppController {

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
		$this->StaticPage->recursive = 0;
		$this->set('staticPages', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->StaticPage->exists($id)) {
			throw new NotFoundException(__('Invalid static page'));
		}
		$options = array('conditions' => array('StaticPage.' . $this->StaticPage->primaryKey => $id));
		$this->set('staticPage', $this->StaticPage->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->StaticPage->create();
			if ($this->StaticPage->save($this->request->data)) {
				$this->Session->setFlash(__('The static page has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The static page could not be saved. Please, try again.'));
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
		if (!$this->StaticPage->exists($id)) {
			throw new NotFoundException(__('Invalid static page'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->StaticPage->save($this->request->data)) {
				$this->Session->setFlash(__('The static page has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The static page could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('StaticPage.' . $this->StaticPage->primaryKey => $id));
			$this->request->data = $this->StaticPage->find('first', $options);
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
		$this->StaticPage->id = $id;
		if (!$this->StaticPage->exists()) {
			throw new NotFoundException(__('Invalid static page'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->StaticPage->delete()) {
			$this->Session->setFlash(__('The static page has been deleted.'));
		} else {
			$this->Session->setFlash(__('The static page could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
