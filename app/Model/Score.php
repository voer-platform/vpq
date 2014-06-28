	<?php
App::uses('AppModel', 'Model');
/**
 * Score Model
 *
 * @property Test $Test
 * @property Person $Person
 * @property Answer $Answer
 */
class Score extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Test' => array(
			'className' => 'Test',
			'foreignKey' => 'test_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Person' => array(
			'className' => 'Person',
			'foreignKey' => 'person_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Answer' => array(
			'className' => 'Answer',
			'joinTable' => 'scores_answers',
			'foreignKey' => 'score_id',
			'associationForeignKey' => 'answer_id',
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
 * save a score
 * @param:
 */
	public function saveScore($testId, $user, $score, $duration, $timeTaken){
		$this->set(array(
				'test_id' => $testId,
				'person_id' => $user,
				'score' => $score,
				'duration' => $duration,
				'time_taken' => $timeTaken
				));
		$this->save();
	}
/*
 * get all user
 */
	public function getAllScores($id){
		return $this->find('all', array(
				'conditions' => array(
					'Score.person_id' => $id,
				),
				'fields' => array(
					'Score.score',
					'Score.time_taken',
					'Score.test_id',
					'Test.time_limit'	
				),
				'order' => array('time_taken' => 'desc')
			));
	}
}
