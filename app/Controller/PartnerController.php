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
	    	if( in_array( $this->request->action, array('import_excel', 'check_question', 'view_question', 'changePassword','getBook','getCategory','remake','get_subcategories','byGrade','bySubject'))){
                return true;
            }
	    }
		if (isset($user['role']) && $user['role'] === 'editor') {
			if( in_array( $this->request->action, array('import_excel','view_question', 'changePassword','getBook','getCategory','remake','get_subcategories','byGrade','bySubject'))){
                return true;
            }
		}
		if (isset($user['role']) && $user['role'] === 'tester') {
			if( in_array( $this->request->action, array('check_question', 'view_question', 'changePassword','getBook','getCategory','get_subcategories','byGrade','bySubject'))){
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
		$this->set('title_for_layout',__("Admin"));
	}

/**
 * insert questions
 *
 * @return void
 */
	
	public function import_excel(){
		require_once(APP. 'Vendor'. DS .'PHPExcel.php');
		require_once(APP. 'Vendor'. DS . 'PHPExcel'. DS. 'IOFactory.php');
		$user = $this->Session->read('user');
		$this->set('user', $user);
		if(!isset($user)){
			$this->redirect(array('controller' =>'login', 'action' => 'index'));
		};
		$this->layout ='excel';
		$this->loadModel('ImportQuestion');
		$this->loadModel('QuestionsSubcategory');
		$this->loadModel('Subcategory');
		$this->loadModel('Category');
		$this->loadModel('Subject');
		$this->loadModel('File');		
		if($this->request->data('import_excel')){
			if($_FILES['file_import']['error'] == 0){
				$data = PHPExcel_IOFactory::load($_FILES['file_import']['tmp_name']);				
				$sheetData = $data->getActiveSheet()->toArray(null, true, true, true);
				$file=$this->File->find('all',array(
												'recursive' => -1,
												'conditions' => array('name'=>$_FILES['file_import']['name'])
				));
				if($file==null){
					$author		=	$sheetData[5]['B'];
					$subject		=	$sheetData[6]['B'];
					$subject_id		=	$sheetData[7]['B'];
					$book_name			=	$sheetData[8]['B'];
					$book_id			=	$sheetData[9]['B'];

					$this->File->create();
					if($this->File->save(array(
											'name'=>$_FILES['file_import']['name'],
											)
										)
					){
								
					//Chạy từng hàng trong sheetData
						foreach ($sheetData as $row){
							if (is_numeric($row['A']) && !empty($row['B'])) {
								$question=	$row['B'];
								$solution= 	$row['C'];
								$answer_a=$row['D'];
								$answer_b=$row['E'];
								$answer_c=$row['F'];
								$answer_d=$row['G'];
								$answer_correct=$row['H'];
								$page=$row['I'];
								$sentence=$row['J'];
								$subcategory_id=$row['K'];
								if($subcategory_id==''){
									$subcategory_id=0;
								}
								//////////////
								
								$this->ImportQuestion->create();
								if($this->ImportQuestion->save(
														array(
															'user'	   =>$user['id'],
															'author'   =>$author,
															'subject'	=>$subject,
															'subject_id'=>$subject_id,
															'book_id'		=>$book_id,
															'book_name'		=>$book_name,
															'subcategory_id' => $subcategory_id,						
															'page'		=>$page,
															'sentence'	=>$sentence,
															'question'	=>$question,
															'solution'	=>$solution,
															'answer_a'	=>$answer_a,
															'answer_b'	=>$answer_b,
															'answer_c'	=>$answer_c,
															'answer_d'	=>$answer_d,
															'answer_correct'=>$answer_correct,
															'check_question'=>'0',
															'date'=>date('d/m/Y'),
														)
													))
								{								
									$this->Session->setFlash('Import Success');
								}else{
									$this->Session->setFlash('Import Fail');
								}					
							}
						}
					}else{
						$this->Session->setFlash('Import Fail');
					}
				}else{
					$this->Session->setFlash(__('File này đã được nhập.'));
				}
			}
		}
		
		if(isset($this->request->query['delete'])){
			$this->ImportQuestion->id = $this->request->query['delete'];
			if ($this->ImportQuestion->delete()) {
				$this->Session->setFlash(__('Xóa thành công.'));
			} else {
				$this->Session->setFlash(__('Xóa thất bại.'));
			}
		}
		$options=array('user'=>$user['id']);
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
				/*if($category_id!=''){
					$options['category_id']=$category_id;
					$this->loadModel('Subcategory');
					$subcategories = $this->Subcategory->find('all', array(
																'recursive' => -1,
																'conditions' => array(
																	'category_id = ' => $category_id,
																	),
															));
					$this->set('subcategories',$subcategories);
				}
				if($subcategory_id!=''){
					$options['subcategory_id']=$subcategory_id;
				}*/
				if($state!=''){
					$options['check_question']=$state;
				}
				$this->set('subject_id',$subject_id);
				$this->set('book_id',$book_id);
				$this->set('state',$state);
				//$this->set('category_id',$category_id);
				//$this->set('subcategory_id',$subcategory_id);
			}	
		}else{
			$this->set('subject_id','');
			$this->set('book_id','');
			$this->set('category_id','');
			$this->set('subcategory_id','');
			$this->set('state','');
		}
		$this->Paginator->settings = array(
			'limit' => 5,
			'conditions'=>$options
		);
		$import_question = $this->Paginator->paginate('ImportQuestion');
		$this->set('import_question',$import_question);
		
		$this->Paginator->setting = array(
			'limit'	=> 5,
			'conditions'=>$options
		);
		$option2=array(
					'recursive' => -1,
				);
		$this->set('subject',$this->Subject->find('all',$option2));
	}
	
	public function check_question(){
		$user = $this->Session->read('user');
		$this->set('user', $user);
		if(!isset($user)){
			$this->redirect(array('controller' =>'login', 'action' => 'index'));
		};
		$this->layout ='excel';
		$this->loadModel('ImportQuestion');
		$this->loadModel('Subject');
		if(isset($this->request->query['delete'])){
			$this->ImportQuestion->id = $this->request->query['delete'];
			if ($this->ImportQuestion->delete()) {
				$this->Session->setFlash(__('Xóa thành công.'));
			} else {
				$this->Session->setFlash(__('Xóa thất bại.'));
			}
		}
		$this->set('sub_name','chọn tất cả');
		$this->set('book_name','chọn tất cả');		
		$option_total=array('recursive' => -1);
		$options=array();
		if($this->request->is('post')){
			if($this->request->data('search')){
				$subject_id=$this->request->data('subject');
				$book_id=$this->request->data('book');
				$category_id=$this->request->data('categories');
				$subcategory_id=$this->request->data('subcategories');
				$state=$this->request->data('state');
				if($subject_id!=''){
					$options['subject_id']=$subject_id;
					$option_total['subject_id']=$subject_id;
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
					$option_total['book_id']=$book_id;
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
				/*if($category_id!=''){
					$options['category_id']=$category_id;
					$this->loadModel('Subcategory');
					$subcategories = $this->Subcategory->find('all', array(
																'recursive' => -1,
																'conditions' => array(
																	'category_id = ' => $category_id,
																	),
															));
					$this->set('subcategories',$subcategories);
				}
				if($subcategory_id!=''){
					$options['subcategory_id']=$subcategory_id;
				}*/
				if($state!=''){
					$options['check_question']=$state;
				}
				$this->set('subject_id',$subject_id);
				$this->set('book_id',$book_id);
				$this->set('category_id',$category_id);
				$this->set('subcategory_id',$subcategory_id);
				$this->set('state',$state);
			}	
		}else{
			$this->set('subject_id','');
			$this->set('book_id','');
			$this->set('category_id','');
			$this->set('subcategory_id','');
			$this->set('state','');
		}
		$this->Paginator->settings = array(
			'limit' => 10,
			'conditions'=>$options
		);
		$import_question = $this->Paginator->paginate('ImportQuestion');
		$total_question = $this->ImportQuestion->find('all',$option_total);
		$this->set('count',count($import_question));
		$this->set('count_total',count($total_question));
		$this->set('import_question',$import_question);
		
		$option2=array(
					'recursive' => -1,
				);
		$this->set('subject',$this->Subject->find('all',$option2));
		
	}
	
	public function view_question($id){
		$user = $this->Session->read('user');
		$this->set('user', $user);
		if(!isset($user)){
			$this->redirect(array('controller' =>'login', 'action' => 'index'));
		};
		$this->layout ='excel';
		$this->loadModel('ImportQuestion');
		$this->loadModel('Question');
		$this->loadModel('QuestionsSubcategory');
		$this->loadModel('Answer');
		$this->loadModel('Category');
		$this->loadModel('Subcategory');	
		if($this->request->data('update')){
			$data=$this->request->data;
			if($this->ImportQuestion->updateAll(
												array(
													'question'=>"'".$data['content_question']."'",
													'answer_a'  =>"'".$data['text_a']."'",
													'answer_b'  =>"'".$data['text_b']."'",
													'answer_c'  =>"'".$data['text_c']."'",
													'answer_d'  =>"'".$data['text_d']."'",
													'answer_correct'  =>"'".$data['answer_correct']."'",
												),
												array(
													'id'=>$data['id'],
												)
			)){
				$this->Session->setFlash(__('Cập nhật thành công'));
			}else{
				$this->Session->setFlash(__('Cập nhật thất bại'));
			}
		}
		$options = array(
					'recursive' => -1,
					'conditions' => array('id'=>$id)
					);
		$data_question=$this->ImportQuestion->find('all',$options);		
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
			'limit' => 5,
			'recursive' => -1,
			'conditions'=>array(
							'content LIKE'=>$string.'%',
			)
		);
		$same_question = $this->Paginator->paginate('Question');
		$this->set('count_same',count($same_question));
		$this->set('same_question',$same_question);
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
		if($this->request->data('yes')){
			$user_id = $this->Session->read('Auth.User')['id'];
			$subcategory_id=$this->request->data('subcategory_id');
			
			$options = array(
					'recursive' => -1,
					'conditions' => array('id'=>$id)
					);
			$data_question=$this->ImportQuestion->find('all',$options);
			$error_pull=false;
			$question=	$data_question[0]['ImportQuestion']['question'];		
			$solution= 	$data_question[0]['ImportQuestion']['solution'];			
			$answer=array(
						'1'=>$data_question[0]['ImportQuestion']['answer_a'],
						'2'=>$data_question[0]['ImportQuestion']['answer_b'],
						'3'=>$data_question[0]['ImportQuestion']['answer_c'],
						'4'=>$data_question[0]['ImportQuestion']['answer_d'],
			);
			$correct=explode(' ',trim($data_question[0]['ImportQuestion']['answer_correct']));
			if($data_question[0]['ImportQuestion']['subcategory2_id']==''){	
				if($data_question[0]['ImportQuestion']['subcategory1_id']=='')
				{
					if($this->ImportQuestion->updateAll(
												array(
													'person1_id'=>$user_id,
													'subcategory1_id'=>$subcategory_id,
												),
												array(
													'id'=>$data_question[0]['ImportQuestion']['id'],
												)
					)){
						$this->Session->setFlash(__('Duyệt thành công.'));
						$this->redirect(array('controller' =>'Admin', 'action' => 'check_question'));
					}else{
						$this->Session->setFlash(__('Duyệt thất bại.'));
					}
				}else{
					if($data_question[0]['ImportQuestion']['person1_id']!=$user_id)
					{
						if($data_question[0]['ImportQuestion']['subcategory1_id']==$subcategory_id){
							/*if($this->ImportQuestion->updateAll(
													array(
														'person2_id'=>$user_id,
														'subcategory2_id'=>$subcategory_id,
														'check_question'=>3,
													),
													array(
														'id'=>$data_question[0]['ImportQuestion']['id'],
													)
							)){
								$this->Session->setFlash(__('Duyệt thành công.'));
							}else{
								$this->Session->setFlash(__('Duyệt thất bại.'));
							}*/
							$this->Question->begin(); 
							$error = false;
							$this->Question->create();
							if($this->Question->save(
													array(
														'content'	=>$question,
														'difficulty'=>0,
														'solution'	=>$solution,
														'count'		=>0,
														'time'		=>0,
														'report'	=>0,
														'wrong'		=>0,
														'status'	=>1,
													)									
							)){
								$insert_id=$this->Question->getLastInsertId();
								$this->QuestionsSubcategory->create();
								if(!$this->QuestionsSubcategory->save(
														array(
															'question_id'=>$insert_id,
															'subcategory_id'=>$subcategory_id,
															'subcategory1_id'=>0,
															'persion1_id'=>null,
															'subcategory2_id'=>0,
															'persion2_id_id'=>null,
														)
								)){
									$error = true; 
								}
								foreach($answer as $key=>$value){
									$this->Answer->create();
									if(in_array($key,$correct)){
										if(!$this->Answer->save(
													array(
														'question_id'=>$insert_id,
														'order'		 =>$key,
														'content'	 =>$value,
														'correctness'=>1,
													)
										)){
											$error = true; 
										}
									}else{
										if(!$this->Answer->save(
													array(
														'question_id'=>$insert_id,
														'order'		 =>$key,
														'content'	 =>$value,
														'correctness'=>0,
													)
										)){
											$error = true; 
										}
									}
								}
								if(!$this->ImportQuestion->updateAll(
															array(
																'person2_id'=>$user_id,
																'subcategory2_id'=>$subcategory_id,
																'check_question'=>3,
															),
															array(
																'id'=>$data_question[0]['ImportQuestion']['id'],
															)
								)){
									$error = true; 
								}
							}
							if($error) {
								$this->Question->rollback();
								$this->Session->setFlash(__('Duyệt thất bại.'));
							}
							else
							{							
								$this->Question->commit();
								$this->redirect(array('controller' =>'Admin', 'action' => 'check_question'));
								$this->Session->setFlash(__('Duyệt thành công câu hỏi số '.$insert_id));
							}
						}else{
							if($this->ImportQuestion->updateAll(
													array(
														'person1_id'=>null,
														'subcategory1_id'=>null,
													),
													array(
														'id'=>$data_question[0]['ImportQuestion']['id'],
													)
							)){
								$this->redirect(array('controller' =>'Admin', 'action' => 'check_question'));
								$this->Session->setFlash(__('Phân loại không trùng'));
							}else{
								$this->Session->setFlash(__('Lỗi phân loại câu hỏi'));
							}
						}
					}else{
						$this->Session->setFlash(__('Tài khoản này đã kiểm tra lần 1'));
					}
				}
			}else{
				$this->Session->setFlash(__('Câu hỏi này đã được phân loại'));
			}
		}
		
		if($this->request->data('no')){
			if(isset($this->request->data['id'])){
				$this->ImportQuestion->id = $this->request->data['id'];
				if ($this->ImportQuestion->delete()) {
					$this->redirect(array('controller' =>'Admin', 'action' => 'check_question'));
					$this->Session->setFlash(__('Xóa thành công.'));					
				} else {
					$this->Session->setFlash(__('Xóa thất bại.'));
				}
			}
		}
		
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
					$this->redirect(array('controller' =>'Admin', 'action' => 'import_excel'));
					$this->Session->setFlash(__('Duyệt thành công'));
				}else{
					$this->Session->setFlash(__('Duyệt thất bại'));
				}
			}
		}
		
		if($this->request->data('no2')){
			if(isset($this->request->data['id'])){
				if($this->ImportQuestion->updateAll(
												array(
													'check_question'=>2,
												),
												array(
													'id'=>$this->request->data['id'],
												)
				)){
					$this->redirect(array('controller' =>'Admin', 'action' => 'import_excel'));
					$this->Session->setFlash(__('Duyệt thành công'));
				}else{
					$this->Session->setFlash(__('Duyệt thất bại'));
				}
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
		

}