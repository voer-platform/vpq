<?php 
App::uses('Controller', 'Controller');
/**
 * Admin Controller
 *
 * @property Admin $Admin
 * @property PaginatorComponent $Paginator
 */
class PartnerController extends Controller {
	
	// do not use model
	var $uses = false;

	// public $helpers = array('TinymceElfinder.TinymceElfinder');
	// public $components = array('Paginator','TinymceElfinder.TinymceElfinder');
	public $helpers = array();
	public $components = array('Paginator','Session','Cookie');

/**
 * paginate
 *
 */
 	public $paginate = array(
		'Question' => array(
	        'limit' => 10, 
	        'recursive' => 2, 
	        'model' => 'Question', 
	        // 'joins' => aray(),n
	        'order' => array('Question.id' => 'ASC')
    		),
	);	

/*
 * authorization
 * 
 */
	public function isAuthorized($user) {
	    // only admin can do 
	    if (isset($user['role'])  && $user['role'] === 'admin'){
	    	if( in_array( $this->request->action, array('import_excel', 'check_question', 'view_question', 'changePassword','getBook','getCategory','remake','get_subcategories','byGrade','bySubject','login','logout','addquestion','insertQuestions','report_admin','delete'))){
                return true;
            }
	    }
		if (isset($user['role']) && $user['role'] === 'editor') {
			if( in_array( $this->request->action, array('import_excel','view_question', 'changePassword','getBook','getCategory','remake','get_subcategories','byGrade','bySubject','login','logout','addquestion','insertQuestions','delete'))){
                return true;
            }
		}
		if (isset($user['role']) && $user['role'] === 'tester') {
			if( in_array( $this->request->action, array('check_question', 'view_question', 'changePassword','getBook','getCategory','get_subcategories','byGrade','bySubject','login','logout','delete','accept'))){
                return true;
            }
		}

	    return parent::isAuthorized($user);
	}
/*
* beforeFilter
*/
    public function beforeFilter(){
        parent::beforeFilter();
    }


/**
 * index
 *
 * @return void
 */
	public function index(){
		$user = array();
        $this->set('user', $user);
		$this->layout ='excel';
		$this->loadModel('Person');
		if($this->request->is('post')){			
			if($this->request->data('login')){
				$this->Session->destroy();
				$user=$this->request->data('user');
				$pass=$this->request->data('pass');
				$user=$this->Person->find('all',array(
											'recursive' => -1,
											'conditions' => array('username'=>$user),
									)
				);
				if($user!=null){
					if($user[0]['Person']['password']==md5($pass)){
						$this->Session->write('user',$user[0]['Person']);
						//$this->Auth->login($user[0]['Person']);
						$this->Cookie->delete('remember');
						//$this->Cookie->write('reaccess', $encrypted_access_string, true, 31536000);						
						if($user[0]['Person']['role']=='tester'){
							$this->redirect(array('controller' =>'partner', 'action' => 'check_question'));
						}else{
							$this->redirect(array('controller' =>'partner', 'action' => 'list_questions'));
						}
					}else{
						$this->Session->setFlash(__('Mật khẩu không đúng.'));
					}
				}else{
					
				}
			}
		}
	}

/**
 * insert questions
 *
 * @return void
 */
	public function insertQuestions(){
		require_once(APP. 'Vendor'. DS .'PHPExcel.php');
		require_once(APP. 'Vendor'. DS . 'PHPExcel'. DS. 'IOFactory.php');
		$user = $this->Session->read('user');
		$this->set('user', $user);
		if(!isset($user)){
			$this->redirect(array('controller' =>'partner', 'action' => 'login'));
		};
		$this->layout ='excel';
		$this->loadModel('ImportQuestion');
		$this->loadModel('Question');
		$this->loadModel('Grade');
		$this->loadModel('Subject');
		$options = array(
					'recursive' => -1,
					);
		$this->set('grade',$this->Grade->find('all',$options));
		$this->set('subject',$this->Subject->find('all',$options));
		$this->set(compact('subcategories', 'tests'));
	}
	
