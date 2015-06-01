<?php 
App::uses('AppController', 'Controller');
/**
 * Admin Controller
 *
 * @property Admin $Admin
 * @property PaginatorComponent $Paginator
 */
class AdminController extends AppController {

	// do not use model
	var $uses = false;

	// public $helpers = array('TinymceElfinder.TinymceElfinder');
	// public $components = array('Paginator','TinymceElfinder.TinymceElfinder');
	public $helpers = array();
	public $components = array('Paginator');

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
	    if (isset($user['role']) && $user['role'] === 'editor' ){
	    	return true;
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
	public function insertQuestions(){
		$this->set('title_for_layout',__("Add questions"));

		$this->loadModel('Question');
		$this->loadModel('Grade');
		$this->loadModel('Subject');
		/*if($this->request->is('post')){
			$path = WWW_ROOT. DS . 'files';
			if(isset($this->request->data['Attachment'])){
				foreach($this->request->data['Attachment'] as $key => $value){
					$newName = date('YmdHisu').'-'.$key.'.jpg';
					move_uploaded_file($value['tmp_name'], $path.DS.$newName);
					$this->request->data['Attachment'][$key] = array(
						'path' => Router::url('/', true).'files'.'/'.$newName
						);
				}
			}
			foreach ($this->request->data['Answer'] as $key => $answer) {
				$this->request->data['Answer'][$key]['order'] = $key;
			}
			$this->Question->create();
			if ($this->Question->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved.'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		}*/
		$options = array(
					'recursive' => -1,
					);
		$this->set('grade',$this->Grade->find('all',$options));
		$this->set('subject',$this->Subject->find('all',$options));
		//$subcategories = $this->Question->Subcategory->find('list', array('order' => array('Subcategory.id ASC')));
		//$tests = $this->Question->Test->find('list');
		$this->set(compact('subcategories', 'tests'));
	}
	
	public function addquestion(){
		$this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$question=$this->request->data;
		$correct=explode(' ',trim($question['correct']));
		pr($correct);
		echo "<br/>";
		$this->loadModel('Question');
		$this->loadModel('QuestionsSubcategory');
		$this->loadModel('Answer');
		$question['question']=strip_tags($question['question'],'<img>');
		for($i=0;$i<4;$i++){
			$question[$i]=strip_tags($question[$i],'<img>');
		};
		$this->Question->save(
								array(
									'content'	=>$question['question'],
									'difficulty'=>0,
									'solution'	=>'',
									'count'		=>0,
									'time'		=>0,
									'report'	=>0,
									'wrong'		=>0,
								)
							); 
		$insert_id=$this->Question->getLastInsertId();
		$this->QuestionsSubcategory->save(
								array(
									'question_id'=>$insert_id,
									'subcategory_id'=>$question['subcategories'],
									'subcategory1_id'=>0,
									'persion1_id'=>null,
									'subcategory2_id'=>0,
									'persion2_id_id'=>null,
								)
		);
		for($i=0;$i<4;$i++){
			$this->Answer->create();
			if(in_array($i,$correct)){
				$this->Answer->save(
							array(
								'question_id'=>$insert_id,
								'order'		 =>$i,
								'content'	 =>$question[$i],
								'correctness'=>1,
							)
				);
			}else{
				$this->Answer->save(
							array(
								'question_id'=>$insert_id,
								'order'		 =>$i,
								'content'	 =>$question[$i],
								'correctness'=>0,
							)
				);
			}
		};
		echo $insert_id;
	}

/**
 * elfinder
 *
 * @return void
 */
	public function elfinder() {
        $this->TinymceElfinder->elfinder();
    }

/**
 * connector for elfindier
 *
 * @return void
 */ 
    public function connector() {
        $this->TinymceElfinder->connector();
    }

/**
 * insert multiple questions
 *
 * @return void
 */
	public function insertMultipleQuestions(){
		$this->set('title_for_layout',__("Add multiple questions"));

		if($this->request->is('post')){
			// unzip file
			$file = $this->request->data['Import']['file']['tmp_name'];
			$filename = $this->request->data['Import']['file']['name'];
			$filename = substr($filename, 0, strrpos($filename, '.'));

			$path = pathinfo(realpath($file), PATHINFO_DIRNAME).DS.microtime(true);

			$zip = new ZipArchive;
			$res = $zip->open($file);

			// open OK
			if ($res === TRUE) {
				// extract it to the path we determined above
				$zip->extractTo($path);
				$zip->close();

				// read data file extract at path/filename
				if( file_exists($path.DS.$filename.DS.'data.txt'))
					$data_path = $path.DS.$filename;
				else
					$data_path = $path.DS;

				$data = file_get_contents($data_path.DS.'data.txt');
				// process data
				$this->loadModel('Question');
				$result = $this->Question->processMassImport($data, $data_path);

				if($result){
					$this->Session->setFlash(__('Import success. Please verify in manage question list.'));
				}
				else{
					$this->Session->setFlash(__('Import Fail. Please verify in manage question list.'));
				}

			} else {
				$this->Session->setFlash(__('The imported data could not be process, please try again later.'));
			}

			
		}
	}

/**
 * manual categorized question
 * 
 *
 */
	public function manualCategorized(){
		$this->set('title_for_layout', 'Categorize');

		$this->loadModel('Question');
		$this->Question->unBindModel(array(
			'hasMany' => array('Answer', 'Attachment'),
			'hasAndBelongsToMany' => array('Score', 'Test')
			));

		$this->Paginator->settings = $this->paginate;
		$this->set('questions', $this->Paginator->paginate('Question'));
	}

/**
 * questions number analystic
 *
 */
	public function analystics(){
		$this->set('title_for_layout', __('Analystic'));

		$this->loadModel('Subcategory');
		$data = $this->Subcategory->countQuestions();

		$this->set('data', $data);
	}
/**
 * display ranking table
 */
 
	public function ranking()
	{
		$this->loadModel('Ranking');
		$this->loadModel('Subject');
		$subjects = $this->Subject->find('list');
		$options = array();
		
		$this->Ranking->virtualFields['num_test'] = 'COUNT(tests_subjects.test_id)';
		$this->Paginator->settings = array(
					'joins'	=> array(
									array(
										'table'	=>	'scores',
										'type'	=>	'INNER',
										'conditions'	=>	'scores.person_id = Ranking.person_id'
									),
									array(
										'table'	=>	'tests_subjects',
										'type'	=>	'INNER',
										'conditions'	=>	'tests_subjects.test_id = scores.test_id'
									)
								),
					'group'	=>	array('Ranking.subject_id, Ranking.person_id')			
				);
		if(isset($this->request->params['named']['subject']))
		{
			$subject = $this->request->params['named']['subject'];
			if($subject)
				$options['Subject.id'] = $subject;
				
			$this->set('current_subject', $subject);
		}
		$rankings = $this->Paginator->paginate('Ranking', $options);
		$this->set('rankings', $rankings);
		$this->set('subjects', $subjects);
	}
 
/**
 * rebuild ranking table
 */
	public function rebuildRanking()
	{
		$this->autoRender = false;
		$this->loadModel('Subject');
		$this->loadModel('Person');
		$this->loadModel('Ranking');
		$this->loadModel('Progress');
		$subjects = $this->Subject->find('list');
		$people = $this->Person->find('list');
		foreach($subjects AS $subject_id => $subject)
		{
			foreach($people AS $person_id=>$person)
			{
				$totalScore = $this->Progress->progressOnSubject($person_id, array('subject'=>$subject_id));
				if(!empty($totalScore))
				{
					$totalScore = round($totalScore[0]['Progress']['sum_progress']/$totalScore[0]['Progress']['sum_total'], 2)*10;
					
					$subject_ranking = $this->Ranking->find('first', array('conditions'=>array('subject_id'=>$subject_id, 'person_id'=>$person_id)));
					$ranking_data = array(
										'person_id'	=>	$person_id,
										'subject_id'	=>	$subject_id,
										'score'	=>	$totalScore,
										'time_update'	=>	date('Y-m-d H:i:s')
									);
					if(empty($subject_ranking))
					{
						$this->Ranking->create();
						$this->Ranking->save($ranking_data);
					}
					else
					{
						$ranking_data['time_update'] = "'".date('Y-m-d H:i:s')."'";
						$this->Ranking->updateAll($ranking_data, array('subject_id'=>$subject_id, 'person_id'=>$person_id));
					}
				}
			}
		}
		$this->Session->setFlash(__('Ranking data refreshed.'));
		$this->redirect(array('controller' =>'Admin', 'action' => 'ranking'));
	}
	public function promotional(){
		$this->set('btn','them');
		$this->loadModel('promotional');
		if($this->request->data('them')){
			$start_date=explode("/",$this->request->data('start_date'));
			$start_date=$start_date[2]."-".$start_date[1]."-".$start_date[0];
			$end_date=explode("/",$this->request->data('end_date'));
			$end_date=$end_date[2]."-".$end_date[1]."-".$end_date[0];
			
			if($this->promotional->save(
									array(
										'percent'		=>	$this->request->data('promotional'),
										'start_date'	=>	$start_date,
										'end_date'		=>	$end_date,
									)
			)){
				$this->Session->setFlash('Cập nhật thành công');
			}else{
				$this->Session->setFlash('Cập nhật thất bại');
			}
		}
		
		if(isset($this->request->query['update'])){
			$options = array('conditions' => array('promotional.' . $this->promotional->primaryKey => $this->request->query['update']));
            $update = $this->promotional->find('first', $options);
			$start_date=explode("-",$update['promotional']['start_date']);
			$update['promotional']['start_date']=$start_date[2]."/".$start_date[1]."/".$start_date[0];
			$end_date=explode("-",$update['promotional']['end_date']);
			$update['promotional']['end_date']=$end_date[2]."/".$end_date[1]."/".$end_date[0];
			$this->set('btn','sua');
		}else{
			$update=array('promotional'=>array(
											'id'=>'',
											'percent'=>'',
											'start_date'=>'',
											'end_date'=>'',
			));
		}
		
		if($this->request->data('sua')){
			$start_date=explode("/",$this->request->data('start_date'));
			$start_date=$start_date[2]."-".$start_date[1]."-".$start_date[0];
			$end_date=explode("/",$this->request->data('end_date'));
			$end_date=$end_date[2]."-".$end_date[1]."-".$end_date[0];
			$this->promotional->id=$this->request->data('id');
			if($this->promotional->save(
									array(
										'percent'		=>	$this->request->data('promotional'),
										'start_date'	=>	$start_date,
										'end_date'		=>	$end_date,
									)
			)){
				$this->Session->setFlash('Cập nhật thành công');
				$this->redirect(array('controller' =>'Admin', 'action' => 'promotional'));
			}else{
				$this->Session->setFlash('Cập nhật thất bại');
			}
		}
		
		if(isset($this->request->query['delete'])){
			$this->promotional->id = $this->request->query['delete'];
			if ($this->promotional->delete()) {
				$this->Session->setFlash(__('Xóa thành công.'));
			} else {
				$this->Session->setFlash(__('Xóa thất bại.'));
			}
		}
		
		$this->set('update',$update);
		//pr($this->Paginator->paginate('promotional')));
		$this->Paginator->settings = array(
			'limit' => 5,
			'order' => array('id' => 'DESC'),
		);
		$data = $this->Paginator->paginate('promotional');
		foreach($data as $item=>$dt){
			$start_date=explode("-",$dt['promotional']['start_date']);
			$dt['promotional']['start_date']=$start_date[2]."/".$start_date[1]."/".$start_date[0];
			$end_date=explode("-",$dt['promotional']['end_date']);
			$dt['promotional']['end_date']=$end_date[2]."/".$end_date[1]."/".$end_date[0];
			$data[$item]=$dt;
		}
		$this->set('data',$data);		
	}
	
	public function import_excel(){
		$this->loadModel('ImportQuestion');
		if($this->request->data('import_excel')){
			if($_FILES['file_import']['error'] == 0){
				$data = PHPExcel_IOFactory::load($_FILES['file_import']['tmp_name']);	
				$sheetData = $data->getActiveSheet()->toArray(null, true, true, true);
				
				$user		=	$sheetData[5]['B'];
				$subject		=	$sheetData[6]['B'];
				$subject_id		=	$sheetData[7]['B'];
				$book_name			=	$sheetData[8]['B'];
				$book_id			=	$sheetData[9]['B'];
				$category_name	=	$sheetData[10]['B'];
				$category_id	=	$sheetData[11]['B'];
				//Chạy từng hàng trong sheetData
				
				foreach ($sheetData as $row){
					if (is_numeric($row['A'])) {
						$question=	$row['B'];
						$solution= 	$row['C'];
						$subcategory_id=$row['D'];
						$subcategory_name=$row['E'];
						$answer_a=$row['F'];
						$answer_b=$row['G'];
						$answer_c=$row['H'];
						$answer_d=$row['I'];
						$answer_correct=$row['J'];
						$page=$row['K'];
						$sentence=$row['L'];
						$this->ImportQuestion->create();
						if($this->ImportQuestion->save(
												array(
													'user'   =>$user,
													'subject'	=>$subject,
													'subject_id'=>$subject_id,
													'book_id'		=>$book_id,
													'book_name'		=>$book_name,													
													'page'		=>$page,
													'sentence'	=>$sentence,
													'category_id'	=>$category_id,
													'category_name'	=>$category_name,
													'subcategory_id'=>$subcategory_id,
													'subcategory_name'=>$subcategory_name,
													'question'	=>$question,
													'solution'	=>$solution,
													'answer_a'	=>$answer_a,
													'answer_b'	=>$answer_b,
													'answer_c'	=>$answer_c,
													'answer_d'	=>$answer_d,
													'answer_correct'=>$answer_correct,
													'check_question'=>'0',
												)
											))
						{
							$this->Session->setFlash('Import Success');
						}else{
							$this->Session->setFlash('Import Fail');
						}					
					}
				}	
			}
		}
	}
	
	public function check_question(){
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
		$options=array('check_question'=>'0');
		if($this->request->is('post')){
			if($this->request->data('search')){
				$subject_id=$this->request->data('subject');
				$book_id=$this->request->data('book');
				$category_id=$this->request->data('categories');
				$subcategory_id=$this->request->data('subcategories');
				if($subject_id!=''){
					$options['subject_id']=$subject_id;
					$this->loadModel('Book');
					$options3 = array(
					'recursive' => -1,
					'conditions' => array('subject_id'=>$subject_id)
					);
					$book=$this->Book->find('all',$options3);
					$this->set('book',$book);
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
				if($category_id!=''){
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
				}
				$this->set('subject_id',$subject_id);
				$this->set('book_id',$book_id);
				$this->set('category_id',$category_id);
				$this->set('subcategory_id',$subcategory_id);
			}	
		}else{
			$this->set('subject_id','');
			$this->set('book_id','');
			$this->set('category_id','');
			$this->set('subcategory_id','');
		}
		$this->Paginator->settings = array(
			'limit' => 10,
			'conditions'=>$options
		);
		$import_question = $this->Paginator->paginate('ImportQuestion');
		$this->set('import_question',$import_question);
		$option2=array(
					'recursive' => -1,
				);
		$this->set('subject',$this->Subject->find('all',$option2));
		
	}
	
	public function view_question($id){
		$this->loadModel('ImportQuestion');
		$this->loadModel('Question');
		$this->loadModel('QuestionsSubcategory');
		$this->loadModel('Answer');
		$options = array(
					'recursive' => -1,
					'conditions' => array('id'=>$id)
					);
		$data_question=$this->ImportQuestion->find('all',$options);		
		$correct=explode(' ',trim($data_question[0]['ImportQuestion']['answer_correct']));
		foreach($correct as $correct){
			$answer_correct[$correct]='';
		}
		$this->set('correct',$answer_correct);
		$this->set('question',$data_question);
		
		/*if($this->request->data('yes')){
			$this->loadModel('ImportQuestion');
			$this->loadModel('PullQuestion');
			$question=	$data_question[0]['ImportQuestion']['question'];		
			$solution= 	$data_question[0]['ImportQuestion']['solution'];		
			$subcategories=$data_question[0]['ImportQuestion']['subcategory_id'];		
			$answer=array(
						'1'=>$data_question[0]['ImportQuestion']['answer_a'],
						'2'=>$data_question[0]['ImportQuestion']['answer_b'],
						'3'=>$data_question[0]['ImportQuestion']['answer_c'],
						'4'=>$data_question[0]['ImportQuestion']['answer_d'],
			);
			$correct=explode(' ',trim($data_question[0]['ImportQuestion']['answer_correct']));	
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
									)									
			)){
				$insert_id=$this->Question->getLastInsertId();
				$this->QuestionsSubcategory->create();
				if(!$this->QuestionsSubcategory->save(
										array(
											'question_id'=>$insert_id,
											'subcategory_id'=>$subcategories,
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
												'check_question'=>1,
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
				$this->Session->setFlash(__('Duyệt thành công câu hỏi số '.$insert_id));
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
		}*/
		if($this->request->data('yes')){
			$this->loadModel('ImportQuestion');
			$user_id = $this->Session->read('Auth.User')['id'];
			$subcategory_id=$this->request->data('subcategory_id');
			$options = array(
					'recursive' => -1,
					'conditions' => array('id'=>$id)
					);
			$data_question=$this->ImportQuestion->find('all',$options);
			if($data_question[0]['ImportQuestion']['person1_id']=='')
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
				}else{
					$this->Session->setFlash(__('Duyệt thất bại.'));
				}
			}else{
				if($data_question[0]['ImportQuestion']['person1_id']!=$user_id)
				{
					if($this->ImportQuestion->updateAll(
											array(
												'person2_id'=>$user_id,
												'subcategory2_id'=>$subcategory_id,
												'check_question'=>1,
											),
											array(
												'id'=>$data_question[0]['ImportQuestion']['id'],
											)
					)){
						$this->Session->setFlash(__('Duyệt thành công.'));
					}else{
						$this->Session->setFlash(__('Duyệt thất bại.'));
					}
				}else{
					$this->Session->setFlash(__('Tài khoản này đã kiểm tra lần 1'));
				}
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
	}
	
	public function pull_question(){
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
		$options=array('check_question'=>'1','subcategory1_id=subcategory2_id');		
		if($this->request->is('post')){
			if($this->request->data('search')){
				$subject_id=$this->request->data('subject');
				$book_id=$this->request->data('book');
				$category_id=$this->request->data('categories');
				$subcategory_id=$this->request->data('subcategories');
				if($subject_id!=''){
					$options['subject_id']=$subject_id;
					$this->loadModel('Book');
					$options3 = array(
					'recursive' => -1,
					'conditions' => array('subject_id'=>$subject_id)
					);
					$book=$this->Book->find('all',$options3);
					$this->set('book',$book);
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
				if($category_id!=''){
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
				}
				$this->set('subject_id',$subject_id);
				$this->set('book_id',$book_id);
				$this->set('category_id',$category_id);
				$this->set('subcategory_id',$subcategory_id);
			}	
		}else{
			$this->set('subject_id','');
			$this->set('book_id','');
			$this->set('category_id','');
			$this->set('subcategory_id','');
		}
		$this->Paginator->settings = array(
			'limit' => 10,
			'conditions'=>$options
		);
		$import_question = $this->Paginator->paginate('ImportQuestion');
		$this->set('import_question',$import_question);
		$option2=array(
					'recursive' => -1,
				);
		$this->set('subject',$this->Subject->find('all',$option2));
		
	}
	
	public function view_pull($id){
		$this->loadModel('ImportQuestion');
		$this->loadModel('Question');
		$this->loadModel('QuestionsSubcategory');
		$this->loadModel('Answer');
		$options = array(
					'recursive' => -1,
					'conditions' => array('id'=>$id),
					);
		$data_question=$this->ImportQuestion->find('all',$options);		
		$correct=explode(' ',trim($data_question[0]['ImportQuestion']['answer_correct']));
		foreach($correct as $correct){
			$answer_correct[$correct]='';
		}
		$this->set('correct',$answer_correct);
		$this->set('question',$data_question);
		
		if($this->request->data('yes')){
			$error_pull=false;
			$question=	$data_question[0]['ImportQuestion']['question'];		
			$solution= 	$data_question[0]['ImportQuestion']['solution'];		
			$subcategories=$data_question[0]['ImportQuestion']['subcategory_id'];		
			$answer=array(
						'1'=>$data_question[0]['ImportQuestion']['answer_a'],
						'2'=>$data_question[0]['ImportQuestion']['answer_b'],
						'3'=>$data_question[0]['ImportQuestion']['answer_c'],
						'4'=>$data_question[0]['ImportQuestion']['answer_d'],
			);
			$correct=explode(' ',trim($data_question[0]['ImportQuestion']['answer_correct']));
			$array_question_new=explode(' ',$question);
			$count1=count($array_question_new);
			$options = array(
					'recursive' => 0,
					'conditions' => array('subcategory_id'=>$data_question[0]['ImportQuestion']['subcategory1_id']),
					'joins'=>array(
                        array(
                            'type'=>'INNER',
                            'table'=>'questions',
                            'alias'=>'Questions',
                            'conditions'=>array(
                                'Questions.id = QuestionsSubcategory.question_id'
                            )
                        )
                    )
					);				
			$question_old=$this->QuestionsSubcategory->find('all',$options);
			foreach($question_old as $ques){
				$k=0;
				$array_question_old=explode(' ',$ques['Question']['content']);
				$count2=count($array_question_old);
				if($count1==$count2){
					if($count2>=20){
						for($i=0;$i<20;$i++){
							if($array_question_old[$i]!=$array_question_new[$i]){
								$k+=1;
							}
						}
						if($k==20){
							$error_pull=true;
						}
					}else{
						for($i=0;$i<$count1;$i++){
							if($array_question_old[$i]!=$array_question_new[$i]){
								$k+=1;
							}
						}
						if($k==$count1){
							$error_pull=true;
						}
					}
				}				
			}
			if($error_pull){
				$this->Session->setFlash(__('Duyệt thất bại, câu hỏi này đã tồn tại.'));
			}else{
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
										)									
				)){
					$insert_id=$this->Question->getLastInsertId();
					$this->QuestionsSubcategory->create();
					if(!$this->QuestionsSubcategory->save(
											array(
												'question_id'=>$insert_id,
												'subcategory_id'=>$subcategories,
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
													'check_question'=>2,
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
					$this->Session->setFlash(__('Duyệt thành công câu hỏi số '.$insert_id));
				}
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
}