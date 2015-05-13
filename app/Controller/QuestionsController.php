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
			$this->set('ckeyword', $keyword);

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
				
				//Get current subcategories list
				$this->loadModel('Subcategory');
				$subcategories = $this->Subcategory->find('all', array(
					'recursive' => -1,
					'conditions' => array(
						'category_id = ' => $category,
						),
				));
				$this->set('cSubcategories', $subcategories);
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
			
			$subcategory = $this->request->query['subcategory'];
			if($subcategory)
				$conditions['subcategories.id'] = $subcategory;
			$this->set('csubcategory', $subcategory);
			
		}
		$this->Question->virtualFields['_difficulty'] = 'ROUND((Question.wrong/Question.count)*10, 0)';
		$this->Question->virtualFields['_averange_time'] = 'ROUND(Question.time/Question.count, 2)';
		$this->paginate = array(
							'escape'=>false,
							'fields'=>array('Question.*', '_difficulty', '_averange_time'), 
							'joins'	=>	array(
											array(
												'table'	=>	'questions_subcategories',
												'type'	=>	'INNER',
												'conditions'	=>	array('Question.id = questions_subcategories.question_id')
											),
											array(
												'table'	=>	'subcategories',
												'type'	=>	'INNER',
												'conditions'	=>	array('subcategories.id = questions_subcategories.subcategory_id')
											),
											array(
												'table'	=>	'categories',
												'type'	=>	'INNER',
												'conditions'	=>	array('categories.id = subcategories.category_id')
											)
										),
							'conditions'=>$conditions
						);
		$this->Question->recursive = 0;
		$this->set('questions', $this->Paginator->paginate());
		
		$this->loadModel('Subject');
		$subjects = $this->Subject->find('list');
		$this->set('subjects', $subjects);
		
		$this->loadModel('Grade');
		$grades = $this->Grade->find('list');
		$this->set('grades', $grades);
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