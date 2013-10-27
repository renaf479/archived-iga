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

App::uses('UserMgmtAppController', 'Usermgmt.Controller');
class UserSettingsController extends UserMgmtAppController {
	/**
	 * This controller uses following models
	 *
	 * @var array
	 */
	public $uses = array('Usermgmt.UserSetting');
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
	public $helpers = array('Js');
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
				'UserSetting' => array(
					'UserSetting.name_public'=> array(
						'type' => 'text',
						'label' => 'Setting Name',
						'inputOptions'=>array('style'=>'width:300px;')
					),
					'UserSetting.category' => array(
						'type' => 'select',
						'condition' => '=',
						'label' => 'Category',
						'selector' => 'getSettingCategories'
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
		if(isset($this->Security) &&  ($this->RequestHandler->isAjax() || $this->action=='cakelog')){
			$this->Security->csrfCheck = false;
			$this->Security->validatePost = false;
		}
	}
	/**
	 * It displays all settings
	 *
	 * @access public
	 * @return array
	 */
	public function index() {
		$this->paginate = array('limit' => 10, 'order'=>'UserSetting.id');
		$userSettings = $this->paginate('UserSetting');
		$this->set('userSettings', $userSettings);
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
			$this->render('/Elements/all_settings');
		}
	}
	/**
	 * It is used to edit setting value
	 *
	 * @access public
	 * @param integer $settingId group id
	 * @return void
	 */
	public function editSetting($settingId=null) {
		$page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1;
		if (!empty($settingId)) {
			$userSetting = $this->UserSetting->read(null, $settingId);
			if(!empty($userSetting)) {
				if ($this->request->isPut()) {
					$this->UserSetting->set($this->request->data);
					$addValidate = $this->UserSetting->addValidate();
					if($addValidate) {
						$userSetting['UserSetting']['value'] = $this->request->data['UserSetting']['value'];
						$userSetting['UserSetting']['category'] = $this->request->data['UserSetting']['category'];
						$this->UserSetting->save($userSetting,false);
						$this->__deleteCache();
						$this->Session->setFlash(__('Selected setting is successfully updated'));
						$this->redirect(array('action'=>'index', 'page'=>$page));
					}
				} else {
					$this->request->data = $userSetting;
				}
			} else {
				$this->redirect(array('action'=>'index', 'page'=>$page));
			}
		} else {
			$this->redirect(array('action'=>'index', 'page'=>$page));
		}
		$settingCategories = $this->UserSetting->getSettingCategories();
		$this->set(compact('settingCategories', 'userSetting'));
	}
	/**
	 * It is used to delete cache of permissions and used when any permission gets changed by Admin
	 *
	 * @access private
	 * @return void
	 */
	private function __deleteCache() {
		$iterator = new RecursiveDirectoryIterator(CACHE);
		foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file) {
			$path_info = pathinfo($file);
			if ($path_info['dirname']==TMP."cache" && $path_info['basename']!='.svn') {
				if (!is_dir($file->getPathname()) && strpos($path_info['basename'], 'UserMgmt_all_settings') !==false) {
					unlink($file->getPathname());
				}
			}
		}
	}
	/**
	 * It is used to display cake logs
	 *
	 * @access public
	 * @return array
	 */
	public function cakelog($filename = null) {
		$fullpath= LOGS;
		$logFiles = glob($fullpath."*.log");
		$this->set(compact('logFiles', 'filename'));
		if($this->request->isPost()) {
			$fp = fopen($fullpath.$filename, "w");
			fwrite($fp, $this->request->data['UserSetting']['logfile']);
			fclose($fp);
			$this->Session->setFlash($filename.__(' has been modified successfully'));
			$this->redirect(array('action'=>'cakelog'));
		}
	}
	/**
	 * It is used to create backup of log file
	 *
	 * @access public
	 * @return array
	 */
	public function cakelogbackup($filename = null) {
		if (isset($_SERVER['HTTP_REFERER'])) {
			if(!empty($filename)) {
				$filepath= LOGS.$filename;
				if(file_exists($filepath)) {
					$pathinfo = pathinfo($filepath);
					$newfile= $pathinfo['filename'].'_'.date('d-M-Y_H-i', time()).'.'.$pathinfo['extension'];
					copy($filepath, LOGS.$newfile);
					$this->Session->setFlash($filename.__(' has been copied to ').$newfile);
				} else {
					$this->Session->setFlash($filename.__(' file does not exist.'), 'default', array('class' => 'warning'));
				}
			} else {
				$this->Session->setFlash(__('Missing Filename'), 'default', array('class' => 'warning'));
			}
		}
		$this->redirect(array('action'=>'cakelog'));
	}
	/**
	 * It is used to delete log file
	 *
	 * @access public
	 * @return array
	 */
	public function cakelogdelete($filename = null) {
		if (isset($_SERVER['HTTP_REFERER'])) {
			if(!empty($filename)) {
				$filepath= LOGS.$filename;
				if(file_exists($filepath)) {
					if(unlink($filepath)) {
						$this->Session->setFlash($filename.__(' has been deleted'));
					} else {
						$this->Session->setFlash($filename.__(' file could not be deleted'), 'default', array('class' => 'warning'));
					}
				} else {
					$this->Session->setFlash($filename.__(' file does not exist.'), 'default', array('class' => 'warning'));
				}
			} else {
				$this->Session->setFlash(__('Missing Filename'), 'default', array('class' => 'warning'));
			}
		}
		$this->redirect(array('action'=>'cakelog'));
	}
	/**
	 * It is used to empty log file
	 *
	 * @access public
	 * @return array
	 */
	public function cakelogempty($filename = null) {
		if (isset($_SERVER['HTTP_REFERER'])) {
			if(!empty($filename)) {
				$filepath= LOGS.$filename;
				$f = @fopen($filepath, "r+");
				if ($f !== false) {
					ftruncate($f, 0);
					fclose($f);
					$this->Session->setFlash($filename.__(' has been done empty'));
				} else {
					$this->Session->setFlash($filename.__(' file does not exist.'), 'default', array('class' => 'warning'));
				}
			} else {
				$this->Session->setFlash(__('Missing Filename'), 'default', array('class' => 'warning'));
			}
		}
		$this->redirect(array('action'=>'cakelog'));
	}
}