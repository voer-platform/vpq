<?php
App::uses('AppModel', 'Model');
/**
 * QuestionsSubcategory Model
 *
 * @property Question $Question
 * @property Subcategory $Subcategory
 */
class QuestionsSubcategory extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	public $hasMany = array(
		'Subcategory' => array(
			'className' => 'Subcategory',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subcategory1' => array(
			'className' => 'Subcategory',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subcategory2' => array(
			'className' => 'Subcategory',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User1' => array(
			'className' => 'Person',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User2' => array(
			'className' => 'Person',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}