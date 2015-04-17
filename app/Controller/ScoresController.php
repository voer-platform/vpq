<?php
App::uses('AppController', 'Controller');
/**
 * Scores Controller
 *
 * @property Score $Score
 * @property PaginatorComponent $Paginator
 */
class ScoresController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Pls');
/**
 * Before filter
 */
    public function beforeFilter(){
        parent::beforeFilter();  
       $this->Auth->allow('viewDetails');
    }
/**
 * authorization
 * 
 */
	public function isAuthorized($user) {
	    // user can logout, dashboard, progress, history, suggest
	    if (isset($user['role']) && $user['role'] === 'user' ){
	    	if( in_array( $this->request->action, array('viewDetails', 'ajaxOverall', 'ajaxCallHandler','report'))){
	    		return true;
	    	}
	    }
	    else if (isset($user['role']) && $user['role'] === 'editor' ){
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
		$this->Score->recursive = 0;
		$this->set('scores', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Score->exists($id)) {
			throw new NotFoundException(__('Invalid score'));
		}
		$options = array('conditions' => array('Score.' . $this->Score->primaryKey => $id));
		$this->set('score', $this->Score->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Score->create();
			if ($this->Score->save($this->request->data)) {
				$this->Session->setFlash(__('The score has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The score could not be saved. Please, try again.'));
			}
		}
		$tests = $this->Score->Test->find('list');
		$people = $this->Score->Person->find('list');
		$this->set(compact('tests', 'people'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Score->exists($id)) {
			throw new NotFoundException(__('Invalid score'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Score->save($this->request->data)) {
				$this->Session->setFlash(__('The score has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The score could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Score.' . $this->Score->primaryKey => $id));
			$this->request->data = $this->Score->find('first', $options);
		}
		$tests = $this->Score->Test->find('list');
		$people = $this->Score->Person->find('list');
		$this->set(compact('tests', 'people'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Score->id = $id;
		if (!$this->Score->exists()) {
			throw new NotFoundException(__('Invalid score'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Score->delete()) {
			$this->Session->setFlash(__('The score has been deleted.'));
		} else {
			$this->Session->setFlash(__('The score could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * view score details
 *	
 *	@param int $id
 *	@return void
 */
	public function viewDetails($id){
        $this->set('title_for_layout', __('Test result'));

		$this->loadModel('ScoresQuestion');

		$this->Score->unbindModel(array('belongsTo' => array('Person')));
		$score = $this->Score->find('first', array('conditions' => array('Score.id' => $id), 'recursive' => 0) );
		$scoreData = $this->ScoresQuestion->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'score_id' => $id
			)
		));

		$questionsIds = array();
		foreach($scoreData as $data){$questionIds[] = $data['ScoresQuestion']['question_id'];}

		$this->loadModel('Question');
		$questions = $this->Question->getQuestionsFromIds($questionIds);
	   
        $this->loadModel('TestsSubject');
        $subject = $this->TestsSubject->find('first', array('conditions' => array('TestsSubject.test_id' => $score['Test']['id'])));

		ksort($scoreData); // sort the data to match result from $questions
        $this->set('subject', $subject);
        $this->set('test_id', $score['Score']['test_id']);
		$this->set('questionsData', $questions);
		$this->set('scoreData', $scoreData);
		$this->set('correct', $score['Score']['score']);
		$this->set('numberOfQuestions', $score['Test']['number_questions']);
		$this->set('duration', $score['Test']['time_limit']);
	}

/**
 * performance details
 * ajax call
 */
    public function performanceDetails(){
        $this->layout = 'ajax';
        $this->autoLayout = false;
        $this->autoRender = false;
        
        if( $this->request->is('POST')){
            if(isset($_POST['subject'])){
                $user = $this->Session->read('Auth.User');
                $result = $this->Score->getScoresForChart($user['id'], $this->request->data('subject'));
                echo $result;
            }
        }
        else {
            $this->redirect('/');
        }
    }

/**
 * ajax call for overall
 * ajax call
 */
	public function ajaxCallHandler(){
		$this->layout = 'ajax';
        $this->autoLayout = false;
        $this->autoRender = false;
        
        if( $this->request->is('POST')){
            $subject_id = '2';//isset($this->request->data['subjectID']) ? $this->request->data['subjectID'] : null;
            $grade_id = isset($this->request->data['gradeID']) && $this->request->data['gradeID'] != '' ? $this->request->data['gradeID'] : null;
            $category_id = isset($this->request->data['categoryID']) ? $this->request->data['categoryID'] : null;
			
			$timerange_type = $this->request->data['timeRangeType'];
			$timeOptions = array('type'=>$timerange_type);
			if($timerange_type=='custom')
			{
				$timeOptions['start'] = $this->Pls->vnTimeToStandardTime($this->request->data['timeStart']);
				$timeOptions['end'] = $this->Pls->vnTimeToStandardTime($this->request->data['timeEnd']);
			}
			$filterOptions = array('time'=>$timeOptions);
            $user = $this->Session->read('Auth.User');
            $chart = $this->Score->getChartData($user['id'], $subject_id, $timeOptions);

			$this->loadModel('Question');
			$cover = array();
			//$cover = $this->Question->getCover($user['id'], $filterOptions);
			//$cover = $this->Question->getSubcategoryCover($user['id'], $filterOptions);

			// get subject for dashboard
			$this->loadModel('Progress');
			$result = $this->Progress->progressOnSubject($user['id'], $filterOptions);
			$progresses = array();
			foreach($result AS $subject)
			{
				$progresses[$subject['Subject']['id']] = $subject['Progress'];
			}
			//pr($progresses);
			//$this->set('progresses', $progresses);
			//pr($progresses);
            // echo json_encode(array($subject_id, $grade_id, $category_id));
			$result = array('chart'=>$chart, 'progresses'=>$progresses, 'cover'=>$cover);
            $this->header('Content-Type: application/json');
            echo json_encode($result);
        }
        else {
            $this->header('Content-Type: application/json');
            echo json_encode(array(
                'messsage' => 'error in query message'));
        }
	}
	
	public function report($id){
		$options = array(
				'recursive' => 0,
				'conditions' => array('id'=>$id)
				);		
		$this->loadModel('Question');
		$question = $this->Question->find('all', $options);
		$report= $question[0]['Question']['report']+1;
		$this->Question->id=$id;
		$this->Question->save(
									array(
										'report' => $report
									)
								);
		exit();
	}

}
