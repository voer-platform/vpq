<?php
App::uses('AppModel', 'Model');
/**
 * Notification Model
 */
class Notification extends AppModel {
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
		'Person2' => array(
	 		'className' => 'Person',
	 		'foreignKey' => 'object_id',
	 		'conditions' => '',
	 		'fields' => '',
			'order' => ''
		),
		'NotificationType' => array(
	 		'className' => 'NotificationType',
	 		'foreignKey' => 'notification_type_id',
	 		'conditions' => '',
	 		'fields' => '',
			'order' => ''
		)
	);
	
	public function getNotification($person_id){
		$options = array(
						'conditions'	=>	array(
												'Notification.person_id'	=>	$person_id
											),
						'order'	=>	array('Notification.time' => 'DESC')					
					);
		$result = $this->find('all', $options);
		return $result;
	}
	
	public function getUnreadNotification($person_id){
		$options = array(
						'conditions'	=>	array(
												'Notification.person_id'	=>	$person_id,
												'Notification.status'		=>	0
											)
					);
		$this->recursive = -1;			
		$result = $this->find('count', $options);
		return $result;
	}
	
	public function resetCounter($person_id){
		$this->updateAll(
					array('status'	=>	1),
					array('person_id' => $person_id)
				);
	}
	
}