	public function addquestion(){
		$user = $this->Session->read('user');
		$this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$question=$this->request->data;
		$correct=explode(' ',trim($question['correct']));
		$this->loadModel('Question');
		$this->loadModel('QuestionsSubcategory');
		$this->loadModel('Answer');
		$this->loadModel('ImportQuestion');
		$this->loadModel('ClassifyQuestion');
		
		$this->ImportQuestion->save(
								array(
									'user'	   =>$user['id'],
									'subject_id'=>trim($question['subject']),
									'grade_id'=>trim($question['grade']),
									'categories_id'=>trim($question['categories']),
									'subcategory_id' => trim($question['subcategories']),				
									'question'	=>trim($question['question']),
									'solution'	=>trim($question['solution']),
									'answer_a'	=>trim($question[0]),
									'answer_b'	=>trim($question[1]),
									'answer_c'	=>trim($question[2]),
									'answer_d'	=>trim($question[3]),
									'answer_e'	=>trim($question[4]),
									'answer_correct'=>trim($question['correct']),
									'check_question'=>'0',
									'date'=>date('d/m/Y'),
								)
							);
		$iquestion_id = $this->ImportQuestion->getLastInsertId();
		
		if($question['subcategories']!='')
		{
			$this->ClassifyQuestion->save(
								array(
									'iquestion_id'	=>	$iquestion_id,
									'user_id'	  	=>	$user['id'],
									'subcategories_id' =>	trim($question['subcategories']),
									'role'			=> 5
								)
			);
			
			$this->ImportQuestion->id = $iquestion_id;
			
			$this->ImportQuestion->save(
									array(
										'correct_percent' => 100,
										'number'		  => 5,
									)
			);
		}
				
		
	}
	
	public function list_questions(){
		require_once(APP. 'Vendor'. DS .'PHPExcel.php');
		require_once(APP. 'Vendor'. DS . 'PHPExcel'. DS. 'IOFactory.php');
		$user = $this->Session->read('user');
		$this->set('user', $user);
		if(!isset($user)){
			$this->redirect(array('controller' =>'partner', 'action' => 'login'));
		}else{		
			$this->layout ='excel';
			$this->loadModel('Person');
			$this->loadModel('ImportQuestion');
			$this->loadModel('QuestionsSubcategory');
			$this->loadModel('Subcategory');
			$this->loadModel('Category');
			$this->loadModel('Subject');
			$this->loadModel('File');
			$person=$this->Person->find('all',
								array(
									'recursive' => -1,
									'conditions' => array('id'=>$user['id'])
								)
			);
			if($person[0]['Person']['accept']==1)
			{
				$this->set('accept','1');
				$this->set('number',$person[0]['Person']['number']);
			}else{
				$this->set('accept','0');
				$this->set('number',$user['number']);
			}
			if(isset($this->request->query['delete'])){
				$this->ImportQuestion->id = $this->request->query['delete'];
				if ($this->ImportQuestion->delete()) {
					$this->Session->setFlash(__('Xóa thành công.'));
				} else {
					$this->Session->setFlash(__('Xóa thất bại.'));
				}
			}
			$options=array();
			if($user['role']!='admin'){
				$options['user']=$user['id'];
			}
			$this->set('sub_name','chọn tất cả');
			$this->set('book_name','chọn tất cả');
			if($this->request->is('post')){
				if($this->request->data('search')){
					$subject_id=$this->request->data('subject');
					$book_id=$this->request->data('book');
					$category_id=$this->request->data('categories');
					$subcategory_id=$this->request->data('subcategories');
					$state=$this->request->data('state');
					if($subject_id!=''){
						$options['subject_id']=$subject_id;
						$this->loadModel('Book');
						$options3 = array(
						'recursive' => -1,
						'conditions' => array('subject_id'=>$subject_id)
						);
						$book=$this->Book->find('all',$options3);
						$this->set('book',$book);
						$sub_id=$this->Subject->find('all',array(
												'recursive' => -1,
												'conditions' => array('id'=>$subject_id)
						));
						$this->set('sub_name',$sub_id[0]['Subject']['name']);
					}
					if($book_id!=''){
						$options['book_id']=$book_id;
						$this->loadModel('Book');
						$this->loadModel('Category');
						$options4 = array(
									'recursive' => -1,
									'conditions' => array('id'=>$book_id)
									);
						$book=$this->Book->find('all',$options4);
						$this->set('book_name',$book[0]['Book']['name']);					
						$options4 = array(
									'recursive' => -1,
									'conditions' => array(	
															'subject_id'=>$book[0]['Book']['subject_id'],
															'grade_id'=>$book[0]['Book']['grade_id']
														)
									);
						$categories=$this->Category->find('all',$options4);
						$this->set('categories',$categories);
					}
					if($state!=''){
						$options['check_question']=$state;
						$this->set('state',$state);
					}
					$this->set('subject_id',$subject_id);
					$this->set('book_id',$book_id);
				}	
			}else{
				$this->set('subject_id','');
				$this->set('book_id','');
				$this->set('category_id','');
				$this->set('subcategory_id','');

			}
			$import_question = $this->ImportQuestion->find('all',array(
														'recursive' => -1,
														'conditions' => $options,
														'order' => array('id' => 'desc')
													));
			$this->set('import_question',$import_question);
			$count=$this->ImportQuestion->find('count',
												array(
														'recursive' => -1,
														'conditions' => $options
													)
												);
			$this->set('count',$count);
			
			/*$this->Paginator->setting = array(
				'limit'	=> 10,
				'conditions'=>$options
			);*/
			$option2=array(
						'recursive' => -1,
					);
			$this->set('subject',$this->Subject->find('all',$option2));
		}
	}		
	
