<?php
App::uses('Subcategory', 'Model');

/**
 * Subcategory Test Case
 *
 */
class SubcategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.subcategory',
		'app.grade',
		'app.category',
		'app.question',
		'app.answer',
		'app.score',
		'app.test',
		'app.tests_category',
		'app.tests_question',
		'app.person',
		'app.progress',
		'app.scores_answer',
		'app.questions_category',
		'app.questions_subcategory'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Subcategory = ClassRegistry::init('Subcategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Subcategory);

		parent::tearDown();
	}

}
