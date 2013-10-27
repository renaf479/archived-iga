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
?>
<div class="um-panel">
	<div class="um-panel-header">
		<span class="um-panel-title">
			<?php echo __('Add Group') ?>
		</span>
		<span class="um-panel-title-right">
			<?php echo $this->Html->link(__('Back', true), array('action'=>'index'));?>
		</span>
	</div>
	<div class="um-panel-content">
		<?php echo $this->element('Usermgmt.ajax_validation', array('formId' => 'addGroupForm', 'submitButtonId' => 'addGroupSubmitBtn')); ?>
		<?php echo $this->Form->create('UserGroup', array('id'=>'addGroupForm', 'class'=>'form-horizontal')); ?>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Group Name');?></label>
			<div class="controls">
				<?php echo $this->Form->input('name', array('label'=>false, 'div'=>false)); ?>
				<span class='tagline'><?php echo __('for ex. Business User');?></span>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Alias Group Name');?></label>
			<div class="controls">
				<?php echo $this->Form->input('alias_name', array('label'=>false, 'div'=>false)); ?>
				<span class='tagline'><?php echo __('for ex. Business_User (Must not contain space)');?></span>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Parent Group');?></label>
			<div class="controls">
				<?php echo $this->Form->input('parent_id', array('type' => 'select', 'label'=>false, 'div'=>false, 'options'=>$parentGroups)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Description');?></label>
			<div class="controls">
				<?php echo $this->Form->input('description', array('type'=>'textarea', 'label'=>false, 'div'=>false)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
		<?php   if(!isset($this->request->data['UserGroup']['allowRegistration'])) {
					$this->request->data['UserGroup']['allowRegistration']=false;
				} ?>
			<label class="control-label"><?php echo __('Allow Registration');?></label>
			<div class="controls">
				<?php echo $this->Form->input('allowRegistration', array('type'=>'checkbox', 'label'=>false, 'div'=>false)); ?>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit('Add Group', array('class'=>'btn btn-primary', 'id'=>'addGroupSubmitBtn')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
		<div style='padding:5px'><?php echo __('Note: If you add a new group then you should give permissions to this newly created Group.');?></div>
	</div>
</div>