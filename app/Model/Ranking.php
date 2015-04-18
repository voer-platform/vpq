<?php
App::uses('AppModel', 'Model');
/**
 * Tracking Model
 *
 * @property Person $Person
 */
class Ranking extends AppModel {
	public $primaryKey = 'id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	 public $belongsTo = array(
	 	'Person' => array(
	 		'className' => 'Person',
	 		'foreignKey' => 'person_id',
	 		'conditions' => '',
	 		'fields' => '',
			'order' => ''
		),
		'Subject' => array(
	 		'className' => 'Subject',
	 		'foreignKey' => 'subject_id',
	 		'conditions' => '',
	 		'fields' => '',
			'order' => ''
		)
	);

	public function getSubjectRanking($user_id, $subject_id = null){
		$this->recursive = -1;
		$result = $this->find('all', array('conditions'=>array('person_id'=>$user_id)));
		$ranking_data = array();
		foreach($result AS $subject)
		{
			$score = $subject['Ranking']['score'];
			$subject_id = $subject['Ranking']['subject_id'];
			$time = $subject['Ranking']['time_update'];
			$ordinal = $this->find('count', 
						array(
							'conditions' => array(
								'subject_id'	=>	$subject_id,
								"score > $score"
								//"((score > $score) OR (score = $score AND time_update < '$time'))"
							)
						)
					);
			$ranking_data[$subject_id] = $ordinal+1;		
		}
		return $ranking_data;
	}
	
}