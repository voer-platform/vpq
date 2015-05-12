<?php
App::uses('AppController', 'Controller');
/**
 * Questions Controller
 *
 * @property Question $Question
 * @property PaginatorComponent $Paginator
 */
class CardStatisticsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function isAuthorized($user) {
		// user can logout, dashboard, progress, history, suggest
		if (isset($user['role']) && $user['role'] === 'admin' ){
			if( in_array( $this->request->action, array('index'))){
				return true;
			}
		}
		return parent::isAuthorized($user);
	}
	/**
 * index method
 *
 * @return void
 */
	public function index() {
		$conditions = array();
		if(isset($this->request->query['filter']))
		{
			if($this->request->query['from'])
			{
				$conditions[] = "DATE(RechargeLog.time) >= DATE(STR_TO_DATE('".$this->request->query['from']."', '%d/%m/%Y'))";
				$this->set('from', $this->request->query['from']);
			}
			if($this->request->query['to'])
			{
				$conditions[] = "DATE(RechargeLog.time) <= DATE(STR_TO_DATE('".$this->request->query['to']."', '%d/%m/%Y'))";
				$this->set('to', $this->request->query['to']);
			}
			if($this->request->query['card_type'])
			{
				$conditions['RechargeLog.card_type_id'] = $this->request->query['card_type'];
				$this->set('card_type', $this->request->query['card_type']);
			}
			if($this->request->query['price'])
			{
				$conditions['RechargeLog.price'] = $this->request->query['price'];
				$this->set('cprice', $this->request->query['price']);
			}
		}
		$this->loadModel('RechargeLog');
		//$this->RechargeLog->virtualFields['_additional_coin'] = 'ROUND(Question.time/Question.count, 2)';
		$this->Paginator->settings = array(
							'RechargeLog'	=>	array(
								//'escape'=>true,
								'conditions'=>$conditions
							)	
						);	
		$this->set('statistics', $this->Paginator->paginate('RechargeLog'));
		//pr($this->RechargeLog->getDataSource()->getLog(false, false));
		$this->loadModel('CardType');
		$cardtypes = $this->CardType->find('list');
		$this->set('cardtypes', $cardtypes);
		
		$this->loadModel('ExchangeRate');
		$exchanges = $this->ExchangeRate->find('all');
		$this->set('exchanges', $exchanges);
		
	}

}	