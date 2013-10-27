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
<script type="text/javascript">
$(document).ready(function(e) {
	if($.fn.chosen) {
		$("#UserUserGroupId").chosen();
	}
});
</script>
<div class="um-panel">
	<div class="um-panel-header">
		<span class="um-panel-title">
			<?php echo __('Edit User') ?>
		</span>
		<span class="um-panel-title-right">
			<?php $page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1; ?>
			<?php echo $this->Html->link(__('Back', true), array('action'=>'index', 'page'=>$page));?>
		</span>
	</div>
	<div class="um-panel-content">
		<?php echo $this->element('Usermgmt.ajax_validation', array('formId' => 'editUserForm', 'submitButtonId' => 'editUserSubmitBtn')); ?>
		<?php echo $this->Form->create('User', array('type' => 'file', 'id'=>'editUserForm', 'class'=>'form-horizontal')); ?>
		<?php echo $this->Form->hidden('id'); ?>
		<?php echo $this->Form->hidden('UserDetail.id'); ?>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Group');?></label>
			<div class="controls">
				<?php echo $this->Form->input('user_group_id', array('type' => 'select', 'multiple' => true, 'label'=>false, 'div'=>false, 'data-placeholder'=>'Select Group(s)')); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Username');?></label>
			<div class="controls">
				<?php echo $this->Form->input('username', array('label'=>false, 'div'=>false)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('First Name');?></label>
			<div class="controls">
				<?php echo $this->Form->input('first_name', array('label'=>false, 'div'=>false)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Last Name');?></label>
			<div class="controls">
				<?php echo $this->Form->input('last_name', array('label'=>false, 'div'=>false)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Email');?></label>
			<div class="controls">
				<?php echo $this->Form->input('email', array('label'=>false, 'div'=>false)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Gender');?></label>
			<div class="controls">
				<?php echo $this->Form->input('UserDetail.gender', array('label'=>false, 'div'=>false, 'type' => 'select', 'options'=>$gender)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Marital Status');?></label>
			<div class="controls">
				<?php echo $this->Form->input('UserDetail.marital_status', array('label'=>false, 'div'=>false, 'type' => 'select', 'options'=>$marital)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Birthday');?></label>
			<div class="controls">
				<?php echo $this->Form->input('UserDetail.bday', array('type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'datepicker')); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Cellphone');?></label>
			<div class="controls">
				<?php echo $this->Form->input('UserDetail.cellphone', array('label'=>false, 'div'=>false)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Location');?></label>
			<div class="controls">
				<?php echo $this->Form->input('UserDetail.location', array('label'=>false, 'div'=>false)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Photo');?></label>
			<div class="controls">
				<?php echo $this->Form->input('UserDetail.photo', array('label'=>false, 'div'=>false, 'type' => 'file')); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Web Page');?></label>
			<div class="controls">
				<?php echo $this->Form->input('UserDetail.web_page', array('label'=>false, 'div'=>false, 'type' => 'text')); ?>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit('Update User', array('class'=>'btn btn-primary', 'id'=>'editUserSubmitBtn')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>