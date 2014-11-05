<?php
/**
 * TestsQuestionFixture
 *
 */
class TestsQuestionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'test_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'index'),
		'question_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'indexes' => array(
			'Index 1' => array('column' => array('test_id', 'question_id'), 'unique' => 0)
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
			'test_id' => 1,
			'question_id' => 1
		),
	);

}
