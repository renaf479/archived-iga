<?php
App::uses('AppModel', 'Model');
class UserEmail extends AppModel {
	/**
	 * This model has following models
	 *
	 * @var array
	 */
	var $belongsTo = array('User'=>array('foreignKey'=>'sent_by'));
	/**
	 * model validation array
	 *
	 * @var array
	 */
	var $validate = array();
	/**
	 * model validation array
	 *
	 * @var array
	 */
	function sendValidate() {
		$validate1 = array(
				'to'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> __('Please enter to email'),
						'last'=>true),
					'mustEmail'=>array(
						'rule' => 'email',
						'message'=> __('Please enter valid email'),
						'last'=>true)
					),
				'from_name'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> __('Please enter from name'),
						'last'=>true)
					),
				'from_email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> __('Please enter from email'),
						'last'=>true),
					'mustEmail'=>array(
						'rule' => 'email',
						'message'=> __('Please enter valid email'),
						'last'=>true)
					),
				'subject'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> __('Please enter email subject'),
						'last'=>true)
					),
				'message'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> __('Please enter email message'),
						'last'=>true)
					),
				'user_id'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'checkUserSearch',
						'message'=> __('Please select user(s)'),
						'last'=>true)
					),
				'user_group_id'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'checkGroupSearch',
						'message'=> __('Please select group(s)'),
						'last'=>true)
					),
				'to_email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'checkManualEmail',
						'message'=> __('Please enter email(s)'),
						'last'=>true),
					'mustBeEmail'=>array(
						'rule' => 'validateTOEmails',
						'message'=> __('Please enter valid email(s)'),
						'last'=>true)
					),
				'cc_to'=> array(
					'mustBeEmail'=>array(
						'rule' => 'validateEmails',
						'allowEmpty'=>true,
						'message'=> __('Please enter valid email(s)'),
						'last'=>true)
					),
				);
		$this->validate=$validate1;
		return $this->validates();
	}
	function checkUserSearch() {
		if($this->data['UserEmail']['type']=='USERS' && empty($this->data['UserEmail']['user_id'])) {
			return false;
		}
		return true;
	}
	function checkGroupSearch() {
		if($this->data['UserEmail']['type']=='GROUPS' && empty($this->data['UserEmail']['user_group_id'])) {
			return false;
		}
		return true;
	}
	function checkManualEmail() {
		if($this->data['UserEmail']['type']=='MANUAL' && empty($this->data['UserEmail']['to_email'])) {
			return false;
		}
		return true;
	}
	function validateTOEmails($check) {
		if($this->data['UserEmail']['type']=='MANUAL' && !empty($this->data['UserEmail']['to_email'])) {
			return $this->validateEmails($check);
		}
		return true;
	}
	function validateEmails($check) {
		$emails = array_values($check);
		$key = array_keys($check);
		$emails = explode(',', $emails[0]);
		foreach($emails as $email) {
			$email = trim($email);
			if(!empty($email)) {
				$valid = Validation::email($email);
				if(!$valid) {
					$this->validationErrors[$key[0]][0]=__('Please fix the error near').' \''.$email.'\'';
					break;
				}
			}
		}
		return true;
	}
}