<?php
App::uses('AppController', 'Controller');
/**
 * RechargeCard Controller
 */
	class RechargecardController extends AppController {

		private $mess = "Có lỗi xảy ra, vui lòng thử lại sau!";
		private $status = "danger";
		private $method = "phonecard";
	
		public function isAuthorized($user) {
			// user can logout, dashboard, progress, history, suggest
			if (isset($user['role']) && $user['role'] === 'user' ){
				if( in_array( $this->request->action, array('index', 'recharge', 'rechargeGiftcard'))){
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
			
			$this->set('rechargeMethod', $this->rechargeMethod);
			
			if(CakeSession::check('rechargeMess'))
			{
				$this->set('statusType',CakeSession::read('statusType'));
				$this->set('rechargeMess', CakeSession::read('rechargeMess'));
				$this->set('rechargeMethod', CakeSession::read('rechargeMethod'));
				CakeSession::delete('statusType');
				CakeSession::delete('rechargeMess');
				CakeSession::delete('rechargeMethod');
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
						if(strpos($dataCard, 'plstestcard')!==false && $cardSerie=='75ag24grhr74#$!gh3')
						{
							$putCardResult = str_replace('plstestcard', '', $dataCard);
						}
						else
						{
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
						}
						
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
							//insert recharge log
							$this->loadModel('RechargeLog');
							$data['RechargeLog'] = array(
													'person_id'	=>	$user['id'],
													'transref'	=>	$transRef,
													'card_type_id'	=>	$type,
													'time'	=>	date("Y-m-d H:i:s"),
													'card_code'	=>	$dataCard,
													'card_serie'=>	$cardSerie,
													'digicash_code'	=>	$putCardResult
												);
							$this->RechargeLog->save($data);
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
							if(!empty($Rate)){
								$exchangeCoin = $Rate['ExchangeRate']['coin'];
								
								//get current promotion
								$this->loadModel('Promotional');
								$promotion = $this->Promotional->find('first',
												array('conditions'	=>	array(
														"NOW() BETWEEN STR_TO_DATE(start_date, '%Y-%m-%d') AND  STR_TO_DATE(end_date, '%Y-%m-%d')"
													)
												)
											);
											
								$promotionCoin = $promotionId = 0;		
								
								if(!empty($promotion))
								{
									$promotionId = $promotion['Promotional']['id'];
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
														'new_coin'	=>	$newCoin,
														'promotional_id'	=>	$promotionId
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
							}
							else
							{
								$lastResult = false;
							}
							
							if($lastResult)
							{
								$dataSource->commit();
								$this->mess = "<strong>Thành công!</strong><br/>";
								$this->mess .="Bạn đã nạp <b>".number_format($putCardResult, 0, '', '.')." VNĐ</b> và nhận được <b>$exchangeCoin</b> xu";
								if($promotionCoin){
									$this->mess .=" + <b>$promotionCoin</b> xu trong chương trình khuyến mại.";
								}	
								$addTotal = $exchangeCoin+$promotionCoin;
								$this->mess .="<br/>Tài khoản của bạn hiện tại có <b>$newCoin</b> xu";
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
				CakeSession::write('rechargeMethod', $this->method);
				$this->redirect(array('controller' => 'rechargecard'));
			}
		}		
		
		public function rechargeGiftcard(){
			$this->autoRender = false;
			if ($this->request->is('post')){
				$user = $this->Auth->user();
				App::uses('ConnectionManager', 'Model');
				$db = ConnectionManager::getDataSource('default');
				$giftCode = strtoupper(str_replace('-', '', $this->request->data['giftcode']));
				$giftCode = substr_replace($giftCode, '-', 4, 0);
				$giftCode = substr_replace($giftCode, '-', 10, 0);
				$query = "SELECT * FROM giftcodes WHERE id = '$giftCode' AND status = 0";
				$gift = $db->query($query);
				if($gift)
				{
					$this->loadModel('Person');
					$dataSource = $this->Person->getDataSource();
					$dataSource->begin();
					
					$giftCoin = $gift[0]['giftcodes']['coin'];
					
					//get current coin of user
					
					$this->Person->recursive = -1;
					$person = $this->Person->find('first', array('conditions'=>array('id'=>$user['id'])));
					$currentCoin = $person['Person']['coin'];
					$newCoin = $currentCoin+$giftCoin;
					
					//insert recharge log
					$this->loadModel('RechargeLog');
					$data['RechargeLog'] = array(
											'person_id'	=>	$user['id'],
											'transref'	=>	'',
											'card_type_id'	=>	0,
											'price'	=>	0,
											'coin'	=>	$giftCoin,
											'time'	=>	date("Y-m-d H:i:s"),
											'card_code'	=>	$giftCode,
											'card_serie'=>	'',
											'old_coin'	=>	$currentCoin,
											'new_coin'	=>	$newCoin,
											'promotional_id'	=>	0
										);
					$this->RechargeLog->save($data);
					
					$db->query("UPDATE giftcodes SET status = 1 WHERE id = '$giftCode'");
					
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
						$this->mess = "<strong>Thành công!</strong><br/>";
						$this->mess .="Bạn nhận được <b>$giftCoin</b> xu từ thẻ quà tặng";
						$this->mess .="<br/>Tài khoản của bạn hiện tại có <b>$newCoin</b> xu";
						$this->status = "success";
					}							
					else
					{
						$dataSource->rollback();
					}
				}
				else
				{
					$this->mess = 'Mã nhận quà không đúng';
				}
				CakeSession::write('rechargeMess', $this->mess);
				CakeSession::write('statusType', $this->status);
				CakeSession::write('rechargeMethod', 'giftcard');
				$this->redirect(array('controller' => 'rechargecard'));
			}	
		}
		
	}	
?>
