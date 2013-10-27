<?php
/*
Cakephp 2.x User Management Premium Version (a product of Ektanjali Softwares Pvt Ltd)
Website- http://ektanjali.com
Plugin Demo- http://umpremium.ektanjali.com
Author- Chetan Varshney (The Director of Ektanjali Softwares Pvt Ltd)
Plugin Copyright No- 11498/2012-CO/L

UMPremium is a copyrighted work of authorship. Chetan Varshney retains ownership of the product and any copies of it, regardless of the form in which the copies may exist. This license is not a sale of the original product or any copies.

By installing and using UMPremium on your server, you agree to the following terms and conditions. Such agreement is either on your own behalf or on behalf of any corporate entity which employs you or which you represent ('Corporate Licensee'). In this Agreement, 'you' includes both the reader and any Corporate Licensee and Chetan Varshney.

The Product is licensed only to you. You may not rent, lease, sublicense, sell, assign, pledge, transfer or otherwise dispose of the Product in any form, on
a temporary or permanent basis, without the prior written consent of Chetan Varshney.

The Product source code may be altered (at your risk)

All Product copyright notices within the scripts must remain unchanged (and visible).

If any of the terms of this Agreement are violated, Chetan Varshney reserves the right to action against you.

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Product.

THE PRODUCT IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE PRODUCT OR THE USE OR OTHER DEALINGS IN THE PRODUCT.
*/

class UserAuthComponent extends Component {
	/**
	 * This component uses following components
	 *
	 * @var array
	 */
	var $components = array('Session', 'Cookie', 'RequestHandler', 'Usermgmt.Ssl', 'Usermgmt.ControllerList');
	/**
	 * configur key
	 *
	 * @var string
	 */
	var $configureKey='User';
	var $cont = null;

	function initialize(Controller $controller) {
		$this->cont = $controller;
	}

