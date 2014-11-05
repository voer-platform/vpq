<?php
App::uses('Person', 'Model');

/**
 * Person Test Case
 *
 */
class PersonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.person',
		'app.progress',
		'app.subcategory',
		'app.grade',
		'app.category',
		'app.question',
		'app.answer',
		'app.score',
		'app.test',
		'app.tests_category',
		'app.tests_question',
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
		$this->Person = ClassRegistry::init('Person');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Person);

		parent::tearDown();
	}

}
