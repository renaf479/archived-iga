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

App::uses('AppHelper', 'View/Helper');
class CkeditorHelper extends AppHelper {

	// Take advantage of other helpers
	public $helpers = array('Js', 'Html', 'Form');

	// Check if the ckeditor.js file has been added or not
	public $_script = false;

	/**
	* Adds the ckeditor.js file and constructs the options
	*
	* @param string $fieldName Name of a field, like this "Modelname.fieldname"
	* @param array $ckoptions Array of CkEditor attributes for this textarea
	* @return string JavaScript code to initialise the CkEditor area
	*/
	function _build($fieldName, $ckoptions = array(), $toolbar_options=null) {
		if(!$this->_script){
			// We don't want to add this every time, it's only needed once
			$this->_script = true;
			$this->Html->script('ckeditor/ckeditor', array('inline' => false));
		}

		$textAreaId = $this->domId($fieldName);
		// Encode the array in json
		if(!empty($ckoptions)) {
			$json = $this->Js->object($ckoptions);
			$json = rtrim($json, '}');
			$json .= ", ".$toolbar_options."}";
		} else {
			$json = "{".$toolbar_options."}";
		}

		return $this->Html->scriptBlock("CKEDITOR.replace( '".$textAreaId."', ".$json.");");
	}

	/**
	* Creates a CkEditor textarea.
	*
	* @param string $fieldName Name of a field, like this "Modelname.fieldname"
	* @param array $options Array of HTML attributes.
	* @param array $ckoptions Array of CkEditor attributes for this textarea
	* @param string $preset
	* @return string An HTML textarea element with CkEditor
	*/
	function textarea($fieldName, $options = array(), $ckoptions = array(), $preset = null){
		// If a preset is defined
		$toolbar_options=null;
		if(!empty($preset)){
			$toolbar_options = $this->preset($preset);
		}
		return $this->Form->textarea($fieldName, $options). $this->_build($fieldName, $ckoptions, $toolbar_options);
	}

	/**
	* Creates a CkEditor textarea.
	*
	* @param string $fieldName Name of a field, like this "Modelname.fieldname"
	* @param array $options Array of HTML attributes.
	* @param array $ckoptions Array of CkEditor attributes for this textarea
	* @return string An HTML textarea element with CkEditor
	*/
	function input($fieldName, $options = array(), $ckoptions = array(), $preset = null){
		// If a preset is defined
		$toolbar_options=null;
		if(!empty($preset)){
			$toolbar_options = $this->preset($preset);
		}
		$options['type'] = 'textarea';
		return $this->Form->input($fieldName, $options) . $this->_build($fieldName, $ckoptions, $toolbar_options);
	}

	/**
	* Creates a preset for ckoptions
	*
	* @param string $name
	* @return array
	*/
	private function preset($name){
		// Basic
		if($name == 'basic'){
			$toolbar = "toolbar: [
						[ 'Bold', 'Italic' ],
						[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent' ],
						[ 'Link', 'Unlink']
					]";
			return $toolbar;
		}
		// Standard Feature
		if($name == 'standard'){
			$toolbar = "toolbar: [
						[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
						[ 'Scayt' ],
						[ 'Link', 'Unlink', 'Anchor' ],
						[ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ],
						[ 'Maximize' ],
						[ 'Source' ],
						'/',
						[ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ],
						[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ],
						[ 'Styles', 'Format' ]
					]";
			return $toolbar;
		}
		// Full Feature
		if($name == 'full'){
			$toolbar = "toolbar: [
						[ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ],
						[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
						[ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ],
						[ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ],
						'/',
						[ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ],
						[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ],
						[ 'Link', 'Unlink', 'Anchor' ],
						[ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ],
						'/',
						[ 'Styles', 'Format', 'Font', 'FontSize' ],
						[ 'TextColor', 'BGColor' ],
						[ 'Maximize', 'ShowBlocks' ]
					]";
			return $toolbar;
		}
		return null;
	}
}