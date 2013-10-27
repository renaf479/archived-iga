<?php
App::uses('AppModel', 'Model');
class UserEmailRecipient extends AppModel {
	/**
	 * This model has following models
	 *
	 * @var array
	 */
	var $belongsTo = array('User');
}