<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Progress');

/**
 * Subcategory Model
 *
 * @property Category $Category
 * @property Question $Question
 */
class Subcategory extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'joinTable' => 'categories',
			'foreignKey' => 'category_id',
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
		'Question' => array(
			'className' => 'Question',
			'joinTable' => 'questions_subcategories',
			'foreignKey' => 'subcategory_id',
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
/**
 * calculate coverage
 * 
 * @param int subject_id
 *		  int person_id
 * 
 * @return float cover
 */
	public function coverage($person_id, $subject_id){
		$all = $this->find('count', array(
			'conditions' => array('subject_id' => $subject_id)
			));

		$Progress = new Progress();
		$done = $Progress->find('count', array(
			'conditions' => array('person_id' => $person_id),
			'group' => array('sub_category_id')
			));

		return $all == 0? 0 :round($done/$all, 2) * 100;
	}

/** 
 * count number of questions in db in each subcategory
 * @param: none
 * @return:
 */
	public function countQuestions(){
		return $this->query(
			"select Subcategory.name, Subcategory.id, COUNT(*) as number from questions_subcategories QuestionsSubcategory
			left join subcategories Subcategory
				on QuestionsSubcategory.subcategory_id = Subcategory.id
			group by QuestionsSubcategory.subcategory_id
			order by number asc;");
	}
}
