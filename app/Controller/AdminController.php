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
	    if (isset($user['role']) && $user['role'] === 'editor' ){
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
		$this->set('title_for_layout',__("Admin"));
		
	}

/**
 * insert questions
 *
 * @return void
 */
	public function insertQuestions(){
		$this->set('title_for_layout',__("Add questions"));

		$this->loadModel('Question');

		if($this->request->is('post')){
			$path = WWW_ROOT. DS . 'files';
			if(isset($this->request->data['Attachment'])){
				foreach($this->request->data['Attachment'] as $key => $value){
					$newName = date('YmdHisu').'-'.$key.'.jpg';
					move_uploaded_file($value['tmp_name'], $path.DS.$newName);
					$this->request->data['Attachment'][$key] = array(
						'path' => Router::url('/', true).'files'.'/'.$newName
						);
				}
			}
			foreach ($this->request->data['Answer'] as $key => $answer) {
				$this->request->data['Answer'][$key]['order'] = $key;
			}
			$this->Question->create();
			if ($this->Question->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The question has been saved.'));
			} else {
				$this->Session->setFlash(__('The question could not be saved. Please, try again.'));
			}
		}
		
		$subcategories = $this->Question->Subcategory->find('list', array('order' => array('Subcategory.id ASC')));
		$tests = $this->Question->Test->find('list');
		$this->set(compact('subcategories', 'tests'));
	}

/**
 * elfinder
 *
 * @return void
 */
	public function elfinder() {
        $this->TinymceElfinder->elfinder();
    }

/**
 * connector for elfindier
 *
 * @return void
 */ 
    public function connector() {
        $this->TinymceElfinder->connector();
    }

/**
 * insert multiple questions
 *
 * @return void
 */
	public function insertMultipleQuestions(){
		$this->set('title_for_layout',__("Add multiple questions"));

		if($this->request->is('post')){
			// unzip file
			$file = $this->request->data['Import']['file']['tmp_name'];
			$filename = $this->request->data['Import']['file']['name'];
			$filename = substr($filename, 0, strrpos($filename, '.'));

			$path = pathinfo(realpath($file), PATHINFO_DIRNAME).DS.microtime(true);

			$zip = new ZipArchive;
			$res = $zip->open($file);

			// open OK
			if ($res === TRUE) {
				// extract it to the path we determined above
				$zip->extractTo($path);
				$zip->close();

				// read data file extract at path/filename
				$data = file_get_contents($path.DS.$filename.DS.'data.txt');

				// process data
				$this->loadModel('Question');
				$result = $this->Question->processMassImport($data, $path.DS.$filename);

				if($result){
					$this->Session->setFlash(__('Import success. Please verify in manage question list.'));
				}
				else{
					$this->Session->setFlash(__('Import Fail. Please verify in manage question list.'));
				}

			} else {
				$this->Session->setFlash(__('The imported data could not be process, please try again later.'));
			}

			
		}
	}

}
