<?php
	App::uses('AppModel', 'Model');
	class ExpSubject extends AppModel {
	
		public $belongsTo = array(
			'Person' => array(
				'className' => 'Person',
				'foreignKey' => 'person_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			)
		);
	}
?>