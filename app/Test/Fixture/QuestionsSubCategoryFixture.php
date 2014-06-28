<?php
/**
 * QuestionsSubcategoryFixture
 *
 */
class QuestionsSubcategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'question_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'subcategory_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'question_id_subcategory_id' => array('column' => array('question_id', 'subcategory_id'), 'unique' => 0)
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
			'question_id' => 1,
			'subcategory_id' => 1
		),
	);

}
