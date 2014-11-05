<?php
/**
 * TestFixture
 *
 */
class TestFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'time_limit' => array('type' => 'integer', 'null' => true, 'default' => '-1', 'length' => 10),
		'allow_attemps' => array('type' => 'integer', 'null' => true, 'default' => '-1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'time_limit' => 1,
			'allow_attemps' => 1
		),
	);

}
