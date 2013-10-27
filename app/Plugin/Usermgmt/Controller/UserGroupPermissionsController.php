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
class UserGroupPermissionsController extends UserMgmtAppController {
	/**
	 * This controller uses following models
	 *
	 * @var array
	 */
	var $uses = array('Usermgmt.UserGroupPermission','Usermgmt.UserGroup');
	/**
	 * This controller uses following components
	 *
	 * @var array
	 */
	var $components=array('Usermgmt.ControllerList','RequestHandler');
	/**
	 * Called before the controller action.  You can use this method to configure and customize components
	 * or perform logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		if(isset($this->Security) &&  ($this->RequestHandler->isAjax() || $this->action == 'update' || $this->action == 'permissionGroupMatrix' || $this->action == 'permissionSubGroupMatrix')){
			$this->Security->csrfCheck = false;
			$this->Security->validatePost = false;
		}
	}
	/**
	 * It displays all parent group permissions with controller and action names in standard view
	 *
	 * @access public
	 * @return array
	 */
	public function index() {
		$c=-2;
		if (isset($_GET['c']) && $_GET['c'] !='') {
			$c=$_GET['c'];
		}
		$this->set('c',$c);
		$allControllers=$this->ControllerList->getControllers();
		$this->set('allControllers',$allControllers);
		if ($c >-2) {
			$con=array();
			$conAll=$this->ControllerList->get();
			if ($c ==-1) {
				$con=$conAll;
				$funcDesc = $this->getFunctionDesc($con);
				$user_group_permissions=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'contain'=>array('UserGroup')));
			} else {
				$user_group_permissions=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'conditions'=>array('controller'=>$allControllers[$c]), 'contain'=>array('UserGroup')));
				$con[$allControllers[$c]]= (isset($conAll[$allControllers[$c]])) ? $conAll[$allControllers[$c]] : array();
				$funcDesc = $this->getFunctionDesc($con);
			}
			foreach ($user_group_permissions as $row) {
				$cont=$row['UserGroupPermission']['controller'];
				$act=$row['UserGroupPermission']['action'];
				$ugname=$row['UserGroup']['alias_name'];
				$allowed=$row['UserGroupPermission']['allowed'];
				$con[$cont][$act][$ugname]=$allowed;
			}
			$this->set('controllers',$con);
			$this->set('funcDesc',$funcDesc);
			$result=$this->UserGroup->getGroupNamesAndIds();
			$groups=array();
			$groups2=array();
			foreach ($result as $row) {
				$groups[]= $row['alias_name'];
			}
			$groups = implode(',', $groups);
			$this->set('user_groups',$result);
			$this->set('groups',$groups);
		}
	}
	/**
	 * It displays all sub group permissions with controller and action names in standard view
	 *
	 * @access public
	 * @return array
	 */
	function subPermissions() {
		$group_id=0;
		if(isset($_GET['g']) && $_GET['g'] !='') {
			$group_id=$_GET['g'];
		}
		$this->set('group_id',$group_id);

		$c=-2;
		if (isset($_GET['c']) && $_GET['c'] !='') {
			$c=$_GET['c'];
		}
		$this->set('c',$c);

		$allControllers=$this->ControllerList->getControllers();
		$this->set('allControllers',$allControllers);

		$parentGroups=$this->UserGroup->getParentGroups();
		$parentGroups[0]='Select Group';
		$this->set('parentGroups', $parentGroups);

		$subGroups=$this->UserGroup->getSubGroupNamesAndIds($group_id);
		if(empty($subGroups)) {
			$this->Session->setFlash('No sub group exists of this group', 'default', array('class' => 'warning'));
			if($c > -2) {
				$this->redirect('/subPermissions/?g='.$group_id);
			}
		}
		$this->set('subGroups',$subGroups);

		if($c >-2) {
			if($group_id!=0) {
				$con=array();
				$finalPermissions = array();
				$i=0;

				if($c ==-1) {
					$result=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'conditions'=>array('user_group_id'=>$group_id, 'allowed'=>1), 'contain'=>array('UserGroup')));
				} else {
					$result=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'conditions'=>array('controller'=>$allControllers[$c], 'user_group_id'=>$group_id, 'allowed'=>1), 'contain'=>array('UserGroup')));
				}
				if(!empty($result)) {
					foreach($result as $row) {
						$perm = $row['UserGroupPermission']['controller'].'/'.$row['UserGroupPermission']['action'];
						$finalPermissions[$perm]=$row['UserGroupPermission'];
					}
				}
				$this->set('finalPermissions',$finalPermissions);
				$conAll=$this->ControllerList->get();

				if ($c ==-1) {
					$con=$conAll;
					$funcDesc = $this->getFunctionDesc($con);
					$user_group_permissions=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'contain'=>array('UserGroup')));
				} else {
					$user_group_permissions=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'conditions'=>array('controller'=>$allControllers[$c]), 'contain'=>array('UserGroup')));
					$con[$allControllers[$c]]= (isset($conAll[$allControllers[$c]])) ? $conAll[$allControllers[$c]] : array();
					$funcDesc = $this->getFunctionDesc($con);
				}

				foreach ($user_group_permissions as $row) {
					$cont=$row['UserGroupPermission']['controller'];
					$act=$row['UserGroupPermission']['action'];
					$ugname=$row['UserGroup']['alias_name'];
					$allowed=$row['UserGroupPermission']['allowed'];
					$con[$cont][$act][$ugname]=$allowed;
				}
				$this->set('controllers',$con);
				$this->set('funcDesc',$funcDesc);
				$groups=array();
				foreach ($subGroups as $row) {
					$groups[]= $row['alias_name'];
				}
				$groups = implode(',', $groups);
				$this->set('user_groups',$subGroups);
				$this->set('groups',$groups);
			}
		}
	}
	/**
	 *  It is used to update permission of group using ajax
	 *
	 * @access public
	 * @return integer
	 */
	public function update() {
		$this->autoRender = false;
		$controller=$this->params['data']['controller'];
		$action=$this->params['data']['action'];
		$result=$this->UserGroup->getAllGroupNamesAndIds();
		$success=0;
		foreach ($result as $row) {
			if (isset($this->params['data'][$row['alias_name']])) {
				$res=$this->UserGroupPermission->find('first',array('conditions' => array('controller'=>$controller,'action'=>$action,'user_group_id'=>$row['id']), 'contain'=>array('UserGroup')));
				if($row['parent_id']==0) {
					if (empty($res)) {
						$data=array();
						$data['UserGroupPermission']['user_group_id']=$row['id'];
						$data['UserGroupPermission']['controller']=$controller;
						$data['UserGroupPermission']['action']=$action;
						$data['UserGroupPermission']['allowed']=$this->params['data'][$row['alias_name']];
						$data['UserGroupPermission']['id']=null;
						$rtn=$this->UserGroupPermission->save($data);
						if ($rtn) {
							$success=1;
						}
					} else {
						if ($this->params['data'][$row['alias_name']] !=$res['UserGroupPermission']['allowed']) {
							$data=array();
							$data['UserGroupPermission']['allowed']=$this->params['data'][$row['alias_name']];
							$data['UserGroupPermission']['id']=$res['UserGroupPermission']['id'];
							$rtn=$this->UserGroupPermission->save($data);
							if ($rtn) {
								$success=1;
							}
						} else {
							 $success=1;
						}
					}
				} else {
					$status=$this->__getParentStatus($row['parent_id'],$controller, $action);
					if(empty($res)) {
						if(($status['parent_row']==0 && $this->params['data'][$row['alias_name']]==1) || ($status['parent_row']==1 && $this->params['data'][$row['alias_name']]!=$status['allowed'])) {
							$data=array();
							$data['UserGroupPermission']['user_group_id']=$row['id'];
							$data['UserGroupPermission']['controller']=$controller;
							$data['UserGroupPermission']['action']=$action;
							$data['UserGroupPermission']['allowed']=$this->params['data'][$row['alias_name']];
							$data['UserGroupPermission']['id']=null;
							$rtn=$this->UserGroupPermission->save($data);
							if ($rtn) {
								$success=1;
							}
						} else {
							 $success=1;
						}
					} else {
						if($this->params['data'][$row['alias_name']] !=$res['UserGroupPermission']['allowed']) {
							if($status['parent_row']==1 && $this->params['data'][$row['alias_name']]==$status['allowed']) {
								$rtn=$this->UserGroupPermission->delete($res['UserGroupPermission']['id'],false);
								if ($rtn) {
									$success=1;
								}
							} else {
								$data=array();
								$data['UserGroupPermission']['allowed']=$this->params['data'][$row['alias_name']];
								$data['UserGroupPermission']['id']=$res['UserGroupPermission']['id'];
								$rtn=$this->UserGroupPermission->save($data);
								if ($rtn) {
									$success=1;
								}
							}
						} else {
							 $success=1;
						}
					}
				}
			}
		}
		echo $success;
		$this->__deleteCache();
	}
	/**
	 * It is used to get parent group status
	 *
	 * @access private
	 * @return array
	 */
	private function __getParentStatus($parentid,$controller, $action) {
		$status=array();
		$status['parent_row']=0;
		$status['allowed']=0;
		$res=$this->UserGroupPermission->find('first',array('conditions' => array('controller'=>$controller,'action'=>$action,'user_group_id'=>$parentid), 'contain'=>array('UserGroup')));
		if(!empty($res)) {
			$status['allowed']=$res['UserGroupPermission']['allowed'];
			$status['parent_row']=1;
		}
		return $status;
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
				if (!is_dir($file->getPathname()) && strpos($path_info['basename'], 'UserMgmt_rules_for_group') !==false) {
					unlink($file->getPathname());
				}
			}
		}
	}
	/**
	 *  It is used to get permissions of logged in user or a guest in view helper
	 *
	 * @access public
	 * @return array
	 */
	public function getPermissions() {
		if(!$this->UserAuth->isLogged()) {
			return $this->UserGroup->getPermissions(GUEST_GROUP_ID);
		} else {
			return $this->UserGroup->getPermissions($this->UserAuth->getGroupId());
		}
	}
	/**
	 * It displays all parent group permissions with controller and action names in matrix view
	 *
	 * @access public
	 * @return array
	 */
	public function permissionGroupMatrix() {
		$allControllers=$this->ControllerList->getControllers();
		unset($allControllers[-2], $allControllers[-1]);
		$user_groups = $sel_user_groups = $this->UserGroup->getGroupNamesAndIds();
		$controllers=array();
		$controllerActions=array();
		if($this->request->isPost()) {
			if(!empty($this->request->data['controller'])) {
				$conAll=$this->ControllerList->get();
				$selConts = $this->request->data['controller'];
				$cond=array();
				$groupIds=array();
				if(!empty($this->request->data['group'])) {
					foreach($this->request->data['group'] as $groupId=>$val) {
						$groupIds[]=$groupId;
					}
					$sel_user_groups=array();
					foreach ($user_groups as $group) {
						if(in_array($group['id'], $groupIds)) {
							$sel_user_groups[]=$group;
						}
					}
					$cond['UserGroupPermission.user_group_id']=$groupIds;
				}
				if(empty($groupIds)) {
					foreach ($user_groups as $group) {
						$groupIds[]=$group['id'];
					}
					$cond['UserGroupPermission.user_group_id']=$groupIds;
				}
				if(count($selConts) == count($allControllers)) {
					$controllers=$conAll;

				} else {
					$qConts=array();
					foreach($selConts as $key=>$val) {
						$qConts[]=$allControllers[$key];
						$controllers[$allControllers[$key]]=(isset($conAll[$allControllers[$key]])) ? $conAll[$allControllers[$key]] : array();
					}
					$cond['UserGroupPermission.controller']=$qConts;
				}
				$user_group_permissions=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'conditions'=>$cond, 'contain'=>array('UserGroup')));
				foreach ($user_group_permissions as $row) {
					$cont=$row['UserGroupPermission']['controller'];
					$act=$row['UserGroupPermission']['action'];
					$ugname=$row['UserGroup']['alias_name'];
					$allowed=$row['UserGroupPermission']['allowed'];
					$controllerActions[$cont][$act][$ugname]=$allowed;
				}
			}
		}
		$funcDesc = $this->getFunctionDesc($controllers);
		$this->set(compact('user_groups', 'allControllers', 'controllers', 'sel_user_groups', 'funcDesc', 'controllerActions'));
	}
	/**
	 * It displays all sub group permissions with controller and action names in matrix view
	 *
	 * @access public
	 * @return array
	 */
	public function permissionSubGroupMatrix() {
		$allControllers=$this->ControllerList->getControllers();
		unset($allControllers[-2], $allControllers[-1]);
		$user_groups = $sel_user_groups = $this->UserGroup->getSubGroupNamesAndIds();
		$controllers=array();
		$controllerActions=array();
		$parentIds=array();
		$parentPermissions=array();
		if($this->request->isPost()) {
			if(!empty($this->request->data['controller'])) {
				$conAll=$this->ControllerList->get();
				$selConts = $this->request->data['controller'];
				$cond=array();
				$groupIds=array();
				if(!empty($this->request->data['group'])) {
					foreach($this->request->data['group'] as $groupId=>$val) {
						$groupIds[]=$groupId;
					}
					$sel_user_groups=array();
					foreach ($user_groups as $group) {
						if(in_array($group['id'], $groupIds)) {
							$sel_user_groups[]=$group;
						}
					}
					$cond['UserGroupPermission.user_group_id']=$groupIds;
				}
				if(empty($groupIds)) {
					foreach ($user_groups as $group) {
						$groupIds[]=$group['id'];
					}
					$cond['UserGroupPermission.user_group_id']=$groupIds;
				}
				$parentIds = $this->UserGroup->getParentGroupIds($groupIds);
				$parentResult=array();
				if(count($selConts) == count($allControllers)) {
					$controllers=$conAll;
					$parentResult=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'conditions'=>array('user_group_id'=>$parentIds, 'allowed'=>1)));
				} else {
					$qConts=array();
					foreach($selConts as $key=>$val) {
						$qConts[]=$allControllers[$key];
						$controllers[$allControllers[$key]]=(isset($conAll[$allControllers[$key]])) ? $conAll[$allControllers[$key]] : array();
					}
					$cond['UserGroupPermission.controller']=$qConts;
					$parentResult=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'conditions'=>array('controller'=>$qConts, 'user_group_id'=>$parentIds, 'allowed'=>1), 'contain'=>array('UserGroup')));
				}
				if(!empty($parentResult)) {
					foreach($parentResult as $row) {
						$perm = $row['UserGroupPermission']['controller'].'/'.$row['UserGroupPermission']['action'];
						$parentPermissions[$perm]=$row['UserGroupPermission'];
					}
				}
				$user_group_permissions=$this->UserGroupPermission->find('all', array('order'=>array('controller', 'action'), 'conditions'=>$cond, 'contain'=>array('UserGroup')));
				foreach ($user_group_permissions as $row) {
					$cont=$row['UserGroupPermission']['controller'];
					$act=$row['UserGroupPermission']['action'];
					$ugname=$row['UserGroup']['alias_name'];
					$allowed=$row['UserGroupPermission']['allowed'];
					$controllerActions[$cont][$act][$ugname]=$allowed;
				}
			}
		}
		$funcDesc = $this->getFunctionDesc($controllers);
		$this->set(compact('user_groups', 'allControllers', 'controllers', 'sel_user_groups', 'funcDesc', 'controllerActions', 'parentIds', 'parentPermissions'));
	}
	/**
	 * It is used to change permission from matrix chart by ajax
	 *
	 * @access public
	 * @return array
	 */
	public function changePermission($cont=null, $action=null, $groupId=null) {
		if($cont && $action && $groupId) {
			$groupDetail=$this->UserGroup->find('first', array('conditions'=>array('id'=>$groupId)));
			$groupRes=$this->UserGroupPermission->find('first',array('conditions' => array('controller'=>$cont,'action'=>$action,'user_group_id'=>$groupId)));
			$parentRes=array();
			if($groupDetail['UserGroup']['parent_id']!=0) {
				$parentRes=$this->UserGroupPermission->find('first',array('conditions' => array('controller'=>$cont,'action'=>$action,'user_group_id'=>$groupDetail['UserGroup']['parent_id'])));
			}
			if(!empty($groupDetail)) {
				$allowed=1;
				$save=false;
				if($groupDetail['UserGroup']['parent_id']==0) {
					if(!empty($groupRes['UserGroupPermission']['allowed'])) {
						$allowed=0;
					}
					$save=true;
				} else {
					if(empty($groupRes)) {
						if(!empty($parentRes['UserGroupPermission']['allowed'])) {
							$allowed=0;
						}
						$save=true;
					} else {
						if(!empty($parentRes)) {
							if($parentRes['UserGroupPermission']['allowed'] != $groupRes['UserGroupPermission']['allowed']) {
								$this->UserGroupPermission->delete($groupRes['UserGroupPermission']['id'], false);
								if($groupRes['UserGroupPermission']['allowed']==1) {
									$allowed=0;
								}
							} else {
								if(!empty($groupRes['UserGroupPermission']['allowed'])) {
									$allowed=0;
								}
								$save=true;
							}
						} else {
							if(!empty($groupRes['UserGroupPermission']['allowed'])) {
								$allowed=0;
							}
							$save=true;
						}
					}
				}
				if($save) {
					$groupRes['UserGroupPermission']['user_group_id']=$groupId;
					$groupRes['UserGroupPermission']['controller']=$cont;
					$groupRes['UserGroupPermission']['action']=$action;
					$groupRes['UserGroupPermission']['allowed']=$allowed;
					$this->UserGroupPermission->save($groupRes, false);
				}
				$this->__deleteCache();
				if($this->RequestHandler->isAjax()) {
					if($allowed) {
						echo '<img alt="Yes" src="'.SITE_URL.'usermgmt/img/approve.png">';
					} else {
						echo '<img alt="No" src="'.SITE_URL.'usermgmt/img/dis-approve2.png">';
					}
				} else {
					$this->redirect(array('controller'=>'permissionGroupMatrix'));
				}
			}
		}
		exit;
	}
	/**
	 * It is used to get controller's action comment
	 *
	 * @access private
	 * @return array
	 */
	private function getFunctionDesc($controllers) {
		$funcDesc=array();
		if(!empty($controllers)) {
			App::import('Lib', 'Usermgmt.DocBlock');
			foreach($controllers as $cont=>$actions) {
				$contClass=$cont.'Controller';
				foreach($actions as $action) {
					$ref = new ReflectionMethod($contClass, $action);
					$docCmnt = new DocBlock($ref->getDocComment());
					$funcDesc[$cont][$action] = $docCmnt->desc;
				}
			}
		}
		return $funcDesc;
	}
}