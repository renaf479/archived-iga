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

App::uses('UserMgmtAppModel', 'Usermgmt.Model');
class UserEmailTemplate extends UserMgmtAppModel {

	/**
	 * model validation array
	 *
	 * @var array
	 */
	var $validate = array();
	function addValidate() {
		$validate1 = array(
				'template_name' => array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> __('Please enter template name'),
						'last'=>true)
				)
			);
		$this->validate=$validate1;
		return $this->validates();
	}
	/**
	 * Used to check template by template id
	 *
	 * @access public
	 * @param integer $templateId template id
	 * @return boolean
	 */
	public function isValidTemplateId($templateId) {
		if($this->hasAny(array('UserEmailTemplate.id'=>$templateId))) {
			return true;
		}
		return false;
	}
	/**
	 * Used to get all templates
	 *
	 * @access public
	 * @return array
	 */
	public function getTemplates() {
		$result=$this->find('all', array('order'=>'template_name'));
		$templates=array();
		$templates['']='No Template';
		foreach ($result as $row) {
			$templates[$row['UserEmailTemplate']['id']]=$row['UserEmailTemplate']['template_name'];
		}
		return $templates;
	}
	/**
	 * Used to get template by id
	 *
	 * @access public
	 * @param integer $templateId template id
	 * @return array
	 */
	public function getTemplateById($templateId) {
		$result=$this->find('first', array('conditions'=>array('UserEmailTemplate.id'=>$templateId)));
		return $result;
	}
}