<?php
App::uses('AppModel', 'Model');
/**
 * Question Model
 *
 * @property Answer $Answer
 * @property Subcategory $Subcategory
 * @property Score $Score
 * @property Test $Test
 */
class Question extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Answer' => array(
			'className' => 'Answer',
			'foreignKey' => 'question_id',
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
		'Subcategory' => array(
			'className' => 'Subcategory',
			'joinTable' => 'questions_subcategories',
			'foreignKey' => 'question_id',
			'associationForeignKey' => 'subcategory_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Score' => array(
			'className' => 'Score',
			'joinTable' => 'scores_questions',
			'foreignKey' => 'question_id',
			'associationForeignKey' => 'score_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Test' => array(
			'className' => 'Test',
			'joinTable' => 'tests_questions',
			'foreignKey' => 'question_id',
			'associationForeignKey' => 'test_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

	/**
	 * get questions from ids
	 * @param: id list
	 * @return: questions list
	 */
	public function getQuestionsFromIds($ids){
		$this->unBindModel( array('hasAndBelongsToMany' => array('Test', 'Score', 'Subcategory')) );
		return $this->find('all', array(
			'recursive' => 1,
			'contain' => true,
			'conditions' => array(
				'id' => $ids
				)
			));
	}
}
