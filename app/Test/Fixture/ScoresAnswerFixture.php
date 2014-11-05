<?php
/**
 * ScoresAnswerFixture
 *
 */
class ScoresAnswerFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'score_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'answer_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'answer' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'Index 1' => array('column' => array('score_id', 'answer_id'), 'unique' => 0)
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
			'score_id' => 1,
			'answer_id' => 1,
			'answer' => 1
		),
	);

}
