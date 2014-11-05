<?php
/**
 * ProgressFixture
 *
 */
class ProgressFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'person_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'sub_category_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'progress' => array('type' => 'float', 'null' => true, 'default' => null),
		'indexes' => array(
			'Index 1' => array('column' => array('person_id', 'sub_category_id'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'person_id' => 1,
			'sub_category_id' => 1,
			'progress' => 1
		),
	);

}
