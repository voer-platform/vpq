<?php
App::uses('AppController', 'Controller');
/**
 * Newsletters Controller
 *
 * @property Newsletter $Newsletter
 * @property PaginatorComponent $Paginator
 */
class NewslettersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Newsletter->recursive = 0;
		$this->set('newsletters', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Newsletter->exists($id)) {
			throw new NotFoundException(__('Invalid newsletter'));
		}
		$options = array('conditions' => array('Newsletter.' . $this->Newsletter->primaryKey => $id));
		$this->set('newsletter', $this->Newsletter->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Newsletter->create();
			
			$insertData = $this->request->data;
			$insertData['Newsletter']['slug'] = $this->makeSlug($insertData['Newsletter']['title']);
			
			if ($this->Newsletter->save($insertData)) {
				$this->Session->setFlash(__('The newsletter has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newsletter could not be saved. Please, try again.'));
			}
		}
		$newsletterCategories = $this->Newsletter->NewsletterCategory->find('list');
		$this->set(compact('newsletterCategories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Newsletter->exists($id)) {
			throw new NotFoundException(__('Invalid newsletter'));
		}
		if ($this->request->is(array('post', 'put'))) {
		
			$updateData = $this->request->data;
			$updateData['Newsletter']['slug'] = $this->makeSlug($updateData['Newsletter']['title']);

			if ($this->Newsletter->save($updateData)) {
				$this->Session->setFlash(__('The newsletter has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newsletter could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Newsletter.' . $this->Newsletter->primaryKey => $id));
			$this->request->data = $this->Newsletter->find('first', $options);
		}
		$newsletterCategories = $this->Newsletter->NewsletterCategory->find('list');
		$this->set(compact('newsletterCategories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Newsletter->id = $id;
		if (!$this->Newsletter->exists()) {
			throw new NotFoundException(__('Invalid newsletter'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Newsletter->delete()) {
			$this->Session->setFlash(__('The newsletter has been deleted.'));
		} else {
			$this->Session->setFlash(__('The newsletter could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	function makeSlug($str)
	{ 
		$unicode = array( 
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ', 
		'd'=>'đ', 
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ', 
		'i'=>'í|ì|ỉ|ĩ|ị', 
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ', 
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự', 
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ', 
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ', 
		'D'=>'Đ', 
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ', 
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị', 
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ', 
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự', 
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ', 
		); 
		foreach($unicode as $nonUnicode=>$uni){ 
		$str = preg_replace("/($uni)/i", $nonUnicode, $str); 
		} 
		
		$replace = '-';         
        $str = strtolower($str);     
 
        //replace / and . with white space     
        $str = preg_replace("/[\/\.]/", " ", $str);     
        $str = preg_replace("/[^a-z0-9_\s-]/", "", $str);     
 
        //remove multiple dashes or whitespaces     
        $str = preg_replace("/[\s-]+/", " ", $str);     
 
        //convert whitespaces and underscore to $replace     
        $str = preg_replace("/[\s_]/", $replace, $str);     
		
		return $str; 
	}
	
}
