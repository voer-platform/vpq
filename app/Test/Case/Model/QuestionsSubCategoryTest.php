<?php
App::uses('QuestionsSubcategory', 'Model');

/**
 * QuestionsSubcategory Test Case
 *
 */
class QuestionsSubcategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.questions_subcategory',
		'app.question',
		'app.answer',
		'app.score',
		'app.test',
		'app.category',
		'app.subcategory',
		'app.grade',
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
		$this->QuestionsSubcategory = ClassRegistry::init('QuestionsSubcategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->QuestionsSubcategory);

		parent::tearDown();
	}

}
