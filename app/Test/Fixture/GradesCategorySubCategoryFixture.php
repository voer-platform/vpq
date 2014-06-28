<?php
/**
 * GradesCategorySubCategoryFixture
 *
 */
class GradesCategorySubCategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'grade_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'sub_category_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'Index 1' => array('column' => array('grade_id', 'sub_category_id', 'category_id'), 'unique' => 0)
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
			'grade_id' => 1,
			'sub_category_id' => 1,
			'category_id' => 1
		),
	);

}