	function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
	}

	function startup(Controller $controller = null) {

	}
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @param object $c current controller object
	 * @return void
	 */
	function beforeFilter(&$c) {
		UsermgmtInIt($this);
		if($c->Session->check('UserAuth.loginNotAllowed')) {
			$c->Session->delete('UserAuth.loginNotAllowed');
			$c->Session->setFlash(__('Your account is currently logged in on another computer.'), 'default', array('class' => 'error'));
			$c->redirect(array('plugin' => 'usermgmt', 'controller' => 'Users', 'action' => 'login'));
		}
		$user = $this->__getActiveUser();
		$pageRedirect = $c->Session->read('permission_error_redirect');
		$c->Session->delete('permission_error_redirect');
		$controller = Inflector::camelize($c->params['controller']);
		$action = $c->params['action'];
		$actionUrl = $controller.'/'.$action;
		$requested= (isset($c->params['requested']) && $c->params['requested']==1) ? true : false;
		$permissionFree=array('Users/login', 'Users/logout', 'Users/register', 'Users/userVerification', 'Users/forgotPassword', 'Users/activatePassword', 'pages/display', 'Users/accessDenied', 'Users/emailVerification','Users/ajaxLoginRedirect');
		$allControllers=$this->ControllerList->getControllerWithMethods();
		$errorPage=false;
		if (!in_array($actionUrl, $allControllers)) {
			$errorPage=true;
		}
		if ((empty($pageRedirect) || $actionUrl!='Users/login') && !$requested && !in_array($actionUrl, $permissionFree) && !$errorPage) {
			App::import("Model", "Usermgmt.UserGroup");
			$userGroupModel = new UserGroup;
			$this->updateActivity($c, $actionUrl);
			if (!$this->isLogged()) {
				if (!$userGroupModel->isGuestAccess($controller, $action)) {
					$c->log('permission: actionUrl-'.$actionUrl.' Guest', 'permission');
					$c->Session->write('permission_error_redirect','/users/login');
					$c->Session->setFlash(__('You need to be signed in to view this page.'), 'default', array('class' => 'error'));
					$cUrl = '/'.$c->params->url;
					if(!empty($_SERVER['QUERY_STRING'])) {
						$rUrl = $_SERVER['REQUEST_URI'];
						$pos =strpos($rUrl, $cUrl);
						$cUrl=substr($rUrl, $pos, strlen($rUrl));
					}
					if($c->RequestHandler->isAjax()) {
						$c->Session->write('Usermgmt.OriginAfterLogin', $_SERVER['HTTP_REFERER']);
						$c->redirect('/usermgmt/users/ajaxLoginRedirect');
					}
					$c->Session->write('Usermgmt.OriginAfterLogin', $cUrl);
					$c->redirect(array('plugin' => 'usermgmt', 'controller' => 'Users', 'action' => 'login'));
				}
			} else {
				if (!$userGroupModel->isUserGroupAccess($controller, $action, $this->getGroupId())) {
					$c->log('permission: actionUrl-'.$actionUrl.' UserId-'.$this->getUserId().' GroupName-'.$this->getGroupName(), 'permission');
					$c->Session->write('permission_error_redirect','/users/login');
					$c->redirect(array('plugin' => 'usermgmt', 'controller' => 'Users', 'action' => 'accessDenied'));
				}
			}
		}
	}
	function beforeRender(Controller $c) {
		if(defined('USE_HTTPS') && USE_HTTPS) {
			$this->Ssl->force($c);
		} else {
			$controller = $c->params['controller'];
			$action = $c->params['action'];
			$actionUrl = strtolower($controller.'/'.$action);
			if(defined('HTTPS_URLS')) {
				$httpsUrls= explode(',', strtolower(HTTPS_URLS));
				$httpsUrls = array_map('trim', $httpsUrls);
				if(in_array($actionUrl, $httpsUrls)) {
					$this->Ssl->force($c);
				} else {
					$this->Ssl->unforce($c);
				}
			}
		}
		$userId = $this->getUserId();
		$user = array();
		if($userId) {
			App::import("Model", "Usermgmt.User");
			$userModel = new User;
			$user = $userModel->getUserById($userId);
			if(isset($user['User']['user_group_id'])) {
				App::import("Model", "Usermgmt.UserGroup");
				$userGroupModel = new UserGroup;
				$groups = $userGroupModel->getGroupsByIds($user['User']['user_group_id'], true);
				$user['UserGroup']['idName']=$groups;
				$user['UserGroup']['Name']=implode(', ', $groups);
			}
		}
		if(isset($user['Search'])) {
			unset($user['Search']);
		}
		$c->set('var', $user);
	}
	/**
	 * Used to check whether user is logged in or not
	 *
	 * @access public
	 * @return boolean
	 */
	public function isLogged() {
		if($this->getUserId()) {
			return true;
		}
		return false;
	}
	/**
	 * Used to get user from session
	 *
	 * @access public
	 * @return array
	 */
	public function getUser() {
		return $this->Session->read('UserAuth');
	}
	/**
	 * Used to get user id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getUserId() {
		return $this->Session->read('UserAuth.User.id');
	}
	/**
	 * Used to get group id from session
	 *
	 * @access public
	 * @return integer
	 */
	public function getGroupId() {
		return $this->Session->read('UserAuth.User.user_group_id');
	}
	/**
	 * Used to get group name from session
	 *
	 * @access public
	 * @return string
	 */
	public function getGroupName() {
		return $this->Session->read('UserAuth.UserGroup.name');
	}
	/**
	 * Used to check is admin logged in
	 *
	 * @access public
	 * @return string
	 */
	public function isAdmin() {
		$idName = $this->Session->read('UserAuth.UserGroup.idName');
		if(isset($idName[ADMIN_GROUP_ID])) {
			return true;
		}
		return false;
	}
	/**
	 * Used to check is guest logged in
	 *
	 * @access public
	 * @return string
	 */
	public function isGuest() {
		$idName = $this->Session->read('UserAuth.UserGroup.idName');
		if(empty($idName)) {
			return true;
		}
		return false;
	}
	/**
	 * Used to get last login Time
	 *
	 * @access public
	 * @return string
	 */
	public function getLastLoginTime($format=null) {
		$last_login = $this->Session->read('UserAuth.User.last_login');
		if(!empty($last_login)) {
			if(empty($format)) {
				$format = 'd-M-Y h:i A';
			}
			return date($format, strtotime($last_login));
		}
		return '';
	}
	/**
	 * Used to make password in hash format
	 *
	 * @access public
	 * @param string $pass password of user
	 * @param string $salt salt of user for password
	 * @return hash
	 */
	public function makePassword($pass, $salt) {
		if(strlen($salt)==32) {
			// for old passwords
			return md5(md5($pass).md5($salt));
		} else {
			$salt = base64_decode($salt).Configure::read('Security.salt');
			return Security::hash($pass, 'sha256', $salt);
		}
	}
	/**
	 * Used to make salt in hash format
	 *
	 * @access public
	 * @return hash
	 */
	public function makeSalt($length=48) {
		if (function_exists('mycrypt_create_iv')) {
			$bits = mcrypt_create_iv($length);
			$salt = base64_encode($bits);
		} else {
			$iv = '';
			for($i = 0; $i < $length; $i++) {
				$iv .= chr(rand(0,255));
			}
			$salt=base64_encode($iv);
		}
		return $salt;
	}
	/**
	 * Used to generate random password
	 *
	 * @access public
	 * @return string
	 */
	public function generatePassword()  {
		$rand = mt_rand(0, 32);
		$newpass = md5($rand . time());
		$newpass = substr($newpass, 0,7);
		return $newpass;
	}
	/**
	 * Used to maintain login session of user
	 *
	 * @access public
	 * @param mixed $type possible values 'guest', 'cookie', user array
	 * @param string $credentials credentials of cookie, default null
	 * @return array
	 */
	public function login($type = 'guest', $credentials = null) {
		$user=array();
		App::import("Model", "Usermgmt.User");
		$userModel = new User;
		if (is_string($type) && ($type=='guest' || $type=='cookie')) {
			$user = $userModel->authsomeLogin($type, $credentials);
		} elseif (is_array($type)) {
			$user =$type;
		}
		if(isset($user['User']['user_group_id'])) {
			App::import("Model", "Usermgmt.UserGroup");
			$userGroupModel = new UserGroup;
			$groups = $userGroupModel->getGroupsByIds($user['User']['user_group_id'], true);
			$user['UserGroup']['idName']=$groups;
			$user['UserGroup']['Name']=implode(', ', $groups);
		}
		$loginAllowed = true;
		if(isset($user['User']['id'])) {
			$gids = array();
			if(isset($user['UserGroup']['idName'])) {
				$gids = $user['UserGroup']['idName'];
			}
			$loginAllowed = $this->isAllowedLogin($user['User']['id'], $gids);
		}
		if($loginAllowed) {
			Configure::write($this->configureKey, $user);
			$this->Session->write('UserAuth', $user);
			if(isset($user['User']['id'])) {
				$user['User']['last_login']=date('Y-m-d H:i:s');
				// updating password with new password hashing
				if(is_object($this->cont)) {
					if(!empty($this->cont->request->data['User']['password']) && strlen($user['User']['salt'])==32) {
						$salt = $this->makeSalt();
						$user['User']['salt']=$salt;
						$user['User']['password'] = $this->makePassword($this->cont->request->data['User']['password'], $salt);
					}
				}
				$userModel->save($user,false);
			}
			return $user;
		} else {
			$this->Session->write('UserAuth.loginNotAllowed', true);
		}
	}
	/**
	 * Used to delete user session and cookie
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->deleteActivity($this->getUserId());
		$this->Session->delete('UserAuth');
		Configure::write($this->configureKey, array());
		$this->Cookie->delete(LOGIN_COOKIE_NAME);
		$this->clearSession();
	}
	/**
	 * Used to delete social network session
	 *
	 * @access public
	 * @return void
	 */
	private function clearSession() {
		$this->Session->delete("fb_".FB_APP_ID."_code");
		$this->Session->delete("fb_".FB_APP_ID."_access_token");
		$this->Session->delete("fb_".FB_APP_ID."_user_id");
		$this->Session->delete("ot");
		$this->Session->delete("ots");
		$this->Session->delete("oauth.linkedin");
		$this->Session->delete("fs_access_token");
		$this->Session->delete("G_token");
	}
	/**
	 * Used to persist cookie for remember me functionality
	 *
	 * @access public
	 * @param string $duration duration of cookie life time on user's machine
	 * @return boolean
	 */
	public function persist($duration = '2 weeks') {
		$userId = $this->getUserId();
		if(!empty($userId)) {
			App::import("Model", "Usermgmt.User");
			$userModel = new User;
			$token = $userModel->authsomePersist($userId, $duration);
			$token = $token.':'.$duration;
			return $this->Cookie->write(
				LOGIN_COOKIE_NAME,
				$token,
				true, // encrypt = true
				$duration
			);
		}
	}
	/**
	 * Used to check user's session if user's session is not available then it tries to get login from cookie if it exist
	 *
	 * @access private
	 * @return array
	 */
	private function __getActiveUser() {
		$user = Configure::read($this->configureKey);
		if (!empty($user)) {
			return $user;
		}

		$this->__useSession() || $this->__useCookieToken() || $this->__useGuestAccount();

		$user = Configure::read($this->configureKey);
		if (is_null($user)) {
			throw new Exception(
				'Unable to initilize user'
			);
		}
		return $user;
	}
	/**
	 * Used to get user from session
	 *
	 * @access private
	 * @return boolean
	 */
	private function __useSession() {
		$user = $this->getUser();
		if (!$user) {
			return false;
		}
		Configure::write($this->configureKey, $user);
		return true;
	}
	/**
	 * Used to get login from cookie
	 *
	 * @access private
	 * @return boolean
	 */
	private function __useCookieToken() {
		$token = $this->Cookie->read(LOGIN_COOKIE_NAME);
		if (!$token) {
			return false;
		}

		// Extract the duration appendix from the token
		$tokenParts = split(':', $token);
		$duration = array_pop($tokenParts);
		$token = join(':', $tokenParts);
		$user = $this->login('cookie', compact('token', 'duration'));
		// Delete the cookie once its been used
		$this->Cookie->delete(LOGIN_COOKIE_NAME);
		if (!$user) {
			return;
		}
		$this->persist($duration);
		return (bool)$user;
	}
	/**
	 * Used to get login as guest
	 *
	 * @access private
	 * @return array
	 */
	private function __useGuestAccount() {
		return $this->login('guest');
	}
	/**
	 * Used to update update activities of user or a guest
	 *
	 * @access private
	 * @return void
	 */
	private function updateActivity($c, $actionUrl) {
		if(($actionUrl !='Users/logout' && $actionUrl !='Users/login' && !isset($c->params['requested']) && !isset($c->RequestHandler->__acceptTypes[0])) || ($actionUrl !='Users/logout' && $actionUrl !='Users/login' && isset($c->RequestHandler->__acceptTypes[0]) && $c->RequestHandler->__acceptTypes[0]=='text/html')) {
			$useragent=$this->Session->read('Config.userAgent');
			$useragent = $useragent.session_id();
			$user_id=$this->getUserId();
			$last_action=$this->Session->read('Config.time');
			$last_url=$c->here;
			$user_browser=(isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : "";
			$ip=(isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : "";

			App::import("Model", "Usermgmt.UserActivity");
			$activityModel = new UserActivity;
			$activityModel->id=null;
			$res=$activityModel->findByUseragent($useragent);
			if(!empty($res['UserActivity']['logout']) && !empty($res['UserActivity']['user_id']) && $res['UserActivity']['user_id']==$user_id) {
				$c->redirect(array('plugin' => 'usermgmt', 'controller' => 'Users', 'action' => 'logout'));
			}
			if(!empty($res['UserActivity']['deleted']) && !empty($res['UserActivity']['user_id']) && $res['UserActivity']['user_id']==$user_id) {
				$c->redirect(array('plugin' => 'usermgmt', 'controller' => 'Users', 'action' => 'logout'));
			}
			$status = ($user_id) ? 1 : 0;
			$res['UserActivity']['useragent']=$useragent;
			$res['UserActivity']['user_id']=$user_id;
			$res['UserActivity']['last_action']=$last_action;
			$res['UserActivity']['last_url']=$last_url;
			$res['UserActivity']['user_browser']=$user_browser;
			$res['UserActivity']['ip_address']=$ip;
			$res['UserActivity']['status']=$status;
			unset($res['UserActivity']['modified']);
			$activityModel->save($res, false);
		}
	}
	/**
	 * Used to delete activity after logout
	 *
	 * @access public
	 * @return void
	 */
	public function deleteActivity($user_id) {
		if(!empty($user_id)) {
			App::import("Model", "Usermgmt.UserActivity");
			$activityModel = new UserActivity;
			$useragent=$this->Session->read('Config.userAgent');
			$useragent = $useragent.session_id();
			$activityModel->deleteAll(array('UserActivity.user_id'=>$user_id, 'UserActivity.useragent'=>$useragent), false);
		}
	}
	function setBadLoginCount() {
		$count = 1;
		if($this->Session->check('UserAuth.badLoginCount')) {
			$count += $this->Session->read('UserAuth.badLoginCount');
		}
		$this->Session->write('UserAuth.badLoginCount', $count);
	}
	function captchaOnBadLogin() {
		if(USE_RECAPTCHA) {
			if($this->Session->check('UserAuth.badLoginCount')) {
				if($this->Session->read('UserAuth.badLoginCount') > BAD_LOGIN_ALLOW_COUNT) {
					return true;
				}
			}
		}
		return false;
	}
	function canUseRecaptha($type=null) {
		$privatekey = PRIVATE_KEY_FROM_RECAPTCHA;
		$publickey = PUBLIC_KEY_FROM_RECAPTCHA;
		if($type=='login') {
			if(USE_RECAPTCHA && USE_RECAPTCHA_ON_LOGIN && !empty($privatekey) && !empty($publickey)) {
				if($this->Session->check('UserAuth.badLoginCount')) {
					if($this->Session->read('UserAuth.badLoginCount') > BAD_LOGIN_ALLOW_COUNT) {
						return true;
					}
				}
			}
		} else if($type=='registration') {
			if(USE_RECAPTCHA && USE_RECAPTCHA_ON_REGISTRATION && !empty($privatekey) && !empty($publickey)) {
				return true;
			}
		} else if($type=='forgotPassword') {
			if(USE_RECAPTCHA && USE_RECAPTCHA_ON_FORGOT_PASSWORD && !empty($privatekey) && !empty($publickey)) {
				return true;
			}
		} else if($type=='emailVerification') {
			if(USE_RECAPTCHA && USE_RECAPTCHA_ON_EMAIL_VERIFICATION && !empty($privatekey) && !empty($publickey)) {
				return true;
			}
		} else if($type=='contactus') {
			if(USE_RECAPTCHA && !$this->isLogged() && !empty($privatekey) && !empty($publickey)) {
				return true;
			}
		}
		return false;
	}
	function isAllowedLogin($userId, $groupIds) {
		$allowMultipleLogin = ALLOW_USER_MULTIPLE_LOGIN;
		if(isset($groupIds[ADMIN_GROUP_ID])) {
			$allowMultipleLogin = ALLOW_ADMIN_MULTIPLE_LOGIN;
		}
		if(!$allowMultipleLogin) {
			$useragent=$this->Session->read('Config.userAgent');
			$useragent = $useragent.session_id();
			$last_action = $this->Session->read('Config.time');
			$last_action = $last_action - (abs(LOGIN_IDLE_TIME) * 60);

			App::import("Model", "Usermgmt.UserActivity");
			$activityModel = new UserActivity;
			$activityModel->id=null;

			$res = $activityModel->find('all', array('conditions'=>array('UserActivity.user_id'=>$userId, 'UserActivity.last_action >'=>$last_action, 'UserActivity.useragent !='=>$useragent)));
			if(!empty($res)) {
				return false;
			} else {
				$activityModel->updateAll(array('UserActivity.logout'=>1), array('UserActivity.user_id'=>$userId));
			}
		}
		return true;
	}
}