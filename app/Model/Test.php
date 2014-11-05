<?php
App::uses('AppModel', 'Model');
/**
 * Test Model
 *
 * @property Score $Score
 * @property Question $Question
 * @property Subject $Subject
 */
class Test extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Score' => array(
			'className' => 'Score',
			'foreignKey' => 'test_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Question' => array(
			'className' => 'Question',
			'joinTable' => 'tests_questions',
			'foreignKey' => 'test_id',
			'associationForeignKey' => 'question_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Subject' => array(
			'className' => 'Subject',
			'joinTable' => 'tests_subjects',
			'foreignKey' => 'test_id',
			'associationForeignKey' => 'subject_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

/*
	 * generate test
	 * @params: number of question, time limit, category
	 * @return: a test correspond to input parameters
	 */
	public function genTest($numberOfQuestions, $timeLimit, $subjectId){
		$this->Question->unBindModel( array('hasMany' => array('Score')) );
		$_results = $this->Question->find('all', array(
					'limit' => $numberOfQuestions,
					'order' => 'rand()'
				));
		$results = Set::sort($_results, '{n}.Question.id', 'asc');
		return $results;
	}

	/*
	 * nextTestID
	 * @return: next Test ID
	 *
	 */
	public function nextTestId(){
		$test = $this->find('first', array(
				'recursive' => -1,
				'limit' => 1,
				'fields' => array('id'),
				'order' => 'id DESC'
				));
		$test = array_filter($test);
		if( !empty($test) ){
			$testID = $test['Test']['id'] + 1;
		}
		else {
			$testID = 1;
		}
		return $testID;
	}

	/*
	 * saveTest
	 * @param: test parameters
	 *
	 */
	public function saveTest($id, $timeLimit, $numberOfQuestions, $allowAttemps, $subjectId){
		$this->set(array(
				'id' => $id, 
				'time_limit' => $timeLimit,
				'allow_attempts' => -1,
				'number_questions' => $numberOfQuestions,
			));
		$this->save();

		$this->save(array(
			'Test' => array('id' => $id),
			'Subject' => array('id' => $subjectId)
			));
	}
}
