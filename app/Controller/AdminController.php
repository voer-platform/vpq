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
	
	public function sendFacebookNotify()
	{		
		$this->loadModel('FacebookNotificationsPerson');	
		
		
		
		if($this->request->is('post'))
		{
			
			$lastsend = $this->request->data('lastsend');
			$maxlasttest = $this->request->data('maxlasttest');
			$minlasttest = $this->request->data('minlasttest');
			$maxjoindate = $this->request->data('maxjoindate');
			$type = $this->request->data('type');
		
		
			$users = $this->FacebookNotificationsPerson->query("SELECT people.id, people.facebook, people.email, people.fullname, fnp.ttfn, fnp.lastsend, DATEDIFF(NOW(), people.date_created) AS joindate, DATEDIFF(NOW(), MAX(time_taken)) AS lasttest from people
				LEFT JOIN scores ON scores.person_id = people.id
				LEFT JOIN (SELECT facebook_notifications_people.person_id, DATEDIFF(NOW(), MAX(facebook_notifications_people.time)) AS lastsend, COUNT(facebook_notifications_people.id) AS ttfn 
							FROM facebook_notifications_people 
							GROUP BY facebook_notifications_people.person_id) AS fnp ON fnp.person_id = people.id
							GROUP BY people.id, people.facebook 
							HAVING (lastsend IS NULL OR lastsend >= $lastsend)
						AND ((lasttest IS NULL AND joindate <= $maxjoindate) OR (lasttest >= $minlasttest AND lasttest < $maxlasttest))");	
			
			$this->loadModel('FacebookNotification');
			$notifications = $this->FacebookNotification->find('list', array('fields'=>array('content')));
			$this->loadModel('Ranking');			
			
			
			
			if(!empty($users)){
				App::uses('CakeEmail', 'Network/Email');
				foreach($users AS $person)
				{
					$fb_id = $person['people']['facebook'];
					$person_id = $person['people']['id'];
					
					if ($type==3) {
					
						$mess = "{1} ơi, hãy mau mau tranh TOP tháng 10 để nhận những phần quà hấp dẫn từ PLS nhé";
						$mess = str_replace(array('{1}'), array("@[$fb_id]"), $mess);
						
						$notiType = 3;						
						
					} else {
					
						$rankings = $this->Ranking->find('all', array('recursive'=>1, 'conditions'=>array('person_id'=>$person_id)));
						$resultScore = '';
						
						if($person[0]['lasttest'])
						{
							$mess = $notifications[1];
							$notiType = 1;
							$days = $person[0]['lasttest'];

							foreach($rankings AS $ranking){
								$resultScore.= $ranking['Subject']['name'].' - '.$ranking['Ranking']['score'].'đ, ';
							}
							$resultScore = rtrim($resultScore, ', ');
						}
						else
						{
							$mess = $notifications[2];
							$notiType = 2;
							$days = $person[0]['joindate'];
						}
						
						$mess = str_replace(array('{1}', '{2}', '{3}'), array("@[$fb_id]", $days, $resultScore), $mess);
					
					}
					
					
					try {
						$this->Facebook->sendNotify($person['people']['facebook'], $mess);
					}
					catch(Exception $e)
					{
					
					}
					
					if($type!=3 && $person['people']['email'])
					{
						$username = $person['people']['fullname'];
						
						if($notiType==1)
						{							
							$mess = "Đã lâu rồi chưa thấy bạn làm bài trên www.PLS.edu.vn. Hãy tích cực luyện tập để nâng cao kết quả học tập nhé.";
							$mess.= '<br/><p style="  text-align: center;color: #428BCA;">Điểm số hiện tại của bạn</p><table border="1" cellpadding="5" style="text-align: center;margin: auto;">
									 <thead><tr><td><b>Môn học</b></td>';
									foreach($rankings AS $ranking){
										$mess.='<td>'.$ranking['Subject']['name'].'</td>';
									}	
							$mess.='</tr></thead><tbody><tr><td><b>Điểm</b></td>';
									foreach($rankings AS $ranking){
										$mess.='<td style="width: 70px;">'.$ranking['Ranking']['score'].'</td>';
									}	
							$mess.='</tr></tbody></table><br/>';
							
						}
						else
						{
							$mess = "Bạn đăng ký đã lâu nhưng chưa làm bài trên www.PLS.edu.vn, hệ thống sẽ giúp bạn học bài hiệu quả. Hãy thử xem";
						}
						
						$mess = str_replace("@[$fb_id]", $username, $mess);		
						$content = '<table border="0" cellpadding="30" style="border: solid #428BCA;background-color: #FDFDFD;font-size: 16px;"><tbody><tr><td>
									<p style="text-align: center;"><strong>CHÚNG TÔI RẤT NHỚ BẠN!</strong></p>
									<p>Chào <b>'.$username.'</b></p>
									<p>'.$mess.'</p>
									<p>PLS rất mong muốn được lắng nghe ý kiến của bạn để không ngừng nâng cao chất lượng học tập, và quan trọng hơn, để tiếp tục được là người bạn đồng hành tin cậy của bạn. Bạn có thể đóng góp những ý kiến của mình trực tiếp trên website hoặc gửi thư vào đia chỉ email plseduvn@gmail.com</p>
									<p>Hãy để chúng tôi lắng nghe bạn nhé!</p>
									</td></tr></tbody></table>';
									
						$Email = new CakeEmail('gmail');
						$Email->to($person['people']['email']);
						$Email->subject("$username, chúng tôi nhớ bạn");
						$Email->send($content);
					}
					
					$this->FacebookNotificationsPerson->create();
					$this->FacebookNotificationsPerson->save(array('person_id'=>$person_id, 'facebook_notify_type'=>$notiType, 'time'=>date('Y-m-d h:i:s')));
				}
			}	
			
			$this->redirect('sendFacebookNotify');
			
		}
		
		$lastsend = 7;
		$maxlasttest = 30;
		$minlasttest = 7;
		$maxjoindate = 30;
		
		if($this->request->query('filter'))
		{
		
			$lastsend = $this->request->query('lastsend');
			$maxlasttest = $this->request->query('maxlasttest');
			$minlasttest = $this->request->query('minlasttest');
			$maxjoindate = $this->request->query('maxjoindate');
			
		}
		
		$this->set('lastsend', $lastsend);
		$this->set('maxlasttest', $maxlasttest);
		$this->set('minlasttest', $minlasttest);
		$this->set('maxjoindate', $maxjoindate);
		
		$this->Paginator->settings = array(
			'FacebookNotificationsPerson' => array(
				'limit' => 10,
				'order' => array('id' => 'desc'),
				'lastsend' => $lastsend,
				'maxlasttest' => $maxlasttest,
				'minlasttest' => $minlasttest,
				'maxjoindate' => $maxjoindate
			)
		);
		$this->set('users', $this->paginate('FacebookNotificationsPerson'));	
		
	}
	
	public function reportclassify()
	{
		$this->loadModel('ClassifyQuestion');
		$data = $this->ClassifyQuestion->query(
										"SELECT DISTINCT(cq.iquestion_id), SUM(cq.role) as total, iq.question, iq.correct_percent FROM `classify_questions` as cq INNER JOIN import_questions as iq ON cq.iquestion_id = iq.id GROUP BY iquestion_id ORDER BY SUM(role) DESC"
		);
		$this->set('data',$data);
	}
	
}