<?php
App::uses('Progress', 'Model');

/**
 * Progress Test Case
 *
 */
class ProgressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.progress',
		'app.person',
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
		'app.tests_category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Progress = ClassRegistry::init('Progress');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Progress);

		parent::tearDown();
	}

}
