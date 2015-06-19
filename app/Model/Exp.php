<?php
	App::uses('AppModel', 'Model');
	class Exp extends AppModel {
	
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