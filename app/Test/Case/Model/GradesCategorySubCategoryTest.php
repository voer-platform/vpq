<?php
App::uses('GradesCategorySubCategory', 'Model');

/**
 * GradesCategorySubCategory Test Case
 *
 */
class GradesCategorySubCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.grades_category_sub_category',
		'app.grade',
		'app.sub_category',
		'app.progress',
		'app.person',
		'app.score',
		'app.test',
		'app.category',
		'app.question',
		'app.answer',
		'app.questions_category',
		'app.questions_sub_category',
		'app.tests_question',
		'app.tests_category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->GradesCategorySubCategory = ClassRegistry::init('GradesCategorySubCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->GradesCategorySubCategory);

		parent::tearDown();
	}

}
