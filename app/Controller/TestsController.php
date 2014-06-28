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
	    	if( in_array( $this->action, array('chooseTest', 'doTest', 'score'))){
	    		return true;
	    	}
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
	}
/*
 *	sampleTest
 */
	public function sampleTest(){
		$this->layout = 'question_bank';

		// gen test
		$questions = $this->Test->genTest(5);
		$this->set('questions', $questions);

		$this->set('duration', 5);
		$this->set('numberOfQuestions', 5);
		$this->set('testID', null);
		$this->set('title_for_layout', 'Your first test!');
	}

/**
 * chooseTest
 *
 * @throws NotFoundException
 * @return void
 */
	public function chooseTest() {
		$this->layout = 'question_bank';
	}

/**
 * doTest
 *
 * @return void
 */
	public function doTest() {

		if ($this->request->is('post')) {
			$this->layout = 'question_bank';

			// query <number of questions> from db, random ID
			$questions = $this->Test->genTest($this->data['Test']['number_of_questions'], -1, -1);
			$this->set('questions', $questions);

			// create tests in database
			$testID = $this->Test->nextTestId();
			$this->set('testID', $testID);
			$this->set('duration', $this->data['Test']['time_limit']);
			$this->set('numberOfQuestions', $this->data['Test']['number_of_questions']);
			// save test: id, timeLimit, allow attemps, category(currently df is 2)
			$this->Test->saveTest($testID, $this->data['Test']['time_limit'], -1, 2);

			//create questions for test in db
			$conn = mysql_connect("localhost:3306", 'root', 'abc123');
			mysql_select_db('questionbank');
			foreach($questions as $question){
				$query = 'INSERT INTO `tests_questions`(`test_id`, `question_id`) values('.$testID.','.$question['Question']['id'].');';
				mysql_query($query, $conn);
			}
			mysql_close($conn);
			// $this->loadModel('TestsQuestion');			
			// foreach( $questions as $question){
			// 	$this->TestsQuestion->set(array(
			// 		'test_id' => $testID,
			// 		'question_id' => $question['Question']['id']
			// 	));
			// 	$this->TestsQuestion->save();
			// 	$this->TestsQuestion->clear();
			// }
		}
		// if it's not a post, return to chooseTest
		else{
			$this->redirect('chooseTest');
		}
	}

/**
 * score
 *
 * @return void
 */
	public function score() {
		if( $this->request->is('post')){
			
			$this->layout = 'question_bank';
			//counter to determine score			
			$correctCounter = 0;
			$questionCounter = 0;

			//check if answer is right or not
			// it is: increse correctCounter by 1
			$this->loadModel('Answer');

			// remove with int(0)
			function my_filter($var){
				return ($var !== NULL && $var !== FALSE && $var !== '');
			}

			// filter empty-answered questions
			// user did not tick in the answer
			$filteredArray = array_filter($this->data, 'my_filter');

			$progressArray = array();
			// get row in array, key=question_id, value=>answer_id
			foreach ( $filteredArray as $question => $answerId) {
				
				// there are some hidden fields, need to confirm that field is test's id or not
				if(!is_numeric($question))
					continue;

				// evaluate answerId by 1 becase:
				// 		answer is return from 0-1
				// 		db has answer id 1-4
				$answerId++;

				$result = $this->Answer->find('first', array(
					'recursive' => -1,
					'conditions' => array(
						'question_id' => $question,
						'id' => $answerId
						)
					));
				// count correct questions
				// store correctness to progressArray for calculate progress
				if( $result['Answer']['correctness'] == 1){
					$correctCounter++;
					$progressArray[$question] = 1;
				}
				else{
					$progressArray[$question] = 0;
				}
				// countnumber of questions for scoring
				$questionCounter++;
				
			}
			$user = $this->Session->read('Auth.User');
			if(!empty($user)){
				//save to database
				//save score
				$this->loadModel('Score');
				$this->Score->saveScore($this->data['testID'], $user['id'], $questionCounter==0?0 : round($correctCounter/$questionCounter,2), -1, date("Y-m-d H:i:s"));

				// save score_answers
                // >>> NOT DO YET!!! <<<
				
			}
			// calculate progress
			$this->loadModel('Progress');
			$this->Progress->calculateProgress($user['id'], $progressArray);
			
			// set variable to view
			$this->set('finalScore', $correctCounter);
			$this->set('correct', array($correctCounter, $questionCounter, $this->data['numberOfQuestions']));
		}
		else {
			$this->redirect('chooseTest');
		}
	}
}
