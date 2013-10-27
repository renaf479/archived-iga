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
class AutocompleteController extends UserMgmtAppController {
	/**
	 * It displays search suggestions on search filter form
	 *
	 * @access public
	 * @param string $model model name to identify table
	 * @param string $field model field name to identify table column name
	 * @return String
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		if(isset($this->Security) && $this->RequestHandler->isAjax()){
			$this->Security->csrfCheck = false;
			$this->Security->validatePost = false;
		}
	}
	public function fetch($model, $field) {
		$resultToPrint=array();
		if($this->RequestHandler->isAjax()) {
			$results = array();
			if(isset($_GET['term'])) {
				$query = $_GET['term'];
				$this->loadModel($model);
				if(!empty($this->$model->virtualFields)) {
					foreach($this->$model->virtualFields as $vf=>$of) {
						if($field == $vf) {
							$field = str_replace($model.'.', '', $of);
						}
					}
				}
				$results = $this->$model->find('all', array(
				   'conditions'=>array(
					   $model . "." . $field . " LIKE '%" . $query . "%'"
				   ), 'fields'=>array(
					   "DISTINCT(".$model . "." . $field.")"
				   )
				));
			}
			foreach($results as $res) {
				$resultToPrint[]=array('name'=>$res[$model][$field]);
			}
		}
		echo json_encode($resultToPrint);
		exit;
	}
}