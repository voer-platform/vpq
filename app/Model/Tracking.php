<?php
App::uses('AppModel', 'Model');
/**
 * Tracking Model
 *
 * @property Person $Person
 */
class Tracking extends AppModel {
	public $primaryKey = 'person_id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	// public $belongsTo = array(
	// 	'Person' => array(
	// 		'className' => 'Person',
	// 		'foreignKey' => 'person_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	)
	// );

}