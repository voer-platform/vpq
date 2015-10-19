<?php
App::uses('AppController', 'Controller');
/**
 * Newsletters Controller
 *
 * @property Newsletter $Newsletter
 * @property PaginatorComponent $Paginator
 */
class AnnouncementsController extends AppController {

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
	
		if ($this->request->is(array('post', 'put'))) {
		
			$updateData = $this->request->data;
			
			if ($this->Announcement->save($updateData)) {
				$this->Session->setFlash(__('The announcement has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The announcement could not be saved. Please, try again.'));
			}
		}
	
		$this->Announcement->recursive = 0;
		$this->request->data = $this->Announcement->find('first');
	}

}
