<?php
App::uses('AppController', 'Controller');
/**
 * Tests Controller
 *
 * @property Test $Test
 * @property PaginatorComponent $Paginator
 */
class TestsController extends AppController {
/*
 * authorization
 * 
 */
	public function isAuthorized($user) {
	    // user can logout, dashboard, progress, history, suggest
	    if (isset($user['role']) && $user['role'] === 'user' ){
	    	if( in_array( $this->request->action, array('chooseTest', 'doTest', 'score'))){
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
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Test->recursive = 0;
		$this->set('tests', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
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
	}/**
 * chooseTest
 *
 * @throws NotFoundException
 * @return void
 */
	public function chooseTest($subject = null) {
		$this->set('subject', $subject);
	}

/**
 * doTest
 *
 * @return void
 */
	public function doTest($time, $subject) {
		// process if request is post
		if( isset($time) && isset($subject) ){


	        // retrieve request data
			$numberOfQuestions = $time;
			$timeLimit = $time;

			// query <number of questions> from db, random ID
			$questions = $this->Test->genTest($numberOfQuestions, -1, -1);

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

			// set to view
			$this->set('questions', $questions);
			$this->set('subject', $subject);
			$this->set('testID', $testID);
			$this->set('duration', $timeLimit);
			$this->set('numberOfQuestions', $numberOfQuestions);
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
        
        // process if request is post
		if( $this->request->is('post')){
			
            //layout
			$this->render = false;

			// data
			$user = $this->Session->read('Auth.User');
			$testId = $this->request->data('testID');
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
			
			$this->redirect(array('controller' => 'Scores', 'action' => 'viewDetails', $scoreId));
		}
		else {
			$this->redirect('chooseTest');
		}
	}
}
