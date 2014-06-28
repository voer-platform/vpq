<?php
App::uses('GradesSubCategory', 'Model');

/**
 * GradesSubCategory Test Case
 *
 */
class GradesSubCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.grades_sub_category',
		'app.grade',
		'app.sub_category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->GradesSubCategory = ClassRegistry::init('GradesSubCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->GradesSubCategory);

		parent::tearDown();
	}

}
