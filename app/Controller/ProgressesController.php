<?php
App::uses('AppController', 'Controller');
/**
 * Progresses Controller
 *
 * @property Progress $Progress
 * @property PaginatorComponent $Paginator
 */
class ProgressesController extends AppController {

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
		$this->Progress->recursive = 0;
		$this->set('progresses', $this->Paginator->paginate());
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
	public function view($p_id = null, $s_id = null) {
		if (!$this->Progress->exists($id)) {
			throw new NotFoundException(__('Invalid progress'));
		}
		$options = array('conditions' => array('Progress.person_id' => $p_id, 'Progress.subcategory_id' => $s_id));
		$this->set('progress', $this->Progress->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Progress->create();
			if ($this->Progress->save($this->request->data)) {
				$this->Session->setFlash(__('The progress has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The progress could not be saved. Please, try again.'));
			}
		}
		$people = $this->Progress->Person->find('list');
		$subCategories = $this->Progress->SubCategory->find('list');
		$this->set(compact('people', 'subCategories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Progress->exists($id)) {
			throw new NotFoundException(__('Invalid progress'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Progress->save($this->request->data)) {
				$this->Session->setFlash(__('The progress has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The progress could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Progress.' . $this->Progress->primaryKey => $id));
			$this->request->data = $this->Progress->find('first', $options);
		}
		$people = $this->Progress->Person->find('list');
		$subCategories = $this->Progress->SubCategory->find('list');
		$this->set(compact('people', 'subCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Progress->id = $id;
		if (!$this->Progress->exists()) {
			throw new NotFoundException(__('Invalid progress'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Progress->delete()) {
			$this->Session->setFlash(__('The progress has been deleted.'));
		} else {
			$this->Session->setFlash(__('The progress could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
/**
 * performance details
 * ajax call
 */
    public function performanceDetails(){
        $this->layout = 'ajax';
        $this->autoLayout = false;
        $this->autoRender = false;
        
        if( $this->request->is('POST')){
            if(isset($_POST['subject'])){
                $this->loadModel('Score');
                $user = $this->Session->read('Auth.User');
                $result = $this->Score->getScoresForChart($user['id'], $this->request->data('subject'));
                echo $result;
            }
        }
        else {
            $this->redirect('/');
        }
    }

}