	public function view_question($id){
		$user = $this->Session->read('user');
		$this->set('user', $user);
		if(!isset($user)){
			$this->redirect(array('controller' =>'partner', 'action' => 'login'));
		};
		$this->layout ='excel';
		$this->loadModel('ImportQuestion');
		$this->loadModel('Question');
		$this->loadModel('QuestionsSubcategory');
		$this->loadModel('Answer');
		$this->loadModel('Category');
		$this->loadModel('Subcategory');
		$this->loadModel('Subject');
		$this->loadModel('ClassifyQuestion');
		if($this->request->data('update')){
			$data=$this->request->data;
			$this->ImportQuestion->id=$data['id'];
			if($this->ImportQuestion->save(
												array(
													'question'=>trim($data['content_question']),
													'solution'=>trim($data['text_solution']),
													'answer_a'  =>trim($data['text_a']),
													'answer_b'  =>trim($data['text_b']),
													'answer_c'  =>trim($data['text_c']),
													'answer_d'  =>trim($data['text_d']),
													'answer_e'  =>trim($data['text_e']),
													'answer_correct'  =>trim($data['answer_correct']),
												)
			)){
				$this->Session->setFlash(__('Cập nhật thành công'));
			}else{
				$this->Session->setFlash(__('Cập nhật thất bại'));
			}
		}
		$options = array(
					'recursive' => -1,
					'conditions' => array('ImportQuestion.id'=>$id)
					);
		$data_question=$this->ImportQuestion->find('all',$options);
		$subject=$this->Subject->find('all',array(
			'recursive' => -1,
			'conditions' => array(			
								'id' => $data_question[0]['ImportQuestion']['subject_id'],
							),
		));
		$this->set('subject',$subject);
		$question=explode(' ',$data_question[0]['ImportQuestion']['question']);
		$string='';	
		if(count($question)>10){
			for($i=0;$i<10;$i++){
				if($string==''){
					$string=$question[$i];
				}else{
					$string=$string.' '.$question[$i];
				}
			}
		}else{
			$string=$data_question[0]['ImportQuestion']['question'];
		}
		//$same_question=$this->Question->query("SELECT * FROM questions WHERE content LIKE '$string%'");
		$this->Paginator->settings = array(
			'fields'	=> array(
									'Question.id',
									'Question.content',
									'ans.content'
								),
			'limit' => 5,
			'recursive' => -1,
			'joins'	=>	array(
							array(
								'table'	=>	'answers',
								'alias'	=>	'ans',
								'type'	=>	'INNER',
								'conditions'	=>	array('ans.question_id = Question.id')
							)
						),
			'conditions'=>array(
							'Question.content LIKE'=>$string.'%',
			)
		);
		$same_question = $this->Paginator->paginate('Question');
		$same_question2=array();
		foreach($same_question as $value)
		{
			$same_question2[$value['Question']['id']]['question'] = $value['Question']['content'];
			$same_question2[$value['Question']['id']]['answers'][] = $value['ans']['content'];
			
		}
		$this->set('count_same',count($same_question2));
		$this->set('same_question2',$same_question2);
		//pr($same_question);
		$correct=explode(' ',trim($data_question[0]['ImportQuestion']['answer_correct']));
		foreach($correct as $correct){
			$answer_correct[$correct]='';
		}
		$this->set('cr',$correct);
		$this->set('correct',$answer_correct);
		$this->set('question',$data_question);
		$subcategory=$this->Subcategory->find('all',array(
													'recursive' => -1,
													'conditions' => array('id'=>$data_question[0]['ImportQuestion']['subcategory_id'])
		));
		$this->set('subcategory',$subcategory);
		
		if($this->request->data('ok')){
			if(isset($this->request->data['id'])){
				if($this->ImportQuestion->updateAll(
												array(
													'check_question'=>1,
												),
												array(
													'id'=>$this->request->data['id'],
												)
				)){
					if($data_question[0]['ImportQuestion']['subcategory_id']=='')
					{
						$this->redirect(array('controller' =>'partner', 'action' => 'list_questions'));
						$this->Session->setFlash(__('Xác nhận thành công'));
					}else{

						if($this->Question->saveAll(
												array(
													'content'	=>$data_question[0]['ImportQuestion']['question'],
													'difficulty'=>0,
													'solution'	=>$data_question[0]['ImportQuestion']['solution'],
													'count'		=>0,
													'time'		=>0,
													'report'	=>0,
													'wrong'		=>0,
													'status'	=>1,
													'iquestion_id'	=> $this->request->data['id'],
												)									
						)){
							$insert_id=$this->Question->getLastInsertId();
							if(!$this->QuestionsSubcategory->saveAll(
													array(
														'question_id'=>$insert_id,
														'subcategory_id'=>$data_question[0]['ImportQuestion']['subcategory_id'],
														'subcategory1_id'=>0,
														'persion1_id'=>null,
														'subcategory2_id'=>0,
														'persion2_id_id'=>null,
													)
							));
							
							$content=array(
										'0'	=> $data_question[0]['ImportQuestion']['answer_a'],
										'1'	=> $data_question[0]['ImportQuestion']['answer_b'],
										'2'	=> $data_question[0]['ImportQuestion']['answer_c'],
										'3'	=> $data_question[0]['ImportQuestion']['answer_d'],
										'4'	=> $data_question[0]['ImportQuestion']['answer_e'],
							);
							
							for($i=0;$i<=4;$i++)
							{
								if($i==$data_question[0]['ImportQuestion']['answer_correct']){
									if(!$this->Answer->saveAll(
													array(
														'question_id'	=>	$insert_id,
														'order'			=>	$i,
														'content'		=>  $content[$i],
														'correctness'	=>	1,
													)
									));
								}else{
									if(!$this->Answer->saveAll(
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
						echo $insert_id;
						$this->redirect(array('controller' =>'partner', 'action' => 'list_questions'));
						$this->Session->setFlash(__('Câu hỏi đã được xác nhận.'));
					}
				}else{
					$this->Session->setFlash(__('Duyệt thất bại'));
				}
			}
		}
		
		if($this->request->data('no2')){
			if(isset($this->request->data['id'])){
				$hasQuestion = $this->Question->find('all',array('conditions'=>array('iquestion_id'=>$this->request->data['id'])));
				if($hasQuestion){
					$this->Question->id = $hasQuestion[0]['Question']['id'];
					$this->Question->delete();					
				};
				if($this->ImportQuestion->updateAll(
												array(
													'check_question'=>2,
												),
												array(
													'id'=>$this->request->data['id'],
												)
				)){
					$this->redirect(array('controller' =>'partner', 'action' => 'list_questions'));
					$this->Session->setFlash(__('Hủy thành công'));
				}else{
					$this->Session->setFlash(__('Hủy thất bại'));
				}
			}
		}

	}	
	
	public function report_admin(){
		$user = $this->Session->read('user');
		$this->set('user', $user);
		if(!isset($user)){
			$this->redirect(array('controller' =>'partner', 'action' => 'login'));
		}else{
			$this->layout ='excel2';
			$this->loadModel('Person');
			$this->loadModel('ImportQuestion');
			if($this->request->is('post'))
			{
				$data=$this->request->data;
				foreach($data['socau'] as $key=>$value)
				{
					if($value!=0){
						$id_partner=$data['id_partner'][$key];
						$person=$this->Person->find('all',
																array(
																'recursive' => -1,
																'conditions' => array("id='$id_partner'")
																)
															);
						$amount=$person[0]['Person']['number']+$value;
						$this->Person->id=$id_partner;
						$this->Person->save(
												array(
													'number' => $amount,
													'accept' => 1
												)
						);
					}
				}
			}
			$option0 = array(
					'recursive' => -1,
					'conditions' => array("role='editor'")
					);
			$people_insert=$this->Person->find('all',$option0);
			foreach($people_insert as $key=>$value)
			{
					$id=$value['Person']['id'];					
					$option1 = array(
						'recursive' => -1,
						'conditions' => array("user='$id'")
					);
					$total=$this->ImportQuestion->find('count',$option1);
					$people_insert[$key]['Person']['total']=$total;
					$option2 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='3' AND user='$id'")
					);
					$math=$this->ImportQuestion->find('count',$option2);
					$people_insert[$key]['Person']['math']=$math;
					$option3 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='2' AND user='$id'")
					);
					$physical=$this->ImportQuestion->find('count',$option3);
					$people_insert[$key]['Person']['physical']=$physical;
					$option4 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='4' AND user='$id'")
					);
					$chemistry=$this->ImportQuestion->find('count',$option4);
					$people_insert[$key]['Person']['chemistry']=$chemistry;
					$option5 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='1' AND user='$id'")
					);
					$english=$this->ImportQuestion->find('count',$option5);
					$people_insert[$key]['Person']['english']=$english;
					$option6 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='8' AND user='$id'")
					);
					$biological=$this->ImportQuestion->find('count',$option6);
					$people_insert[$key]['Person']['biological']=$biological;
					$option7 = array(
						'recursive' => -1,
						'conditions' => array("user='$id' AND (check_question='1' OR check_question='3')")
					);
					$status=$this->ImportQuestion->find('count',$option7);
					$people_insert[$key]['Person']['status']=$status;
					$option8 = array(
						'recursive' => -1,
						'conditions' => array("user='$id' AND check_question='2'")
					);
					$delete=$this->ImportQuestion->find('count',$option8);
					$people_insert[$key]['Person']['delete']=$delete;
					$option9 = array(
						'recursive' => -1,
						'conditions' => array("user='$id' AND check_question='0'")
					);
					$wait=$this->ImportQuestion->find('count',$option9);
					$people_insert[$key]['Person']['wait']=$wait;
					$option10 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='3' AND solution!='' AND check_question='1' AND user='$id'")
					);
					$has_solution_math=$this->ImportQuestion->find('count',$option10);
					$people_insert[$key]['Person']['has_solution_math']=$has_solution_math;
					$option11 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='2' AND solution!='' AND check_question='1' AND user='$id'")
					);
					$has_solution_physical=$this->ImportQuestion->find('count',$option11);
					$people_insert[$key]['Person']['has_solution_physical']=$has_solution_physical;
					$option12 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='4' AND solution!='' AND check_question='1' AND user='$id'")
					);
					$has_solution_chemistry=$this->ImportQuestion->find('count',$option12);
					$people_insert[$key]['Person']['has_solution_chemistry']=$has_solution_chemistry;
					$option13 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='1' AND solution!='' AND check_question='1' AND user='$id'")
					);
					$has_solution_english=$this->ImportQuestion->find('count',$option13);
					$people_insert[$key]['Person']['has_solution_english']=$has_solution_english;
					$option14 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='8' AND solution!='' AND check_question='1' AND user='$id'")
					);
					$has_solution_biological=$this->ImportQuestion->find('count',$option14);
					$people_insert[$key]['Person']['has_solution_biological']=$has_solution_biological;
					$option15 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='3' AND solution='' AND check_question='1' AND user='$id'")
					);
					$check_math=$this->ImportQuestion->find('count',$option15);
					$people_insert[$key]['Person']['check_math']=$check_math;
					$option16 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='2' AND solution='' AND check_question='1' AND user='$id'")
					);
					$check_physical=$this->ImportQuestion->find('count',$option16);
					$people_insert[$key]['Person']['check_physical']=$check_physical;
					$option17 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='4' AND solution='' AND check_question='1' AND user='$id'")
					);
					$check_chemistry=$this->ImportQuestion->find('count',$option17);
					$people_insert[$key]['Person']['check_chemistry']=$check_chemistry;
					$option18 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='1' AND solution='' AND check_question='1' AND user='$id'")
					);
					$check_english=$this->ImportQuestion->find('count',$option18);
					$people_insert[$key]['Person']['check_english']=$check_english;
					$option19 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='8' AND solution='' AND check_question='1' AND user='$id'")
					);
					$check_biological=$this->ImportQuestion->find('count',$option19);
					$people_insert[$key]['Person']['check_biological']=$check_biological;
			};
			$this->set('people_insert',$people_insert);
			$option_total1 = array(
						'recursive' => -1,
					);
			$total=$this->ImportQuestion->find('count',$option_total1);
			$this->set('total',$total);
			$option_total2 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='3'")
					);
			$total_math=$this->ImportQuestion->find('count',$option_total2);
			$this->set('total_math',$total_math);
			$option_total3 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='2'")
					);
			$total_physical=$this->ImportQuestion->find('count',$option_total3);
			$this->set('total_physical',$total_physical);
			$option_total4 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='4'")
					);
			$total_chemistry=$this->ImportQuestion->find('count',$option_total4);
			$this->set('total_chemistry',$total_chemistry);
			$option_total5 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='1'")
					);
			$total_english=$this->ImportQuestion->find('count',$option_total5);
			$this->set('total_english',$total_english);
			$option_total6 = array(
						'recursive' => -1,
						'conditions' => array("subject_id='8'")
					);
			$total_biological=$this->ImportQuestion->find('count',$option_total6);
			$this->set('total_biological',$total_biological);
			$option_total7 = array(
						'recursive' => -1,
						'conditions' => array("check_question='2'")
					);
			$total_delete=$this->ImportQuestion->find('count',$option_total7);
			$this->set('total_delete',$total_delete);
			$option_total8 = array(
						'recursive' => -1,
						'conditions' => array("check_question='1' OR check_question='3'")
					);
			$total_status=$this->ImportQuestion->find('count',$option_total8);
			$this->set('total_status',$total_status);
		}		
	}
	
	public function accept($key)
	{
		$this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$this->loadModel('Person');
		$user = $this->Session->read('user');
		$this->Person->id = $user['id'];

		$this->Person->save(
						array(
							'accept' => $key,
						)
		);
	}
	
	public function delete(){
		$this->loadModel('ImportQuestion');
		$this->loadModel('Question');
		if($this->request->query['id']){
			$hasQuestion = $this->Question->find('all',array('conditions' => array('iquestion_id' => $this->request->query['id'])));
			if($hasQuestion){
				$this->Question->id = $hasQuestion[0]['Question']['id'];
				$this->Question->delete();
			};
			if($this->ImportQuestion->updateAll(
											array(
												'check_question'=>2,
											),
											array(
												'id'=>$this->request->query['id'],
											)
			)){
				$this->redirect(array('controller' =>'partner', 'action' => 'list_questions'));
				$this->Session->setFlash(__('Hủy thành công'));
			}else{
				$this->Session->setFlash(__('Hủy thất bại'));
			}
		}
	}
	
	public function getBook($subject_id){
		$this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$this->loadModel('Book');
		$options = array(
					'recursive' => -1,
					'conditions' => array('subject_id'=>$subject_id)
					);
		$book=$this->Book->find('all',$options);
		$this->header('Content-Type: application/json');
        echo json_encode($book);
		return;
	}
	
	public function getCategory($book_id){
		$this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$this->loadModel('Book');
		$this->loadModel('Category');
		$options = array(
					'recursive' => -1,
					'conditions' => array('id'=>$book_id)
					);
		$book=$this->Book->find('all',$options);
		$options = array(
					'recursive' => -1,
					'conditions' => array(	
											'subject_id'=>$book[0]['Book']['subject_id'],
											'grade_id'=>$book[0]['Book']['grade_id']
										)
					);
		$categories=$this->Category->find('all',$options);
		$this->header('Content-Type: application/json');
        echo json_encode($categories);
		return;
	}
	
	public function get_subcategories($id=null)
	{
		$this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$this->loadModel('Subcategory');
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
	
	public function byGrade($grade = null, $subject = null){
        $this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$this->loadModel('Category');
        $this->Category->unbindModel(array(
            'belongsTo' => array('Subject', 'Grade')
            ));

        $categories = $this->Category->find('all', array(
                'recursive' => 1,
                'conditions' => array(
                    'Category.grade_id = ' => $grade,
                    'Category.subject_id = ' => $subject
                    ),
                'fields' => array('Category.id', 'Category.name')
            ));

        // print_r($categories);

        $this->header('Content-Type: application/json');
        echo json_encode($categories);
        return;
    }
	
	public function bySubject($subject){
        $this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;

        $this->Category->unbindModel(array(
            'belongsTo' => array('Subject')
            ));

        $categories = $this->Category->find('all', array(
                'recursive' => 1,
                'conditions' => array(
                    'Category.subject_id = ' => $subject
                    ),
                'fields' => array('Category.id', 'Category.name')
            ));
        $this->header('Content-Type: application/json');
        echo json_encode($categories);
        return;
    }
	
	public function changePassword()
	{
		$this->layout = 'ajax';
		if($this->request->is('post'))
		{
			$this->autoRender = false;
			$user = $this->Session->read('user');
			$currentPassword = $this->request->data('cpwd');			
			$newPassword = $this->request->data('npwd');
			$renewPassword = $this->request->data('rnpwd');
			$code = 0; $mess = __('Has an unexpected error has occurred, please try again');
			if(md5($currentPassword)!=$user['password'])
			{
				$mess = __('Current password does not match');
			}
			else if($newPassword!=$renewPassword)
			{
				$mess = __('Two password does not match');
			}
			else
			{
				$md5Password = md5($newPassword);
				$this->loadModel('Person');
				$updateSuccess = $this->Person->updateAll(
							array(
								'password'	=>	"'".$md5Password."'"
							),
							array('Person.id' => $user['id'])
						);
				if($updateSuccess)		
				{
					//Update session & cookie
					$user['password'] = $md5Password;
					//$this->Auth->login($user);
					//$access_string = $user['id'].'|'.Security::hash($md5Password, 'md5', $user['salt']);
					//$encrypted_access_string = base64_encode(Security::cipher($access_string, Configure::read('Security.key')));
					//$this->Cookie->write('reaccess', $encrypted_access_string, true, 31536000);
					
					$code = 1;
					$mess = __('Password successfully changed');
				}
			}
			echo json_encode(array('code'=>$code, 'mess'=>$mess));
		}
	}
	
	public function login(){
		$user = array();
        $this->set('user', $user);
		$this->layout ='excel';
		$this->loadModel('Person');
		if($this->request->is('post')){			
			if($this->request->data('login')){
				$this->Session->destroy();
				$user=$this->request->data('user');
				$pass=$this->request->data('pass');
				$user=$this->Person->find('all',array(
											'recursive' => -1,
											'conditions' => array('username'=>$user),
									)
				);
				if($user!=null){
					if($user[0]['Person']['password']==md5($pass)){
						$this->Session->write('user',$user[0]['Person']);
						//$this->Auth->login($user[0]['Person']);
						$this->Cookie->delete('remember');
						//$this->Cookie->write('reaccess', $encrypted_access_string, true, 31536000);						
						if($user[0]['Person']['role']=='tester'){
							$this->redirect(array('controller' =>'partner', 'action' => 'check_question'));
						}else{
							$this->redirect(array('controller' =>'partner', 'action' => 'list_questions'));
						}
					}else{
						$this->Session->setFlash(__('Mật khẩu không đúng.'));
					}
				}else{
					
				}
			}
		}
	}
		
	public function logout() {
		$this->Session->destroy();
        //$this->Auth->logout();
		//$this->Cookie->delete('reaccess');
        return $this->redirect(array('controller' =>'partner', 'action' => 'login'));
    }
}