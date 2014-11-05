<?php
App::uses('Test', 'Model');

/**
 * Test Test Case
 *
 */
class TestTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.test',
		'app.score',
		'app.person',
		'app.progress',
		'app.subcategory',
		'app.grade',
		'app.category',
		'app.question',
		'app.answer',
		'app.scores_answer',
		'app.questions_category',
		'app.questions_subcategory',
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
		$this->Test = ClassRegistry::init('Test');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Test);

		parent::tearDown();
	}

}
