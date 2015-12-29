<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * beforeFilter
 *
 */
public function beforeFilter(){
	parent::beforeFilter();

	$this->Auth->allow('display', 'aboutUs','forgotPassword', 'Qa','instruction');
}	

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout =__("PLS");
		$this->set('title_for_layout',__("Home"));

		if (!empty($path[0])) {
			$page = $path[0];
			if($page=='home' && $this->Auth->loggedIn()) {
				$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));				
			}
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'physicsBank'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

    public function aboutUs(){
        $this->set('title_for_layout',__("About us"));

        $this->loadModel('StaticPage');
        $about = $this->StaticPage->find('first', array(
        	'conditions' => array('StaticPage.name' => 'about')));

        $this->set('about', $about);
    }
	
	public function Qa(){
        $this->set('title_for_layout',__("Hỏi đáp"));

        // $this->loadModel('StaticPage');
        // $about = $this->StaticPage->find('first', array(
        	// 'conditions' => array('StaticPage.name' => 'about')));

        // $this->set('about', $about);
    }
	
	public function instruction(){
		$this->set('title_for_layout',__("Instruction"));
	}
	
}
