<?php 
App::uses('AppController', 'Controller');
/**
 * Admin Controller
 *
 * @property Admin $Admin
 * @property PaginatorComponent $Paginator
 */
class AdminController extends AppController {

	// do not use model
	var $uses = false;

	public $helpers = array('TinymceElfinder.TinymceElfinder');
	public $components = array('TinymceElfinder.TinymceElfinder');
	
/*
 * authorization
 * 
 */
	public function isAuthorized($user) {
	    // only admin can do 
	    if (isset($user['role']) && $user['role'] === 'admin' ){
	    	return true;
	    }

	    return parent::isAuthorized($user);
	}
/*
* beforeFilter
*/
    public function beforeFilter(){
        parent::beforeFilter();
    }


/**
 * index
 *
 * @return void
 */
	public function index(){
		$this->layout = 'question_bank';

		$this->set('title_for_layout',__("Admin"));
		
	}

/**
 * insert questions
 *
 * @return void
 */
	public function insertQuestions(){
		$this->layout = 'question_bank';
		$this->set('title_for_layout',__("Add questions"));		

		if($this->request->is('post')){
			pr($this->request->data);
		}
	}
/**
 * upload file
 *
 * @return void
 */
	public function uploadFile(){
		$this->autoRender = false();
		if( $this->request->is('post')){
			pr($this->data);
			return 'hi';
		}
	}	

	public function elfinder() {
        $this->TinymceElfinder->elfinder();
    }
    public function connector() {
        $this->TinymceElfinder->connector();
    }	

}
?>