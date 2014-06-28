<?php
App::uses('TestsCategory', 'Model');

/**
 * TestsCategory Test Case
 *
 */
class TestsCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tests_category',
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
		'app.tests_question'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TestsCategory = ClassRegistry::init('TestsCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TestsCategory);

		parent::tearDown();
	}

}
