<?php
App::uses('Answer', 'Model');

/**
 * Answer Test Case
 *
 */
class AnswerTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.answer',
		'app.question',
		'app.category',
		'app.subcategory',
		'app.grade',
		'app.questions_subcategory',
		'app.questions_category',
		'app.test',
		'app.score',
		'app.person',
		'app.progress',
		'app.scores_answer',
		'app.tests_category',
		'app.tests_question'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Answer = ClassRegistry::init('Answer');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Answer);

		parent::tearDown();
	}

}
