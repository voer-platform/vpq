<?php
/**
 * TestsSubjectFixture
 *
 */
class TestsSubjectFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'test_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'subject_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'Index' => array('column' => array('test_id', 'subject_id'), 'unique' => 0)
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
			'subject_id' => 1
		),
	);

}
