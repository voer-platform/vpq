<?php
App::uses('AppController', 'Controller');
/**
 * RechargeCard Controller
 */
	class RechargecardController extends AppController {

		private $mess = "Có lỗi xảy ra, vui lòng thử lại sau!";
		private $status = "danger";
	
		public function isAuthorized($user) {
			// user can logout, dashboard, progress, history, suggest
			if (isset($user['role']) && $user['role'] === 'user' ){
				if( in_array( $this->request->action, array('index', 'recharge'))){
					return true;
				}
			} elseif (isset($user['role']) && $user['role'] === 'editor') {
				if( in_array( $this->request->action, array('recharge'))){
					return true;
				}
			}

			return parent::isAuthorized($user);
		}
	
		public function index(){
			$this->loadModel('CardType');
			$CardTypes = $this->CardType->find('all', array('conditions'=>array('enabled'=>1)));
			$this->set('CardTypes', $CardTypes);
			
			$this->loadModel('ExchangeRate');
			$rates = $this->ExchangeRate->find('all', array('order'=>array('coin'=>'ASC')));
			$this->set('exchangeRates', $rates);
			
			$this->loadModel('Promotional');
			$promotion = $this->Promotional->find('first',
							array('conditions'	=>	array(
									"NOW() BETWEEN STR_TO_DATE(start_date, '%Y-%m-%d') AND  STR_TO_DATE(end_date, '%Y-%m-%d')"
								)
							)
						);
			if(!empty($promotion))
			{
				$this->set('promotion', $promotion['Promotional']);
			}
			
			if(CakeSession::check('rechargeMess'))
			{
				$this->set('statusType',CakeSession::read('statusType'));
				$this->set('rechargeMess', CakeSession::read('rechargeMess'));
				CakeSession::delete('statusType');
				CakeSession::delete('rechargeMess');
			}
		}
	
		public function recharge(){
			$this->autoRender = false;
			if ($this->request->is('post')){
				$this->loadModel('CardType');
				$data = $this->request->data;
				$type = $data['type'];
				
				$telco = $this->CardType->find('first', array('conditions'=>array('id'=>$type)));
				if(!empty($telco))
				{
					Configure::load('Digicash');
					$user = $this->Auth->user();
					$telcoName = $telco['CardType']['code'];
					$dataCard = $data['code'];
					$cardSerie = $data['seri'];
					$transRef = $user['id']."-$type-".time();
					$userName = Configure::read('Digicash.userName');
					$userPass = Configure::read('Digicash.userPass');
					$secretKey = Configure::read('Digicash.secretKey');
					$checkSum = md5($userName.md5($userPass).$telcoName.$dataCard.$cardSerie.$transRef.$secretKey);
					
					try {
						$url = Configure::read('Digicash.Url');
						$opts = array(
							'http'=>array(
								'user_agent' => 'PHPSoapClient'
								)
						);

						$context = stream_context_create($opts);
						$client     = new SoapClient($url, 
													array(
														'stream_context' => $context,
														'cache_wsdl' => WSDL_CACHE_NONE, 
														"trace" => 1, 
														"exception" => 0
													)
												); 

						$result = $client->PutCard(array( 
														'telcoName'	=>	$telcoName,
														'dataCard'	=>	$dataCard,
														'cardSerie'	=>	$cardSerie,
														'transRef'	=>	$transRef,
														'userName'	=>	$userName,
														'userPass'	=>	md5($userPass),
														'checkSum'	=>	$checkSum
													) 
						);
						$putCardResult = $result->PutCardResult;
						
						if($putCardResult<0)
						{
							switch($putCardResult){
								case '-4000':	$this->mess = "Mã thẻ không đúng hoặc đã được sử dụng"; break;
								case '-4003':	$this->mess = "Thẻ đã được sử dụng"; break;
								case '-4004':	$this->mess = "Thẻ đã bị khóa, không sử dụng được"; break;
								case '-4005':	$this->mess = "Thẻ đã hết hạn sử dụng"; break;
								case '-4006':	$this->mess = "Thẻ chưa kích hoạt"; break;
								case '-4007':	$this->mess = "Bạn đã nạp sai mã thẻ quá số lần cho phép"; break;
								case '-4020':	$this->mess = "Mã thẻ không đúng"; break;
								case '-4023':	$this->mess = "Số serie không đúng"; break;
								case '-4024': 	$this->mess = "Mã thẻ và số serie không đúng"; break;
								case '-4028': 	$this->mess = "Mã thẻ không đúng định dạng"; break;
								default		:	$this->mess  = "Có lỗi xảy ra, vui lòng thử lại sau!";
							}
						}
						else
						{
							$this->loadModel('Person');
							$dataSource = $this->Person->getDataSource();
							$dataSource->begin();
							
							$price = $putCardResult;
							
							//get current coin of user
							
							$this->Person->recursive = -1;
							$person = $this->Person->find('first', array('conditions'=>array('id'=>$user['id'])));
							$currentCoin = $person['Person']['coin'];
							
							//get exchange rate
							$this->loadModel('ExchangeRate');
							$Rate = $this->ExchangeRate->find('first', array('conditions'=>array('price'=>$price)));
							$exchangeCoin = $Rate['ExchangeRate']['coin'];
							
							//get current promotion
							$this->loadModel('Promotional');
							$promotion = $this->Promotional->find('first',
											array('conditions'	=>	array(
													"NOW() BETWEEN STR_TO_DATE(start_date, '%Y-%m-%d') AND  STR_TO_DATE(end_date, '%Y-%m-%d')"
												)
											)
										);
										
							$promotionCoin = 0;			
							if(!empty($promotion))
							{
								$promotionPercent = $promotion['Promotional']['percent'];
								$promotionCoin = $exchangeCoin*($promotionPercent/100);
							}
							$newCoin = $currentCoin+$exchangeCoin+$promotionCoin;
							
							
							
							
							
							
							//insert recharge log
							$this->loadModel('RechargeLog');
							$data['RechargeLog'] = array(
													'person_id'	=>	$user['id'],
													'transref'	=>	$transRef,
													'card_type_id'	=>	$type,
													'price'	=>	$price,
													'coin'	=>	$exchangeCoin,
													'time'	=>	date("Y-m-d H:i:s"),
													'card_code'	=>	$dataCard,
													'card_serie'=>	$cardSerie,
													'old_coin'	=>	$currentCoin,
													'new_coin'	=>	$newCoin
												);
							$this->RechargeLog->save($data);
							
							//update user coin
							$lastResult = $this->Person->updateAll(
											array(
												'coin'	=>	$newCoin
											),
											array(
												'Person.id'	=>	$user['id']
											)
										);
		
							if($lastResult)
							{
								$dataSource->commit();
								$this->mess = "Bạn đã nạp thẻ thành công";
								$this->status = "success";
							}							
							else
							{
								$dataSource->rollback();
							}	
						}
						
					} catch (SoapFault $exception) {
						//echo $exception->getMessage();
					}
				}	
				
				CakeSession::write('rechargeMess', $this->mess);
				CakeSession::write('statusType', $this->status);
				$this->redirect(array('controller' => 'rechargecard'));
			}
		}		
		
	}	
?>
