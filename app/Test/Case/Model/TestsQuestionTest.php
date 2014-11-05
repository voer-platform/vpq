<?php
App::uses('TestsQuestion', 'Model');

/**
 * TestsQuestion Test Case
 *
 */
class TestsQuestionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tests_question',
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
		'app.tests_category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TestsQuestion = ClassRegistry::init('TestsQuestion');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TestsQuestion);

		parent::tearDown();
	}

}
