<?php
/**
 * ScoreFixture
 *
 */
class ScoreFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'test_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'key' => 'index'),
		'person_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'score' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,10'),
		'duration' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10),
		'time_taken' => array('type' => 'date', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'Index 2' => array('column' => array('test_id', 'person_id'), 'unique' => 0)
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
			'id' => 1,
			'test_id' => 1,
			'person_id' => 1,
			'score' => 1,
			'duration' => 1,
			'time_taken' => '2014-02-23'
		),
	);

}
