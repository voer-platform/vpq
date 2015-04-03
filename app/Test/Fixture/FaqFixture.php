<?php
/**
 * FaqFixture
 *
 */
class FaqFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'content' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 4800, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'person_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'answer' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 4800, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 4800, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'content' => 'Lorem ipsum dolor sit amet',
			'person_id' => 1,
			'answer' => 'Lorem ipsum dolor sit amet',
			'status' => 'Lorem ipsum dolor sit amet'
		),
	);

}
