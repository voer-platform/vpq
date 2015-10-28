<?php
App::uses('AppController', 'Controller');
/**
 * Questions Controller
 *
 * @property Question $Question
 * @property PaginatorComponent $Paginator
 */
class ClassifyQuestionController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public $helpers = array('Pls');
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$conditions = array();
		
		$user = $this->Auth->user();
		if(isset($this->request->query['search']) && $this->request->query['search']!='')
		{

			$subject = $this->request->query['subject'];
			if($subject)
				$conditions['subject_id'] = $subject;
			$this->set('csubject', $subject);
			
			$grade = $this->request->query['grade'];
			if($grade)
				$conditions['grade_id'] = $grade;
			$this->set('cgrade', $grade);
			
			// $category = $this->request->query['category'];
			// if($category){
				// $conditions['categories.id'] = $category;
				
				// Get current subcategories list
				// $this->loadModel('Subcategory');
				// $subcategories = $this->Subcategory->find('all', array(
					// 'recursive' => -1,
					// 'conditions' => array(
						// 'category_id = ' => $category,
						// ),
				// ));
				// $this->set('cSubcategories', $subcategories);
			// }	
			// $this->set('ccategory', $category);
			
			//Get current categories list
			// if($grade || $subject){
				// $catConditions = array();
				// if($grade)	$catConditions['Category.grade_id = '] = $grade;
				// if($subject)	$catConditions['Category.subject_id = '] = $subject;
				// $this->loadModel('Category');
				// $categories = $this->Category->find('all', array(
					// 'recursive' => 1,
					// 'conditions' => $catConditions,
					// 'fields' => array('Category.id', 'Category.name')
				// ));
				// $this->set('cCategories', $categories);
			// }
			
			// $subcategory = $this->request->query['subcategory'];
			// if($subcategory)
				// $conditions['subcategories.id'] = $subcategory;
			// $this->set('csubcategory', $subcategory);
			
		}
		
		$this->loadModel('ImportQuestion');
		$this->loadModel('ClassifyQuestion');

		if ($this->request->is('post')) {
		
			$questionId = $this->request->data['sort_question'];
			$subcategoryId = $this->request->data['sort_subcategory'];
			if ($questionId && $subcategoryId) {
			
				$hasQuestion = $this->ClassifyQuestion->find('first', array('conditions' => array('iquestion_id' => $questionId, 'user_id' => $user['id'])));
			
				if (!$hasQuestion) {
			
					$this->ClassifyQuestion->create();
					$this->ClassifyQuestion->save(array('iquestion_id' => $questionId, 'user_id' => $user['id'], 'subcategories_id' => $subcategoryId));
					
					$this->set('message', 'Phân loại của bạn đã được gửi, hãy tiếp tục với câu hỏi bên dưới nhé! Cảm ơn bạn nhiều ^^!');
					
				}
				
			}
		}
		
		$totalQuestionClassified = $this->ClassifyQuestion->find('count', array('conditions' => array('user_id' => $user['id'])));
		$this->set('questionCount', $totalQuestionClassified);
		
		$db = $this->ClassifyQuestion->getDataSource();
		$subQuery = $db->buildStatement(
			array(
				'fields'     => array('SortingQuestion.iquestion_id'),
				'table'      => $db->fullTableName($this->ClassifyQuestion),
				'alias'      => 'SortingQuestion',
				'conditions' => array('SortingQuestion.user_id' => $user['id'])
			),
			$this->ClassifyQuestion
		);
		$subQuery = ' ImportQuestion.id NOT IN (' . $subQuery . ') ';
		$subQueryExpression = $db->expression($subQuery);
		$conditions[] = $subQueryExpression;
		
		$this->paginate = array(
							'conditions'=>$conditions
						);
		
		$this->ImportQuestion->recursive = 0;
		$this->set('questions', $this->Paginator->paginate('ImportQuestion'));
		
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
	    	if( in_array( $this->request->action, array('index'))){
	    		return true;
	    	}
	    }

	    return parent::isAuthorized($user);
	}	
	
}