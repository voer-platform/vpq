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
class Announcement extends AppModel {
	public $primaryKey = 'id';

    //The Associations below have been created with all possible keys, those that are not needed can be removed

	public $validate = array(
		'content' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array();


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
    public $hasAndBelongsToMany = array();

}