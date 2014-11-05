<?php
App::uses('AppModel', 'Model');
/**
 * ScoresQuestion Model
 *
 * @property Score $Score
 * @property Question $Question
 * @property Answer $Answer
 */
class ScoresQuestion extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Score' => array(
			'className' => 'Score',
			'foreignKey' => 'score_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		// 'Answer' => array(
		// 	'className' => 'Answer',
		// 	'foreignKey' => 'answer_id',
		// 	'conditions' => '',
		// 	'fields' => '',
		// 	'order' => ''
		// )
	);
}
