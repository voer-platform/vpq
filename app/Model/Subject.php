<?php
App::uses('AppModel', 'Model');
/**
 * Subject Model
 *
 * @property Category $Category
 * @property Test $Test
 */
class Subject extends AppModel {

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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'subject_id',
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
		'Test' => array(
			'className' => 'Test',
			'joinTable' => 'tests_subjects',
			'foreignKey' => 'subject_id',
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
 * get subject overview for a person
 * @param   person_id
 * @return  overview of subject
 */
	public function subjectOverview($person_id, $filterOptions = null)
	{
		$sql = array(
					'fields'	=>	array('Ranking.score, Subject.id, Subject.name'),
					'joins'	=>	array(
									array(
										'type'	=>	'LEFT',
										'table'	=>	'rankings',
										'alias'	=>	'Ranking',
										'conditions'	=>	array(
												'Ranking.subject_id = Subject.id'
											)
									)		
								),
					'conditions'	=>	array(
							'OR'	=>	array(
											array('Ranking.person_id' => $person_id)
										)
						),	
					'recursive' => -1,
					'order'	=>	array('Subject.order'=>'ASC')
				);
				
		if(isset($filterOptions['subject']))
		{	
			if(is_array($filterOptions['subject']))
				$sql['conditions'][] = "Subject.id IN (".implode(',', $filterOptions['subject']).")";
			else
				$sql['conditions'][] = "Subject.id = ".$filterOptions['subject'];
		}
		
		$results = $this->find('all', $sql);
		
		$hasData = array();
		
		foreach($results AS $subj)
		{
			$hasData[] = $subj['Subject']['id'];
		}
		
		$sql = array(
					'fields'	=>	array('Subject.id, Subject.name'),
					'conditions'=>array(
							'NOT'=>array('id'=>$hasData)
						),
					'recursive' => -1	
				);
		if(isset($filterOptions['subject']))
		{	
			if(is_array($filterOptions['subject']))
				$sql['conditions'][] = "Subject.id IN (".implode(',', $filterOptions['subject']).")";
			else
				$sql['conditions'][] = "Subject.id = ".$filterOptions['subject'];
		}
		
		$noData = $this->find('all', $sql);
		
		
		
		foreach($noData AS $k=>$subj)
		{
			$noData[$k]['Ranking']['score']	= '';
		}
		
		return array_merge($results, $noData);		
	}
}
