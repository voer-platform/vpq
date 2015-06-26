<?php
App::uses('Controller', 'Controller');
/**
 * People Controller
 * @property Person $Person
 * @property PaginatorComponent $Paginator
 */
class LoginController extends AppController {

/*
* beforeFilter
*/
	public function beforeFilter(){
        parent::beforeFilter();
        // Allow users to
        $this->Auth->allow('index');
    }

/**
 * index method
 *
 * @return void
 */
    public function index(){
		$this->set('title_for_layout', __('Login'));
    }
}
