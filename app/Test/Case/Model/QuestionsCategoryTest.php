<?php
App::uses('QuestionsCategory', 'Model');

/**
 * QuestionsCategory Test Case
 *
 */
class QuestionsCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.questions_category',
		'app.question',
		'app.answer',
		'app.score',
		'app.test',
		'app.category',
		'app.subcategory',
		'app.grade',
		'app.questions_subcategory',
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
		$this->QuestionsCategory = ClassRegistry::init('QuestionsCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->QuestionsCategory);

		parent::tearDown();
	}

}
