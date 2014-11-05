<?php
App::uses('Score', 'Model');

/**
 * Score Test Case
 *
 */
class ScoreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.score',
		'app.test',
		'app.category',
		'app.subcategory',
		'app.grade',
		'app.question',
		'app.answer',
		'app.scores_answer',
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
		$this->Score = ClassRegistry::init('Score');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Score);

		parent::tearDown();
	}

}
