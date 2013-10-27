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
class UserSetting extends UserMgmtAppModel {

	/**
	 * model validation array
	 *
	 * @var array
	 */
	var $validate = array();
	function addValidate() {
		$validate1 = array(
				'category' => array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> __('Please select category'),
						'last'=>true)
				)
			);
		$this->validate=$validate1;
		return $this->validates();
	}
	/**
	 * Used to get settings by name
	 *
	 * @access public
	 * @param array $name setting name
	 * @return array
	 */
	public function getSettingByName($name=null) {
		$setting='';
		if(!empty($name)) {
			$data = $this->findByName($name);
			if(!empty($data)) {
				$setting = $data['UserSetting']['value'];
			}
		}
		return $setting;
	}
	/**
	 * Used to get all settings
	 *
	 * @access public
	 * @return array
	 */
	public function getAllSettings() {
		$setting=array();
		$data = $this->find('all');
		foreach($data as $row) {
			$setting[$row['UserSetting']['name']]['value'] = $row['UserSetting']['value'];
		}
		return $setting;
	}
	/**
	 * Used to get settings categories
	 *
	 * @access public
	 * @return array
	 */
	public function getSettingCategories($select=true) {
		$defaultCategories = array('FACEBOOK'=>'Facebook', 'TWITTER'=>'Twitter', 'GOOGLE'=>'Google', 'YAHOO'=>'Yahoo', 'LINKEDIN'=>'LinkedIn', 'FOURSQUARE'=>'Foursquare', 'RECAPTCHA'=>'Recaptcha', 'EMAIL'=>'Email', 'PERMISSION'=>'Permission', 'GROUP'=>'Group', 'USER'=>'User', 'OTHER'=>'Other');

		$res = $this->find('all', array('conditions'=>array('UserSetting.category IS NOT NULL', 'UserSetting.category !='=>''), 'group'=>'UserSetting.category', 'order'=>'UserSetting.category', 'fields'=>array('UserSetting.category'), 'nosearch'=>true));

		$settingCategories = array();
		if($select) {
			$settingCategories['']=__('Select Category');
		}
		foreach($res as $row) {
			$settingCategories[$row['UserSetting']['category']] = ucwords(strtolower($row['UserSetting']['category']));
		}
		$settingCategories = array_merge($settingCategories, $defaultCategories);
		ksort($settingCategories);
		return $settingCategories;
	}
}