<?php
App::uses('AppController', 'Controller');
/**
 * Tests Controller
 *
 * @property Test $Test
 * @property PaginatorComponent $Paginator
 */
class ExpsController extends AppController {

    public $uses = array('Test', 'Grade', 'Category', 'Subcategory', 'Tracking','Question');
    /*
     * authorization
     *
     */
    public function isAuthorized($user) {
        // user can logout, dashboard, progress, history, suggest
        if (isset($user['role']) && $user['role'] === 'user' ){
            if( in_array( $this->request->action, array('chooseTest', 'doTest', 'score', 'byQuestion','timeQuestion'))){
                return true;
            }
        } elseif (isset($user['role']) && $user['role'] === 'editor' ){
            return true;
        }

        return parent::isAuthorized($user);
    }
    /**
     * beforeFilter
     *
     */
    public function beforeFilter(){
        parent::beforeFilter();

        $this->Auth->allow('sampleTest', 'score');
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
		$this->loadModel('Person');
		$this->loadModel('Score');
		$this->loadModel('Progress');
		if($this->Session->read('Auth.User')['role']== 'admin'){			
			$data=$this->Progress->query(
										"SELECT person_id, Sum(progress) as correct, Sum(total)-Sum(progress) as wrong FROM `progresses` Group by person_id"
										);
			foreach($data as $dt){
				$exp=$dt[0]['correct']-$dt[0]['wrong'];
				if($exp<0){
					$exp=0;
				}
				$this->Person->id=$dt['progresses']['person_id'];
				$this->Person->save(
									array(
											'exp'=>$exp,
									)
				);
			};
			
			$calculateExp=$this->Score->calculateExp();
			$this->loadModel('Exp');
			$table_exp=$this->Exp->find('all');
			if($table_exp==null){
				foreach($calculateExp as $cal){
					$this->Exp->create();
					$this->Exp->save(
											array(
													'person_id'=>$cal['scores']['person_id'],
													'correct'  =>$cal['0']['correct'],
													'wrong'	   =>$cal['0']['wrong'],
													'exp'	   =>$cal['0']['exp'],
													'date'	   =>$cal['0']['date'],
											)
					);
				};
			}
			
			$calculateExpSubject=$this->Score->calculateExpSubject();
			$this->loadModel('ExpSubject');
			$table_exp=$this->ExpSubject->find('all');
			if($table_exp==null){
				foreach($calculateExpSubject as $cal){
					$this->ExpSubject->create();
					$this->ExpSubject->save(
											array(
													'person_id'=>$cal['scores']['person_id'],
													'subject_id'=>$cal['tests_subjects']['subject_id'],
													'correct'  =>$cal['0']['correct'],
													'wrong'	   =>$cal['0']['wrong'],
													'exp'	   =>$cal['0']['exp'],
													'date'	   =>$cal['0']['date'],
											)
					);
				};
			}
		}
		
		$this->redirect(array('controller' => 'people', 'action' => 'dashboard'));
    }

}
