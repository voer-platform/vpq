<?php
App::uses('Question', 'Model');

/**
 * Question Test Case
 *
 */
class QuestionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.question',
		'app.answer',
		'app.score',
		'app.test',
		'app.category',
		'app.subcategory',
		'app.grade',
		'app.questions_subcategory',
		'app.questions_category',
		'app.tests_category',
		'app.tests_question',
		'app.person',
		'app.progress',
		'app.scores_answer'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Question = ClassRegistry::init('Question');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Question);

		parent::tearDown();
	}

}
