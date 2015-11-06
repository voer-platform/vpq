<?php
App::uses('AppController', 'Controller');
/**
 * Subcategories Controller
 *
 * @property Subcategory $Subcategory
 * @property PaginatorComponent $Paginator
 */
class SubcategoriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/*
 * beforeFilter
 */
    public function beforeFilter(){
        parent::beforeFilter();
        // Allow users to
        $this->Auth->allow('viewScoresSubcategory');

        Security::setHash('md5');
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
 * index method
 *
 * @return void
 */
	public function index() {
		$conditions = array();
		if(isset($this->request->query['search']) && $this->request->query['search']!='')
		{

			$subject = $this->request->query['subject'];
			if($subject)
				$conditions['categories.subject_id'] = $subject;
			$this->set('csubject', $subject);
			
			$grade = $this->request->query['grade'];
			if($grade)
				$conditions['categories.grade_id'] = $grade;
			$this->set('cgrade', $grade);
			
			$category = $this->request->query['category'];
			if($category){
				$conditions['categories.id'] = $category;
			}	
			$this->set('ccategory', $category);
			
			//Get current categories list
			if($grade || $subject){
				$catConditions = array();
				if($grade)	$catConditions['Category.grade_id = '] = $grade;
				if($subject)	$catConditions['Category.subject_id = '] = $subject;
				$this->loadModel('Category');
				$categories = $this->Category->find('all', array(
					'recursive' => 1,
					'conditions' => $catConditions,
					'fields' => array('Category.id', 'Category.name')
				));
				$this->set('cCategories', $categories);
			}
			
		}
		
		$this->Subcategory->virtualFields['number_question'] = 'SELECT COUNT(*) FROM questions_subcategories WHERE subcategory_id = Subcategory.id';
		$this->paginate = array(
							'escape'=>false,
							'fields'=>array('Subcategory.*', 'number_question'), 
							'joins'	=>	array(
											array(
												'table'	=>	'categories',
												'type'	=>	'INNER',
												'conditions'	=>	array('categories.id = Subcategory.category_id')
											)
										),
							'conditions'=>$conditions,
							// 'group'	=>	array('Question.id')
						);
		$this->Subcategory->recursive = 0;
		$this->set('subcategories', $this->Paginator->paginate());
		
		$this->loadModel('Subject');
		$subjects = $this->Subject->find('list');
		$this->set('subjects', $subjects);
		
		$this->loadModel('Grade');
		$grades = $this->Grade->find('list');
		$this->set('grades', $grades);
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
		$this->set('subcategory', $this->Subcategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Subcategory->create();
			if ($this->Subcategory->save($this->request->data)) {
				$this->Session->setFlash(__('The subcategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subcategory could not be saved. Please, try again.'));
			}
		}
		$categories = $this->Subcategory->Category->find('list');
		// $questions = $this->Subcategory->Question->find('list');
		// $this->set(compact('grades', 'categories', 'questions'));
		$this->set(compact('categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Subcategory->exists($id)) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Subcategory->save($this->request->data)) {
				$this->Session->setFlash(__('The subcategory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subcategory could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Subcategory.' . $this->Subcategory->primaryKey => $id));
			$this->request->data = $this->Subcategory->find('first', $options);
		}
		$grades = $this->Subcategory->Grade->find('list');
		$categories = $this->Subcategory->Category->find('list');
		$questions = $this->Subcategory->Question->find('list');
		$this->set(compact('grades', 'categories', 'questions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Subcategory->id = $id;
		if (!$this->Subcategory->exists()) {
			throw new NotFoundException(__('Invalid subcategory'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Subcategory->delete()) {
			$this->Session->setFlash(__('The subcategory has been deleted.'));
		} else {
			$this->Session->setFlash(__('The subcategory could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * view scores on one subcategories
 *
 * @param string $id
 * @return void
 */
	public function viewScoresSubcategory($id) {
		$this->set('title_for_layout',__("History"));

		$this->loadModel('Score');
		$result = $this->Score->getScoresForSubcategory($this->Session->read('Auth.User')['id'], $id);
		$this->set('scores', $result);
		$this->set('subcategory_id', $id);
	}
	
	public function get_subcategories($id=null)
	{
		$this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		
		$subcategories = $this->Subcategory->find('all', array(
                'recursive' => -1,
                'conditions' => array(
                    'category_id = ' => $id,
                    ),
            ));
		
		$this->header('Content-Type: application/json');
        echo json_encode($subcategories);
        return;
	}

}
