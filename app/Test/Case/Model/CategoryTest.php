<?php
App::uses('Category', 'Model');

/**
 * Category Test Case
 *
 */
class CategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.category',
		'app.subcategory',
		'app.grade',
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
		$this->Category = ClassRegistry::init('Category');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Category);

		parent::tearDown();
	}

}
