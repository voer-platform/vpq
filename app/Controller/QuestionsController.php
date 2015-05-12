<?php
App::uses('AppController', 'Controller');
/**
 * Questions Controller
 *
 * @property Question $Question
 * @property PaginatorComponent $Paginator
 */
class QuestionsController extends AppController {

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
		$conditions = array();
		if(isset($this->request->query['search']) && $this->request->query['search']!='')
		{
			$keyword = $this->request->query['keyword'];
			if($keyword)
				$conditions['Question.content LIKE'] = "%$keyword%";
		}
		$this->Question->virtualFields['_difficulty'] = 'ROUND((Question.wrong/Question.count)*10, 0)';
		$this->Question->virtualFields['_averange_time'] = 'ROUND(Question.time/Question.count, 2)';
		$this->paginate = array(
							'escape'=>false,
							'fields'=>array('Question.*', '_difficulty', '_averange_time'), 
							'conditions'=>$conditions);
		$this->Question->recursive = 0;
		$this->set('questions', $this->Paginator->paginate());
		
		$this->loadModel('Subject');
		$subjects = $this->Subject->find('list');
		$this->set('subjects', $subjects);
	}

/*
 * authorization
 * 
 */
	public function isAuthorized($user) {
	    // only editor can can do 
	    if (isset($user['role']) && $user['role'] === 'editor' ){
	    	return true;
	    }
	    else if (isset($user['role']) && $user['role'] === 'user' ){
	    	if( in_array( $this->request->action, array('ajaxCover'))){
	    		return true;
	    	}
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
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__('Invalid question'));
		}
		$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
		$this->set('question', $this->Question->find('first', $options));

	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Question->create();
			if ($this->Question->save($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		}
		$subcategories = $this->Question->Subcategory->find('list');
		$tests = $this->Question->Test->find('list');
		$this->set(compact('subcategories', 'tests'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__('Invalid question'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Question->save($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
			$this->request->data = $this->Question->find('first', $options);
		}
		$subcategories = $this->Question->Subcategory->find('list');
		$tests = $this->Question->Test->find('list');
		$this->set(compact('subcategories', 'tests'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Invalid question'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Question->delete()) {
			$this->Session->setFlash(__('The question has been deleted.'));
		} else {
			$this->Session->setFlash(__('The question could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}