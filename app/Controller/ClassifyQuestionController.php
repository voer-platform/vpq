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
		$this->set('title_for_layout' ,'Phân loại câu hỏi');
		$user = $this->Auth->user();
		if(isset($this->request->query['search']) && $this->request->query['search']!='')
		{

			$subject = $this->request->query['subject'];
			if ($subject) {
				$this->loadModel('Subject');
				$conditions['subject_id'] = $subject;
				$subj = $this->Subject->find('first', array('conditions' => array('id' => $subject)));
				$this->set('subject_name', $subj['Subject']['name']);
			}	
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
		$this->loadModel('Question');
		$this->loadModel('ImportQuestion');
		$this->loadModel('ClassifyQuestion');
		$this->loadModel('Answer');
		$this->loadModel('QuestionsSubcategory');

		if ($this->request->is('post')) {
		
			$questionId = $this->request->data['sort_question'];
			$subcategoryId = $this->request->data['sort_subcategory'];
			if ($questionId && $subcategoryId) {
			
				$hasQuestion = $this->ClassifyQuestion->find('first', array('conditions' => array('iquestion_id' => $questionId, 'user_id' => $user['id'])));
			
				if (!$hasQuestion) {
			
					$this->ClassifyQuestion->create();
					$this->ClassifyQuestion->save(array('iquestion_id' => $questionId, 'user_id' => $user['id'], 'subcategories_id' => $subcategoryId));
					$dataiquestion = $this->ClassifyQuestion->find('all',array('conditions' => array('iquestion_id' => $questionId)));
					$n=0;
					$statistical = array();
					foreach($dataiquestion as $key=>$value)
					{
						$n = $n + $value['ClassifyQuestion']['role'];
						if(array_key_exists($value['ClassifyQuestion']['subcategories_id'],$statistical))
						{
							$statistical[$value['ClassifyQuestion']['subcategories_id']] = $statistical[$value['ClassifyQuestion']['subcategories_id']] + $value['ClassifyQuestion']['role'];
						}else{
							$statistical[$value['ClassifyQuestion']['subcategories_id']] = $value['ClassifyQuestion']['role'];
						}
					}
					
					$t=0;					
					foreach($statistical as $key=>$value)
					{
						if($value>$t)
						{
							$t=$value;
							$correct_subcatergory=$key;
						}
					}

					$p=round($t/$n,2)*100;					
					
					$this->ImportQuestion->id = $questionId;
								
					$this->ImportQuestion->save(
											array(
												'correct_percent' => $p,
												'number'		  => $n,
											)
					);
					
					if($n>=5)
					{
						$question = $this->Question->find('all',array('conditions' => array('iquestion_id' => $questionId)));				if($p>=80)
						{
							if($question)
							{
								$this->Question->id = $question[0]['Question']['id'];
								$this->Question->save(
												array(
													'status' => 0,
												)
								);
							}else{	
								$data_question = $this->ImportQuestion->find('all',array('conditions' => array('id' => $questionId)));							
								$this->Question->begin();
								$error = false;
								$this->Question->create();
								if($this->Question->save(
														array(
															'content'	=>$data_question[0]['ImportQuestion']['question'],
															'difficulty'=>0,
															'solution'	=>$data_question[0]['ImportQuestion']['solution'],
															'count'		=>0,
															'time'		=>0,
															'report'	=>0,
															'wrong'		=>0,
															'status'	=>0,
															'iquestion_id'	=> $data_question[0]['ImportQuestion']['id'],
														)									
								)){
									$insert_id=$this->Question->getLastInsertId();
									$this->QuestionsSubcategory->create();
									if(!$this->QuestionsSubcategory->save(
															array(
																'question_id'=>$insert_id,
																'subcategory_id'=>$correct_subcatergory,
																'subcategory1_id'=>0,
																'persion1_id'=>null,
																'subcategory2_id'=>0,
																'persion2_id_id'=>null,
															)
									)){
										$error = true; 
									}
									$content=array(
												'0'	=> $data_question[0]['ImportQuestion']['answer_a'],
												'1'	=> $data_question[0]['ImportQuestion']['answer_b'],
												'2'	=> $data_question[0]['ImportQuestion']['answer_c'],
												'3'	=> $data_question[0]['ImportQuestion']['answer_d'],
												'4'	=> $data_question[0]['ImportQuestion']['answer_e'],
									);
									for($i=0;$i<=4;$i++)
									{
										$this->Answer->create();
										if($i==$data_question[0]['ImportQuestion']['answer_correct']){
											if(!$this->Answer->save(
															array(
																'question_id'	=>	$insert_id,
																'order'			=>	$i,
																'content'		=>  $content[$i],
																'correctness'	=>	1,
															)
											)){
												$error	= true;
											}
										}else{
											if(!$this->Answer->save(
															array(
																'question_id'	=>	$insert_id,
																'order'			=>	$i,
																'content'		=>  $content[$i],
																'correctness'	=> 	0,
															)
											));
										}
									}
								};
								if($error){
									$this->Question->rollback();
								}
								else
								{							
									$this->Question->commit();
									$this->set('message', 'Phân loại của bạn đã được ghi nhận, hãy tiếp tục với câu hỏi bên dưới nhé! Cảm ơn bạn nhiều ^^!');
								}
							}
						}else{
							if($question)
							{
								$this->Question->id = $question[0]['Question']['id'];
								$this->Question->save(
												array(
													'status' => 1,
												)
								);
								$this->set('message', 'Phân loại của bạn đã được ghi nhận, hãy tiếp tục với câu hỏi bên dưới nhé! Cảm ơn bạn nhiều ^^!');
							}
						}
					}else{
						$this->set('message', 'Phân loại của bạn đã được ghi nhận, hãy tiếp tục với câu hỏi bên dưới nhé! Cảm ơn bạn nhiều ^^!');
					}					
					
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