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
class UserEmailTemplatesController extends UserMgmtAppController {
	/**
	 * This controller uses following models
	 *
	 * @var array
	 */
	public $uses = array('Usermgmt.UserEmailTemplate');
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
	 * This controller uses search filters in following functions for ex index, online function
	 *
	 * @var array
	 */
	var $searchFields = array
		(
			'index' => array(
				'UserEmailTemplate' => array(
					'UserEmailTemplate'=> array(
						'type' => 'text',
						'label' => 'Search',
						'tagline' => 'Search by template name, header, footer',
						'condition' => 'multiple',
						'searchFields'=>array('UserEmailTemplate.template_name', 'UserEmailTemplate.header', 'UserEmailTemplate.footer'),
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
	 * It displays all templates
	 *
	 * @access public
	 * @return array
	 */
	public function index() {
		$this->paginate = array('limit' => 10, 'order'=>'UserEmailTemplate.id desc');
		$userEmailTemplates = $this->paginate('UserEmailTemplate');
		$this->set('userEmailTemplates', $userEmailTemplates);
		if($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
			$this->render('/Elements/all_email_templates');
		}
	}
	/**
	 * It is used to create a new template
	 *
	 * @access public
	 * @return void
	 */
	public function add() {
		if ($this->request->isPost()) {
			$this->UserEmailTemplate->set($this->request->data);
			$addValidate = $this->UserEmailTemplate->addValidate();
			if($this->RequestHandler->isAjax()) {
				$this->layout = 'ajax';
				$this->autoRender = false;
				if ($addValidate) {
					$response = array('error' => 0, 'message' => 'success');
					return json_encode($response);
				} else {
					$response = array('error' => 1,'message' => 'failure');
					$response['data']['UserEmailTemplate']  = $this->UserEmailTemplate->validationErrors;
					return json_encode($response);
				}
			} else {
				if ($addValidate) {
					$this->UserEmailTemplate->save($this->request->data,false);
					$this->Session->setFlash(__('The template has been saved'));
					$this->redirect(array('action' => 'index'));
				}
			}
		}
	}
	/**
	 * It is used to edit existing template
	 *
	 * @access public
	 * @param integer $templateId template id
	 * @return void
	 */
	public function edit($templateId=null) {
		$page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1;
		if (!empty($templateId)) {
			if(!$this->UserEmailTemplate->isValidTemplateId($templateId)) {
				$this->redirect(array('action'=>'index', 'page'=>$page));
			}
			if ($this->request->isPut() || $this->request->isPost()) {
				$this->UserEmailTemplate->set($this->request->data);
				$addValidate = $this->UserEmailTemplate->addValidate();
				if($this->RequestHandler->isAjax()) {
					$this->layout = 'ajax';
					$this->autoRender = false;
					if ($addValidate) {
						$response = array('error' => 0, 'message' => 'success');
						return json_encode($response);
					} else {
						$response = array('error' => 1,'message' => 'failure');
						$response['data']['UserEmailTemplate']  = $this->UserEmailTemplate->validationErrors;
						return json_encode($response);
					}
				} else {
					if ($addValidate) {
						$this->UserEmailTemplate->save($this->request->data,false);
						$this->Session->setFlash(__('The template has been saved'));
						$this->redirect(array('action'=>'index', 'page'=>$page));
					}
				}
			}  else {
				$this->request->data = $this->UserEmailTemplate->read(null, $templateId);
			}
		} else {
			$this->redirect(array('action'=>'index', 'page'=>$page));
		}
	}
	/**
	 * It is used to delete the template
	 *
	 * @access public
	 * @param integer $templateId template id
	 * @return void
	 */
	public function delete($templateId = null) {
		$page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1;
		if (!empty($templateId)) {
			if ($this->request->isPost()) {
				if ($this->UserEmailTemplate->delete($templateId)) {
					$this->Session->setFlash(__('Selected template has been deleted successfully'));
				}
			}
		}
		$this->redirect(array('action'=>'index', 'page'=>$page));
	}
}