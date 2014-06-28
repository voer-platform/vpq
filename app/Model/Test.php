<?php
App::uses('AppModel', 'Model');
/**
 * Test Model
 *
 * @property Score $Score
 * @property Category $Category
 * @property Question $Question
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
		'Category' => array(
			'className' => 'Category',
			'joinTable' => 'tests_categories',
			'foreignKey' => 'test_id',
			'associationForeignKey' => 'category_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
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
		)
	);

	/*
	 * generate test
	 * @params: number of question, time limit, category
	 * @return: a test correspond to input parameters
	 */
	public function genTest($numberOfQuestions, $timeLimit, $categoryId){
		return $this->Question->find('all', array(
					'limit' => $numberOfQuestions,
					'order' => 'rand()'
				));
	}

	/*
	 * nextTestID
	 * @return: next Test ID
	 *
	 */
	public function nextTestId(){
		$tests = $this->find('all', array(
				'recursive' => -1,
				'limit' => 1,
				'fields' => array('id'),
				'order' => 'id DESC'
				));
		$tests = array_filter($tests);
		if( !empty($tests) ){
			$testID = $tests[0]['Test']['id'] + 1;
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
	public function saveTest($id, $timeLimit, $allowAttemps, $categoryId){
		$this->set(array(
				'id' => $id, 
				'time_limit' => $timeLimit,
				'allow_attempts' => -1,
			));
		$this->save();

		$this->save(array(
				'Test' => array('id' => $id),
				'Category' => array('id' => $categoryId)
				));
	}
}
