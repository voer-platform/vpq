<?php
App::uses('AppModel', 'Model');
/**
 * RechargeLog Model
 */
class RechargeLog extends AppModel {
	public $primaryKey = 'id';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CardType' => array(
			'className' => 'CardType',
			'foreignKey' => 'card_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Person' => array(
			'className' => 'Person',
			'foreignKey' => 'person_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Promotional' => array(
			'className' => 'Promotional',
			'foreignKey' => 'promotional_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}