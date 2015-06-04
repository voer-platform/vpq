<?php
App::uses('AppController', 'Controller');
/**
 * Tests Controller
 *
 * @property Test $Test
 * @property PaginatorComponent $Paginator
 */
class TestsController extends AppController {

    public $uses = array('Test', 'Grade', 'Category', 'Subcategory', 'Tracking','Question');
    /*
     * authorization
     *
     */
    public function isAuthorized($user) {
        // user can logout, dashboard, progress, history, suggest
        if (isset($user['role']) && $user['role'] === 'user' ){
            if( in_array( $this->request->action, array('chooseTest', 'doTest', 'score', 'byQuestion','timeQuestion'))){
                return true;
            }
        } elseif (isset($user['role']) && $user['role'] === 'editor' ){
            return true;
        }

        return parent::isAuthorized($user);
    }
    /**
     * beforeFilter
     *
     */
    public function beforeFilter(){
        parent::beforeFilter();

        $this->Auth->allow('sampleTest', 'score');
    }
    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Pls');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->set('title_for_layout', __('List testes'));

        $this->Test->recursive = 0;
		$this->paginate = array(
							'escape'=>false,
							'fields'=>array('Test.*', 'Subject.name', 'Person.fullname', 'Score.score', 'Score.duration', 'Score.time_taken'), 
							'joins'	=>	array(
											array(
												'table'	=>	'tests_subjects',
												'type'	=>	'INNER',
												'conditions'	=>	array('Test.id = tests_subjects.test_id')
											),
											array(
												'table'	=>	'subjects',
												'alias'	=>	'Subject',
												'type'	=>	'INNER',
												'conditions'	=>	array('Subject.id = tests_subjects.subject_id')
											),
											array(
												'table'	=>	'scores',
												'alias'	=>	'Score',
												'type'	=>	'INNER',
												'conditions'	=>	array('Score.test_id = Test.id')
											),
											array(
												'table'	=>	'people',
												'alias'	=>	'Person',
												'type'	=>	'INNER',
												'conditions'	=>	array('Score.person_id = Person.id')
											)
										)
						);
        $this->set('tests', $this->Paginator->paginate());

    }

	public function stats()
	{
		$today = date('Y-m-d');
		$last7days = date('Y-m-d', strtotime($today.' -7 days'));
		$last30days = date('Y-m-d', strtotime($today.' -30 days'));
		$this->loadModel('Score');
		$this->Score->recursive = -1;
		
		$limits = array(5, 10, 15, 30, 60, 'all');
		$testDetail = array();
		foreach($limits AS $limit)
		{
			$options = array(
						'fields'	=> array(
									'COUNT(Score.id) AS total', 
									'SUM(Score.duration) AS time', 
									'SUM((Test.time_limit)*60) AS timelimit', 
									'COUNT(DISTINCT Score.person_id) AS users',
									'COUNT(DISTINCT tests_subjects.subject_id) AS subjects'
								),
						'escape'	=>	false,
						'joins'	=>	array(
							array(
								'table'	=>	'tests',
								'alias'	=>	'Test',
								'type'	=>	'INNER',
								'conditions'	=>	array('Test.id = Score.test_id')
							),
							array(
								'table'	=>	'tests_subjects',
								'type'	=>	'INNER',
								'conditions'	=>	array('Test.id = tests_subjects.test_id')
							),
						),
						'conditions'	=>	array()
					);
			
			if($limit!='all')
			{
				$options['conditions'][] = "Test.time_limit = $limit";
			}
			
			$options['conditions'][1] = "DATE(time_taken) BETWEEN '$last7days' AND '$today'";
			$test7Days = $this->Score->find('all', $options);
			if($test7Days[0][0]['time'])
			{
				$test7Days[0][0]['average'] = $this->Pls->timeFromSeconds(round($test7Days[0][0]['time']/$test7Days[0][0]['total']));
				$test7Days[0][0]['used'] = round(($test7Days[0][0]['time']/$test7Days[0][0]['timelimit'])*100).'%';
				$test7Days[0][0]['time'] = $this->Pls->timeFromSeconds($test7Days[0][0]['time']);
				$test7Days[0][0]['timelimit'] = $this->Pls->timeFromSeconds($test7Days[0][0]['timelimit']);
			}
			else
			{
				$test7Days[0][0]['time'] = $test7Days[0][0]['timelimit'] = $test7Days[0][0]['average'] = $test7Days[0][0]['used'] = 0;
			}
			
			$options['conditions'][1] = "DATE(time_taken) BETWEEN '$last30days' AND '$today'";
			$test30Days = $this->Score->find('all', $options);
			if($test30Days[0][0]['time'])
			{
				$test30Days[0][0]['average'] = $this->Pls->timeFromSeconds(round($test30Days[0][0]['time']/$test30Days[0][0]['total']));
				$test30Days[0][0]['used'] = round(($test30Days[0][0]['time']/$test30Days[0][0]['timelimit'])*100).'%';
				$test30Days[0][0]['time'] = $this->Pls->timeFromSeconds($test30Days[0][0]['time']);
				$test30Days[0][0]['timelimit'] = $this->Pls->timeFromSeconds($test30Days[0][0]['timelimit']);
			}
			else
			{
				$test30Days[0][0]['time'] = $test30Days[0][0]['timelimit'] = $test30Days[0][0]['average'] = $test30Days[0][0]['used'] = 0;
			}
			
			if($limit!='all')
			{
				unset($options['conditions'][1]);
			}
			else
			{
				unset($options['conditions']);
			}
			
			$testAllDays = $this->Score->find('all', $options);
			if($testAllDays[0][0]['time'])
			{
				$testAllDays[0][0]['average'] = $this->Pls->timeFromSeconds(round($testAllDays[0][0]['time']/$testAllDays[0][0]['total']));
				$testAllDays[0][0]['used'] = round(($testAllDays[0][0]['time']/$testAllDays[0][0]['timelimit'])*100).'%';
				$testAllDays[0][0]['time'] = $this->Pls->timeFromSeconds($testAllDays[0][0]['time']);
				$testAllDays[0][0]['timelimit'] = $this->Pls->timeFromSeconds($testAllDays[0][0]['timelimit']);
			}
			else
			{
				$testAllDays[0][0]['time'] = $testAllDays[0][0]['timelimit'] = $testAllDays[0][0]['average'] = $testAllDays[0][0]['used'] = 0;
			}
			
			if($limit!='all')
			{
				$testDetail['test7Days'][$limit] = $test7Days[0][0];
				$testDetail['test30Days'][$limit] = $test30Days[0][0];
				$testDetail['testAllDays'][$limit] = $testAllDays[0][0];
			}
		}
		$infos = array('total', 'users', 'subjects', 'time', 'timelimit', 'average', 'used');
		$this->set('infos', $infos);
		$this->set('testDetail', $testDetail);
		$this->set('test7Days', $test7Days);
		$this->set('test30Days', $test30Days);
		$this->set('testAllDays', $testAllDays);
		
		//Getting question stats
		$this->loadModel('TestsQuestion');
		$this->TestsQuestion->recursive = -1;
		$countUsed = $this->TestsQuestion->find('all', array(
								'fields'	=>	array('tests_subjects.subject_id', 'COUNT(DISTINCT TestsQuestion.question_id) AS used'),
								'escape'	=>	false,
								'joins'		=>	array(
													array(
														'table'	=>	'tests_subjects',
														'type'	=>	'INNER',
														'conditions'	=>	'TestsQuestion.test_id = tests_subjects.test_id'
													)
												),
								'group'		=>	'tests_subjects.subject_id'				
							));
		$usedQuestion = array();
		foreach($countUsed AS $subjCount)						
		{
			$usedQuestion[$subjCount['tests_subjects']['subject_id']] = $subjCount[0]['used'];
		}
							
		$this->loadModel('Question');
		$this->Question->recursive = -1;
		$countQuestion = $this->Question->find('all', array(
										'escape'=>false,
										'fields'=>array('COUNT(DISTINCT Question.id) AS total', 'subjects.name', 'subjects.id'), 
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
														),
														array(
															'table'	=>	'subjects',
															'type'	=>	'INNER',
															'conditions'	=>	array('categories.subject_id = subjects.id')
														)
													),
										'group'	=>	array('subjects.name', 'subjects.id')
									)
							);
		$this->set('usedQuestion', $usedQuestion);
		$this->set('countQuestion', $countQuestion);
	}
	
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->set('title_for_layout', __('Test number').' '.$id);

        if (!$this->Test->exists($id)) {
            throw new NotFoundException(__('Invalid test'));
        }
        $options = array('conditions' => array('Test.' . $this->Test->primaryKey => $id));
        $this->set('test', $this->Test->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->set('title_for_layout', __('Add test'));
        if ($this->request->is('post')) {
            $this->Test->create();
            if ($this->Test->save($this->request->data)) {
                $this->Session->setFlash(__('The test has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The test could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Test->Category->find('list');
        $questions = $this->Test->Question->find('list');
        $this->set(compact('categories', 'questions'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->set('title_for_layout', __('Edit test number').' '.$id);
        if (!$this->Test->exists($id)) {
            throw new NotFoundException(__('Invalid test'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Test->save($this->request->data)) {
                $this->Session->setFlash(__('The test has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The test could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Test.' . $this->Test->primaryKey => $id));
            $this->request->data = $this->Test->find('first', $options);
        }
        $categories = $this->Test->Category->find('list');
        $questions = $this->Test->Question->find('list');
        $this->set(compact('categories', 'questions'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Test->id = $id;
        if (!$this->Test->exists()) {
            throw new NotFoundException(__('Invalid test'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Test->delete()) {
            $this->Session->setFlash(__('The test has been deleted.'));
        } else {
            $this->Session->setFlash(__('The test could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * chooseTest
     *
     * @throws NotFoundException
     * @return void
     */
    public function chooseTest($subject = null) {
		if($subject!=null)
		{
			$this->set('title_for_layout', __('Choose test'));

			$allGrades = $this->Grade->find('all');
			$this->set('grades', $allGrades);

			$this->set('subject', $subject);
			
			$user = $this->Session->read('Auth.User');
			$this->loadModel('Person');
			$options = array(
					'recursive' => -1,
					'conditions' => array('Person.id'=>$user['id'])
					);			
			$person = $this->Person->find('first',$options);
			$coin=$person['Person']['coin'];
			// $date1 = strtotime($coin[0]['Person']['last_login']);
			// $date2 = strtotime(date('Y-m-d'));
			// $diff = abs($date2-$date1);
			// $ketqua=round($diff/(60*60*24));
			
			// if($coin<=0){
				// $coin='0';
			// }
			// $this->Person->id=$user['id'];
			// $this->Person->save(
										// array(
											// 'coin' => $coin,
											// 'last_login' => date('Y-m-d'),
										// )
									// );
			$this->set('over',$this->Session->read('over'));						
			$this->set('coin',$coin);
			$gradeUser = $user['grade'];
			
			$options = array(
				'recursive' => 1,
				'conditions' => array('subject_id'=>$subject)
				);				
			$allcat = $this->Category->find('all', $options);
			$this->set('allcat',$allcat);
			if(!isset($this->request->query['subcategory']) && !isset($this->request->query['category'])){		
				if ($gradeUser == 0){
					$birthday = $user['birthday'];
					$time = strtotime($birthday);
					$date = getdate($time);
					$year = $date['year'];

					$now = getdate();
					$current_year = $now['year'];

					$gradeUser = $current_year - $year - 5; //Du doan lop hoc theo tuoi 

				}

				$grade_id=1;
				$this->set('strtracking','');
				$pretracking=array();
				$categories_id=0;
			}else{
				if(isset($this->request->query['subcategory'])){
					$id=$this->request->query['subcategory'];
					
					$tracking =$this->Subcategory->query("
									SELECT Subcategory.id, Subcategory.name,categories.id, categories.grade_id FROM subcategories as Subcategory
									INNER JOIN categories ON Subcategory.category_id=categories.id
									WHERE Subcategory.id='$id'
									");					
				}else{
					$id=$this->request->query['category'];					
					$tracking =$this->Subcategory->query("
									SELECT Subcategory.id, Subcategory.name, categories.id,categories.grade_id FROM subcategories as Subcategory
									INNER JOIN categories ON Subcategory.category_id=categories.id
									WHERE categories.id='$id'
									");
					}
				$grade_id=$tracking[0]['categories']['grade_id'];
				$categories_id=$tracking[0]['categories']['id'];				
				$strtracking='';
				$pretracking=array();
				foreach($tracking as $tracking)
				{
					$pretracking[]=$tracking['Subcategory']['id'];
					$strtracking=$strtracking.','.$tracking['Subcategory']['id'];
				}
				$this->set('strtracking',$strtracking);				
			}
			$this->set('user_id',$user['id']);
			$this->set('categories_id',$categories_id);
			$this->set('grade_id',$grade_id);
			$this->set('pretracking',$pretracking);
			$this->set('count',count($pretracking));
		}else{
			$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
		}
    }

    public function getCategories($grade = null){
        print_r($this->Category);
    }

    /**
     * doTest
     *
     * @return void
     */
    public function doTest($time, $subject, $test_id=null) {
        $this->set('title_for_layout', __('Testing'));
		
        // if specify test_id
        if(isset($test_id)){

            $this->Test->unbindModel(array(
                'hasMany' => array('Score'),
                'hasAndBelongsToMany' => array('Question')));
            $test = $this->Test->find('first', array(
                'conditions' => array('Test.id' => $test_id),
                'recursive' => 1
            ));
            $questions = $this->Test->generateTestId($test_id);
            // set to view
            $this->set('questions', $questions);
            $this->set('subject', $test['Subject'][0]['id']);
            $this->set('testID', $test_id);
            $this->set('duration', $test['Test']['time_limit']);
            $this->set('numberOfQuestions', $test['Test']['number_questions']);
        }
        // else, do normal test
        else if( isset($time) && isset($subject) ){
            // retrieve request data
            $numberOfQuestions = $time;
            $timeLimit = $time;
            $strCategories = $this->request->data['categories'];
			
            //$categories = split(",", $strCategories);
			$data = explode(",",$this->request->data['categories']);
			$categories=array();
			$update_sub='';
			foreach($data as $dt){
				if($dt!=''){
					$categories[]=$dt;
					$update_sub=$update_sub.','.$dt;					
				}
			}
            $questions = $this->Test->generateTest($numberOfQuestions, $categories);			
            if (count($questions) > 0){
                // create tests in database
                $testID = $this->Test->nextTestId();

                // save test: id, timeLimit, allow attemps, subject(currently df is 2)
                $this->Test->saveTest($testID, $timeLimit, $numberOfQuestions,-1, $subject);

                $dataTest = array();
                foreach($questions as $question){
                    $dataTest[] = array('test_id' => $testID, 'question_id' => $question['Question']['id']);
                }
                $this->loadModel('TestsQuestion');
                $this->TestsQuestion->saveAll($dataTest);

				$user = $this->Session->read('Auth.User');
				//Descrease Coin per test
				// $this->loadModel('Person');
                // $this->Person->updateAll(
								// array(
									// 'Person.coin' => "Person.coin-".($time/5)
								// ),
								// array(
									// 'Person.id'	=>	$user['id']
								// )
							// );
                // set to view
                $this->set('questions', $questions);
                $this->set('subject', $subject);
                $this->set('testID', $testID);
                $this->set('duration', $timeLimit);
                $this->set('numberOfQuestions', $numberOfQuestions);
                // Save data user
                
				
				/*$this->Tracking->deleteAll(array('Tracking.person_id'=>$user['id']));
				foreach($data as $dt)
				{
					$this->Tracking->create();
					$this->Tracking->save(
											array(
												'person_id' => $user['id'],
												'grade' => '0',
												'subject_id' => $subject,
												'subcategory' => $dt
											)
										);
				}*/
				foreach($questions as $ques)
				{
					$count= $ques['Question']['count']+1;
					$this->Question->id=$ques['Question']['id'];
					$this->Question->save(
											array(
												'count' => $count
											)
										);
				}
				$this->Tracking->id=$user['id'];
				$this->Tracking->save(
											array(
												'person_id' => $user['id'],
												'grade' => '0',
												'subject_id' => $subject,
												'subcategory' => $update_sub
											)
										);
            }else{
                // warn that no data found
                $this->Session->setFlash(__('No data found'));
                $this->redirect(array('controller' => 'tests', 'action' => 'chooseTest', $subject));
            }
        }
        else{
            $this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
        }

    }

    /**
     * score
     *
     * @return void
     */
    public function score() {

        $this->layout = 'ajax';
        $this->autoLayout = false;
        $this->autoRender = false;
		
        // process if request is post
        if( $this->request->is('post')){
            //layout						
            $this->render = false;

            // data
            $user = $this->Session->read('Auth.User');
            $testId = $this->request->data('testID');
			
			$this->loadModel('Test');
			if($this->Test->find('count', array('conditions'=>array('Test.id'=>$testId)))==0)
			{
				$this->redirect('chooseTest');
			}	
			
            $numberOfQuestions = $this->request->data['numberOfQuestions'];

            //counter to determine score
            $correctCounter = 0;

            // array for progress calulate
            $scoreData = array();

            // calculate score
            $this->loadModel('Score');
            // save to db if user has logged in
            // else just calculate.
            $scoreId = $this->Score->calculateScore($testId, $this->request->data, $user, $scoreData, $numberOfQuestions);
            // calculate progress
            $this->loadModel('Progress');
            $this->Progress->calculateProgress($user['id'], $scoreData);
			//calcutale score for ranking
			$this->loadModel('TestsSubject');
			$subject = $this->TestsSubject->find('first', array('conditions'=>array('test_id'=>$testId)));
			$subject_id = $subject['Subject']['id'];
			
			$totalScore = $this->Progress->progressOnSubject($user['id'], array('subject'=>$subject_id));
			$totalScore = round($totalScore[0]['Progress']['sum_progress']/$totalScore[0]['Progress']['sum_total'], 2)*10;
			
			$this->loadModel('Ranking');
			$subject_ranking = $this->Ranking->find('first', array('conditions'=>array('subject_id'=>$subject_id, 'person_id'=>$user['id'])));
			$ranking_data = array(
								'person_id'	=>	$user['id'],
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
				$this->Ranking->updateAll($ranking_data, array('subject_id'=>$subject_id, 'person_id'=>$user['id']));
			}
			$this->Session->write('finishTest', 1);
			$this->redirect(array('controller' => 'Scores', 'action' => 'viewDetails', $scoreId));
        }
        else {
            $this->redirect('chooseTest');
        }
    }
	
	public function byQuestion($numberOfQuestions = null, $categories = null){	
        $this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$data = explode(",",$categories);
		$categories=array();
		foreach($data as $dt){
				if($dt!=''){
					$categories[]=$dt;				
				}
			}
		$questions = $this->Test->generateTest($numberOfQuestions, $categories);		
        $this->header('Content-Type: application/json');
        echo json_encode(count($questions));
		return;
    }
	
	public function timeQuestion(){
		$this->layout = "ajax";
        $this->autoLayout = false;
        $this->autoRender = false;
		$datatime=$this->request->data;
		foreach($datatime as $index=>$data_t)
		{
			$options = array(
				'recursive' => 0,
				'conditions' => array('id'=>$index)
				);				
			$question = $this->Question->find('all', $options);
			$time = $question[0]['Question']['time']+$data_t;
			$this->Question->id=$index;
			$this->Question->save(
										array(
											'time' => $time,
										)
									);
		}
		exit();
	}
}
