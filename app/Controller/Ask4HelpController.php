<?php
App::uses('AppController', 'Controller');

class Ask4HelpController extends AppController {
    //public function beforeFilter(){
    //      parent::beforeFilter();
    //      $this->Auth->allow('display', 'index');
    //}

    public function isAuthorized($user) {
        // user can logout, dashboard, progress, history, suggest
        if (isset($user['role']) && $user['role'] === 'user' ){
            if( in_array( $this->request->action, array('index'))){
                    return true;
            }
        }
  
        return parent::isAuthorized($user);
    }

    public function index($qid) {
        $this->loadModel('Question');
        $this->loadModel('Explanation');
  
        if ($this->request->is('post')) {
            $this->Explanation->create();
            if ($this->Explanation->save($this->request->data)) {
                $this->Session->setFlash(__('Your answer has been saved.'));
                $this->request->data = array();
            }
            else {
                $this->Session->setFlash(__('Unable to add your answer.'));
            }
        }

        $question = $this->Question->find('first', array(
            'conditions' => array('id' => $qid)
        ));
        $explanations = $this->Explanation->find('all', array( 
            'conditions' => array('question_id' => $qid)
        ));
  
        $this->set('questionData', $question);
        $this->set('explanationsData', $explanations);
    }
}
