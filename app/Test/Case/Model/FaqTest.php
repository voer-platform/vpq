<?php
App::uses('Faq', 'Model');

/**
 * Faq Test Case
 *
 */
class FaqTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.faq',
		'app.person',
		'app.progress',
		'app.subcategory',
		'app.category',
		'app.subject',
		'app.test',
		'app.score',
		'app.question',
		'app.answer',
		'app.attachment',
		'app.questions_subcategory',
		'app.scores_question',
		'app.tests_question',
		'app.tests_subject',
		'app.grade'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Faq = ClassRegistry::init('Faq');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Faq);

		parent::tearDown();
	}

}
