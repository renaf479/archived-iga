<?php
App::uses('AppController', 'Controller');
class UserEmailsController extends AppController {
	/**
	 * This controller uses following models
	 *
	 * @var array
	 */
	public $uses = array('Usermgmt.UserEmail', 'Usermgmt.UserEmailRecipient', 'Usermgmt.User', 'Usermgmt.UserGroup', 'Usermgmt.UserContact', 'Usermgmt.UserEmailTemplate', 'Usermgmt.UserEmailSignature');
	/**
	 * This controller uses following components
	 *
	 * @var array
	 */
	public $components = array('RequestHandler', 'Usermgmt.Search');
	/**
	 * This controller uses following helpers
	 *
	 * @var array
	 */
	public $helpers = array('Js', 'Usermgmt.Tinymce', 'Usermgmt.Ckeditor');
	/**
	 * This controller uses following default pagination values
	 *
	 * @var array
	 */
	public $paginate = array(
		'limit' => 25
	);
	/**
	 * This controller uses search filters in following functions for ex index function
	 *
	 * @var array
	 */
	var $searchFields = array
		(
			'index' => array(
				'UserEmail' => array(
					'UserEmail'=> array(
						'type' => 'text',
						'label' => 'Search',
						'tagline' => 'Search by subject, message',
						'condition' => 'multiple',
						'searchFields'=>array('UserEmail.subject', 'UserEmail.message'),
						'inputOptions'=>array('style'=>'width:300px;')
					)
				)
			)
		);
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		if(isset($this->Security) &&  $this->RequestHandler->isAjax()){
			$this->Security->csrfCheck = false;
			$this->Security->validatePost = false;
		}
	}
	/**
	 * It displays all sent Emails
	 *
	 * @access public
	 * @return array
	 */
	public function index() {
		$cond = array();
		if (!$this->UserAuth->isAdmin()) {
			$cond['UserEmail.sent_by']=$this->UserAuth->getUserId();
		}
		$this->paginate = array('limit' => 10, 'order'=>'UserEmail.id desc', 'contain'=>'User', 'conditions'=>$cond, 'fields'=>array('UserEmail.*', 'User.first_name', 'User.last_name'));
		$userEmails = $this->paginate('UserEmail');
		foreach($userEmails as $key=>$row) {
			if(!empty($row['UserEmail']['user_group_id'])) {
				$userEmails[$key]['UserEmail']['group_name']=$this->UserGroup->getGroupsByIds($row['UserEmail']['user_group_id']);
			}
		}
		$this->set('userEmails', $userEmails);
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
			$this->render('/Elements/all_emails');
		}
	}
	/**
	 * It is used to send emails to groups, selected users, manual emails
	 *
	 * @access public
	 * @param string $confirm confirm to send emails
	 * @return void
	 */
	public function send($confirm=null) {
		ini_set('memory_limit','256M');
		ini_set('max_execution_time', 5200);
		$confirmRender=false;
		if ($this->request->isPost()) {
			$this->UserEmail->set($this->request->data);
			$sendValidate = $this->UserEmail->sendValidate();
			if($this->RequestHandler->isAjax()) {
				$this->layout = 'ajax';
				$this->autoRender = false;
				if ($sendValidate) {
					$response = array('error' => 0, 'message' => 'success');
					return json_encode($response);
				} else {
					$response = array('error' => 1,'message' => 'failure');
					$response['data']['UserEmail']  = $this->UserEmail->validationErrors;
					return json_encode($response);
				}
			} else {
				if ($sendValidate) {
					$users = array();
					if(is_null($confirm)) {
						if($this->request->data['UserEmail']['type']=='GROUPS') {
							$groupIds = $this->request->data['UserEmail']['user_group_id'];
							$cond = array();
							$cond['User.active']=1;
							$groupCond=array();
							foreach($groupIds as $groupId) {
								$groupCond[] = array('User.user_group_id'=>$groupId);
								$groupCond[] = array('User.user_group_id like'=>$groupId.',%');
								$groupCond[] = array('User.user_group_id like'=>'%,'.$groupId.',%');
								$groupCond[] = array('User.user_group_id like'=>'%,'.$groupId);
							}
							$cond['OR'] = $groupCond;
							$usersCount = $this->User->find('count', array('conditions'=>$cond, 'fields'=>array('User.id', 'User.first_name', 'User.last_name'), 'order'=>array('User.first_name')));

							$users = $this->User->find('all', array('conditions'=>$cond, 'fields'=>array('User.id', 'User.first_name', 'User.last_name', 'User.email'), 'order'=>array('User.first_name')));
						} else if($this->request->data['UserEmail']['type']=='USERS') {
							$this->request->data['UserEmail']['user_group_id']=null;
							$users = $this->User->find('all', array('conditions'=>array('User.id'=>$this->request->data['UserEmail']['user_id']), 'fields'=>array('User.id', 'User.first_name', 'User.last_name', 'User.email'), 'order'=>array('User.first_name')));
						} else if($this->request->data['UserEmail']['type']=='MANUAL') {
							$this->request->data['UserEmail']['user_group_id']=null;
							$emails = explode(',', strtolower($this->request->data['UserEmail']['to_email']));
							$emails = array_filter(array_map('trim', $emails));
							$i=0;
							foreach($emails as $email) {
								$users[$i]['User']['email']=$email;
								$users[$i]['User']['id']=null;
								$users[$i]['User']['first_name']=null;
								$users[$i]['User']['last_name']=null;
								$i++;
							}
						}
					} else if($confirm=='confirm') {
						$i=0;
						foreach($this->request->data['email'] as $row) {
							if(isset($row['emailcheck']) && !empty($row['email'])) {
								$users[$i]['User']['email']=$row['email'];
								$users[$i]['User']['id']=$row['uid'];
								$i++;
							}
						}
					}
					if(!empty($users)) {
						if(is_null($confirm)) {
							$this->Session->write('send_email_data', $this->request->data);
							$this->set('data', $this->request->data);
							$template=$this->UserEmailTemplate->getTemplateById($this->request->data['UserEmail']['template']);
							$signature=$this->UserEmailSignature->getSignatureById($this->request->data['UserEmail']['signature']);
							$this->set(compact('users', 'template', 'signature'));
							$confirmRender=true;
						} else if($confirm=='confirm') {
							$data = $this->Session->read('send_email_data');
							$sent = $this->sendAndSaveUserEmail($data, $users);
							if($sent) {
								$this->Session->delete('send_email_data');
								$this->redirect(array('action'=>'index'));
							} else {
								$this->redirect(array('action'=>'send'));
							}
						}
					} else {
						if($this->request->data['UserEmail']['type']=='GROUPS') {
							$this->Session->setFlash('No users found in selected group', 'default', array('class' => 'warning'));
						}
					}
				}
			}
		} else {
			$this->request->data['UserEmail']['from_name'] = EMAIL_FROM_NAME;
			$this->request->data['UserEmail']['from_email'] = EMAIL_FROM_ADDRESS;
			if($this->Session->check('send_email_data')) {
				$this->request->data = $this->Session->read('send_email_data');
				$this->Session->delete('send_email_data');
			}
		}
		$groups = $this->UserGroup->getGroups();
		unset($groups['']);
		$sel_users=array();
		if(!empty($this->request->data['UserEmail']['user_id'])) {
			$sel_users = $this->User->getAllUsersWithUserIds($this->request->data['UserEmail']['user_id']);
		}
		$templates = $this->UserEmailTemplate->getTemplates();
		$signatures = $this->UserEmailSignature->getSignatures();
		$this->set(compact('groups', 'sel_users', 'templates', 'signatures'));
		if($confirmRender) {
			$this->render('send_confirm');
		}
	}
	/**
	 * It is used to send email to user
	 *
	 * @access public
	 * @param integer $userId user id of user
	 * @return void
	 */
	public function sendToUser($userId=null, $confirm=null) {
		$confirmRender=false;
		$page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1;
		$name=$this->User->getNameById($userId);
		$email=$this->User->getEmailById($userId);
		if ($this->request->isPost()) {
			$this->UserEmail->set($this->request->data);
			$sendValidate = $this->UserEmail->sendValidate();
			if($this->RequestHandler->isAjax()) {
				$this->layout = 'ajax';
				$this->autoRender = false;
				if ($sendValidate) {
					$response = array('error' => 0, 'message' => 'success');
					return json_encode($response);
				} else {
					$response = array('error' => 1,'message' => 'failure');
					$response['data']['UserEmail']  = $this->UserEmail->validationErrors;
					return json_encode($response);
				}
			} else {
				if ($sendValidate) {
					if(is_null($confirm)) {
						$this->Session->write('send_user_email_data', $this->request->data);
						$this->set('data', $this->request->data);
						$template=$this->UserEmailTemplate->getTemplateById($this->request->data['UserEmail']['template']);
						$signature=$this->UserEmailSignature->getSignatureById($this->request->data['UserEmail']['signature']);
						$this->set(compact('template', 'signature'));
						$confirmRender=true;
					} else if($confirm=='confirm') {
						$data = $this->Session->read('send_user_email_data');
						$data['UserEmail']['type']='USERS';
						$users = array();
						$users[0]['User']['id'] = $userId;
						$users[0]['User']['email'] = $data['UserEmail']['to'];
						$sent = $this->sendAndSaveUserEmail($data, $users);
						if($sent) {
							$this->Session->delete('send_user_email_data');
							if($sent) {
								$this->redirect(array('controller'=>'Users', 'action'=>'index', 'page'=>$page));
							}
						} else {
							$this->redirect(array('action'=>'sendToUser', $userId));
						}
					}
				}
			}
		} else {
			$this->request->data['UserEmail']['from_name'] = EMAIL_FROM_NAME;
			$this->request->data['UserEmail']['from_email'] = EMAIL_FROM_ADDRESS;
			if($this->Session->check('send_user_email_data')) {
				$this->request->data = $this->Session->read('send_user_email_data');
				$this->Session->delete('send_user_email_data');
			}
		}
		$templates = $this->UserEmailTemplate->getTemplates();
		$signatures = $this->UserEmailSignature->getSignatures();
		$this->set(compact('userId', 'name', 'email', 'templates', 'signatures'));
		if($confirmRender) {
			$this->render('send_to_user_confirm');
		}
	}
	private function sendAndSaveUserEmail($data, $users) {
		$data['UserEmail']['sent_by'] = $this->UserAuth->getUserId();
		if(!empty($data['UserEmail']['user_group_id'])) {
			sort($data['UserEmail']['user_group_id']);
			$data['UserEmail']['user_group_id'] = implode(',',$data['UserEmail']['user_group_id']);
		}
		$template=$this->UserEmailTemplate->getTemplateById($data['UserEmail']['template']);
		$signature=$this->UserEmailSignature->getSignatureById($data['UserEmail']['signature']);
		$body = '';
		if(!empty($template['UserEmailTemplate']['header'])) {
			$body .= nl2br($template['UserEmailTemplate']['header'])."<br/><br/>";
		}
		$body .= $data['UserEmail']['message'];
		if(!empty($signature['UserEmailSignature']['signature'])) {
			$body .= "<br/>".$signature['UserEmailSignature']['signature'];
		}
		if(!empty($template['UserEmailTemplate']['footer'])) {
			$body .= "<br/>".nl2br($template['UserEmailTemplate']['footer']);
		}
		$data['UserEmail']['message'] = $body;
		if($this->UserEmail->save($data)) {
			$fromConfig = $data['UserEmail']['from_email'];
			$fromNameConfig = $data['UserEmail']['from_name'];
			$emailObj = new CakeEmail('default');
			$emailObj->from(array($fromConfig => $fromNameConfig));
			$emailObj->sender(array($fromConfig => $fromNameConfig));
			$emailObj->subject($data['UserEmail']['subject']);

			$emailObj->emailFormat('both');
			$sent=false;
			$i=0;
			$sentEmails = array();
			foreach($users as $user) {
				if(!isset($sentEmails[$user['User']['email']])) {
					$emailObj->to($user['User']['email']);
					$repData=array();
					try{
						$result = $emailObj->send($body);
						if($result) {
							$repData['UserEmailRecipient']['is_email_sent'] = 1;
							$sent=true;
							$i++;
						}
					} catch (Exception $ex){

					}
					$repData['UserEmailRecipient']['user_email_id'] = $this->UserEmail->id;
					$repData['UserEmailRecipient']['user_id'] = $user['User']['id'];
					$repData['UserEmailRecipient']['email_address'] = $user['User']['email'];
					$this->UserEmailRecipient->create();
					$this->UserEmailRecipient->save($repData, false);
					$sentEmails[$user['User']['email']]=$user['User']['email'];
				}
			}
			if(!empty($data['UserEmail']['cc_to'])) {
				$ccEmails = explode(',', strtolower($data['UserEmail']['cc_to']));
				$ccEmails = array_filter(array_map('trim', $ccEmails));
				foreach($ccEmails as $ccEmail) {
					$emailObj->to($ccEmail);
					try{
						$result = $emailObj->send($body);
					} catch (Exception $ex) {

					}
				}
			}
			if($sent) {
				$this->UserEmail->saveField('is_email_sent', 1, false);
				$this->Session->setFlash($i.' Email(s) sent');
				return true;
			} else {
				$this->Session->setFlash('We could not send Email', 'default', array('class' => 'warning'));
				return false;
			}
		} else {
			$this->Session->setFlash('These is some problem in saving data, please try again', 'default', array('class' => 'warning'));
			return false;
		}
	}
	/**
	 * It is used to send reply of contact enquiry
	 *
	 * @access public
	 * @param integer $userContactId user contact id
	 * @return void
	 */
	public function sendReply($userContactId=null, $confirm=null) {
		$confirmRender=false;
		$page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1;
		$contactDetail = $this->UserContact->read(null, $userContactId);
		$name='';
		$email='';
		if(!empty($contactDetail)) {
			$name = $contactDetail['UserContact']['name'];
			$email = $contactDetail['UserContact']['email'];
			if ($this->request->isPost()) {
				$this->UserEmail->set($this->request->data);
				$sendValidate = $this->UserEmail->sendValidate();
				if($this->RequestHandler->isAjax()) {
					$this->layout = 'ajax';
					$this->autoRender = false;
					if ($sendValidate) {
						$response = array('error' => 0, 'message' => 'success');
						return json_encode($response);
					} else {
						$response = array('error' => 1,'message' => 'failure');
						$response['data']['UserEmail']  = $this->UserEmail->validationErrors;
						return json_encode($response);
					}
				} else {
					if ($sendValidate) {
						if(is_null($confirm)) {
							$this->Session->write('send_reply_email_data', $this->request->data);
							$this->set('data', $this->request->data);
							$template=$this->UserEmailTemplate->getTemplateById($this->request->data['UserEmail']['template']);
							$signature=$this->UserEmailSignature->getSignatureById($this->request->data['UserEmail']['signature']);
							$this->set(compact('template', 'signature'));
							$confirmRender=true;
						} else if($confirm=='confirm') {
							$data = $this->Session->read('send_reply_email_data');
							$template=$this->UserEmailTemplate->getTemplateById($data['UserEmail']['template']);
							$signature=$this->UserEmailSignature->getSignatureById($data['UserEmail']['signature']);
							$fromConfig = $data['UserEmail']['from_email'];
							$fromNameConfig = $data['UserEmail']['from_name'];
							$emailObj = new CakeEmail('default');
							$emailObj->from(array($fromConfig => $fromNameConfig));
							$emailObj->sender(array($fromConfig => $fromNameConfig));
							$emailObj->subject($data['UserEmail']['subject']);
							$body = '';
							if(!empty($template['UserEmailTemplate']['header'])) {
								$body .= nl2br($template['UserEmailTemplate']['header'])."<br/><br/>";
							}
							$body .= $data['UserEmail']['message'];
							if(!empty($signature['UserEmailSignature']['signature'])) {
								$body .= "<br/>".$signature['UserEmailSignature']['signature'];
							}
							if(!empty($template['UserEmailTemplate']['footer'])) {
								$body .= "<br/>".nl2br($template['UserEmailTemplate']['footer']);
							}
							$data['UserEmail']['message'] = $body;
							$emailObj->emailFormat('both');
							$sent=false;
							$emailObj->to($data['UserEmail']['to']);
							if(!empty($data['UserEmail']['cc_to'])) {
								$emailObj->cc($data['UserEmail']['cc_to']);
							}
							try{
								$result = $emailObj->send($body);
								if($result) {
									$sent=true;
								}
							} catch (Exception $ex){

							}
							if($sent) {
								$msg = $contactDetail['UserContact']['reply_message'];
								if(empty($msg)) {
									$contactDetail['UserContact']['reply_message'] = 'Reply On '.date('d M Y', time()).' at '.date('h:i A', time()).'<br/>'.$data['UserEmail']['message'];
								} else {
									$contactDetail['UserContact']['reply_message'] = 'Reply On '.date('d M Y', time()).' at '.date('h:i A', time()).'<br/>'.$data['UserEmail']['message'].'<br/><br/>'.$msg;
								}
								$this->UserContact->save($contactDetail, false);
								$this->Session->setFlash('Contact Reply has been sent successfully');
								$this->redirect(array('controller'=>'UserContacts', 'action'=>'index', 'page'=>$page));
							} else {
								$this->Session->setFlash('We could not send Reply Email', 'default', array('class' => 'warning'));
								$this->redirect(array('action'=>'sendReply', $userContactId));
							}
						}
					}
				}
			} else {
				$this->request->data['UserEmail']['from_name'] = EMAIL_FROM_NAME;
				$this->request->data['UserEmail']['from_email'] = EMAIL_FROM_ADDRESS;

				if(!empty($contactDetail)) {
					$this->request->data['UserEmail']['to'] = $contactDetail['UserContact']['email'];
					$this->request->data['UserEmail']['subject'] = 'Re: '.SITE_NAME;
					$this->request->data['UserEmail']['message'] ='<br/><p>-------------------------------------------<br/>
	On '.date('d M Y', strtotime($contactDetail['UserContact']['created'])).' at '.date('h:i A', strtotime($contactDetail['UserContact']['created'])).'<br/>'.h($contactDetail['UserContact']['name']).' wrote:</p>'.$contactDetail['UserContact']['requirement'];
				}
				if($this->Session->check('send_reply_email_data')) {
					$this->request->data = $this->Session->read('send_reply_email_data');
					$this->Session->delete('send_reply_email_data');
				}
			}
		} else {
			$this->Session->setFlash(__('Invalid Id'), 'default', array('class' => 'error'));
			$this->redirect(array('controller'=>'UserContacts', 'action'=>'index', 'page'=>$page));
		}
		$templates = $this->UserEmailTemplate->getTemplates();
		$signatures = $this->UserEmailSignature->getSignatures();
		$this->set(compact('userContactId', 'name', 'email', 'templates', 'signatures'));
		if($confirmRender) {
			$this->render('send_reply_confirm');
		}
	}
	/**
	 * Used to view userEmail on the site by Admin
	 *
	 * @access public
	 * @param integer $userEmailId userEmail id
	 * @return void
	 */
	public function view($userEmailId = null) {
		$page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1;
		if (!empty($userEmailId)) {
			$cond = array();
			$cond['UserEmail.id']= $userEmailId;
			if (!$this->UserAuth->isAdmin()) {
				$cond['UserEmail.sent_by']=$this->UserAuth->getUserId();
			}
			$userEmail = $this->UserEmail->find('first', array('conditions'=>$cond, 'contain'=>array('User'), 'fields'=>array('UserEmail.*', 'User.first_name', 'User.last_name')));
			$userEmailRecipients=array();
			if(!empty($userEmail)) {
				if(!empty($userEmail['UserEmail']['user_group_id'])) {
					$userEmail['UserEmail']['group_name']=$this->UserGroup->getGroupsByIds($userEmail['UserEmail']['user_group_id']);
				}
				$userEmailRecipients = $this->UserEmailRecipient->find('all', array('conditions'=>array('UserEmailRecipient.user_email_id'=>$userEmailId), 'contain'=>array('User'), 'fields'=>array('UserEmailRecipient.*', 'User.first_name', 'User.last_name')));
			} else {
				$this->Session->setFlash('Invalid email id', 'default', array('class' => 'warning'));
				$this->redirect(array('action'=>'index', 'page'=>$page));
			}
			$this->set(compact('userEmail', 'userEmailRecipients'));
		} else {
			$this->Session->setFlash('Invalid email id', 'default', array('class' => 'warning'));
			$this->redirect(array('action'=>'index', 'page'=>$page));
		}
	}
}