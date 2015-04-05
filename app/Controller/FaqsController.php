<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Faqs Controller
 *
 * @property Faq $Faq
 * @property PaginatorComponent $Paginator
 */
class FaqsController extends AppController {

	public function beforeFilter(){
          parent::beforeFilter();
    }

    public function isAuthorized($user) {
        // user can logout, dashboard, progress, history, suggest
        if (isset($user['role']) && $user['role'] === 'user' ){
            if( in_array( $this->request->action, array('userIndex', 'userAdd'))){
                    return true;
            }
        }

        if (isset($user['role']) && $user['role'] === 'editor' ){
            return true;
        }
  
        return parent::isAuthorized($user);
    }

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
		$this->Faq->recursive = 0;
		$this->set('faqs', $this->Paginator->paginate());
	}	

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Faq->exists($id)) {
			throw new NotFoundException(__('Invalid faq'));
		}
		$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
		$this->set('faq', $this->Faq->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Faq->create();
			if ($this->Faq->save($this->request->data)) {
				$this->Session->setFlash(__('The faq has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faq could not be saved. Please, try again.'));
			}
		}
		$people = $this->Faq->Person->find('list');
		$this->set(compact('people'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Faq->exists($id)) {
			throw new NotFoundException(__('Invalid faq'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Faq']['date_answered'] = date('Y-m-d h:i:s');
			if($this->request->data['Faq']['answer'] != ''){
				$this->request->data['Faq']['status'] = 'answered';
			}
			if ($this->Faq->save($this->request->data)) {
				$this->Session->setFlash(__('The faq has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The faq could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
			$this->request->data = $this->Faq->find('first', $options);
		}
		$people = $this->Faq->Person->find('list');
		$this->set(compact('people'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Faq->id = $id;
		if (!$this->Faq->exists()) {
			throw new NotFoundException(__('Invalid faq'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Faq->delete()) {
			$this->Session->setFlash(__('The faq has been deleted.'));
		} else {
			$this->Session->setFlash(__('The faq could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * user list
 *
 */ 
	public function userIndex(){
		$this->set('title_for_layout', __("Faq"));

		$this->Faq->recursive = 0;
		$this->set('faqs', $this->Paginator->paginate());
	}

/**
 * user add
 *
 */	
	public function userAdd(){
		$this->layout = 'ajax';
		$this->autoLayout = false;
        $this->autoRender = false;

		if ($this->request->is('post')) {
			$this->Faq->create();
			$this->Faq->data['Faq']['person_id'] = $this->request->data['person_id'];
			$this->Faq->data['Faq']['content'] = $this->request->data['content'];
			$this->Faq->data['Faq']['date_created'] = date('Y-m-d h:i:s');

			if ($this->Faq->save($this->Faq->data)) {
				echo __("Submit success!");

				// email to notify
				$Email = new CakeEmail('gmail');
				$Email->from(array('pls@dev.pls.edu.vn' => 'Dev PLS'))
				    ->to('robberviet@gmail.com')
				    ->subject('Question submitted at PLS')
				    ->send("A new questions has been submitted at PLS. Please answer it.\n\nThe question: ".$this->request->data['content']);

			} else {
				echo __("Submit failed. Try again leter.");
			}
		}
	}
}
