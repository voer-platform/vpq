<?php
App::uses('StaticPage', 'Model');

/**
 * StaticPage Test Case
 *
 */
class StaticPageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.static_page'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->StaticPage = ClassRegistry::init('StaticPage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->StaticPage);

		parent::tearDown();
	}

}
