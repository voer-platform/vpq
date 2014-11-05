<?php
App::uses('ScoresAnswer', 'Model');

/**
 * ScoresAnswer Test Case
 *
 */
class ScoresAnswerTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.scores_answer',
		'app.score',
		'app.test',
		'app.category',
		'app.subcategory',
		'app.grade',
		'app.question',
		'app.answer',
		'app.questions_category',
		'app.questions_subcategory',
		'app.tests_question',
		'app.tests_category',
		'app.person',
		'app.progress'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ScoresAnswer = ClassRegistry::init('ScoresAnswer');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ScoresAnswer);

		parent::tearDown();
	}

}
