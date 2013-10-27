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
<style type="text/css">
	.radio label {
		float:left;
		margin-right:30px;
	}
	.chzn-container {
		width:100% !important;
	}
	.chzn-choices .search-field .default {
		width:auto !important;
	}
	.chzn-container .chzn-drop {
		width:100% !important;
	}
</style>
<script type="text/javascript">
$(document).ready(function(e) {
	if($.fn.chosen) {
		$("#UserEmailUserGroupId").chosen();
		$("#UserEmailUserId").ajaxChosen({
			dataType: 'json',
			type: 'POST',
			url: urlForJs+'usermgmt/Users/searchEmails'
		},{
			loadingImg: urlForJs+'usermgmt/img/loading-circle.gif'
		});
	}
	$('#UserEmailTypeUSERS').click(function() {
		$("#groupSearch").hide();
		$("#manualEmail").hide();
		$("#userSearch").show();
	});
	$('#UserEmailTypeGROUPS').click(function() {
		$("#userSearch").hide();
		$("#manualEmail").hide();
		$("#groupSearch").show();
	});
	$('#UserEmailTypeMANUAL').click(function() {
		$("#userSearch").hide();
		$("#groupSearch").hide();
		$("#manualEmail").show();
	});
});
</script>
<div class="um-panel">
	<div class="um-panel-header">
		<span class="um-panel-title">
			<?php echo __('Send Mail') ?>
		</span>
		<span class="um-panel-title-right">
			<?php echo $this->Html->link(__('Back', true), array('action'=>'index'));?>
		</span>
	</div>
	<div class="um-panel-content">
		<?php echo $this->element('Usermgmt.ajax_validation', array('formId' => 'sendMailForm', 'submitButtonId' => 'sendMailSubmitBtn')); ?>
		<?php echo $this->Form->create('UserEmail', array('id'=>'sendMailForm', 'class'=>'form-horizontal', 'novalidate'=>true)); ?>
		<?php
			$userSearch = 'none';
			$groupSearch = 'none';
			$manualEmail = 'none';
			if(!isset($this->data['UserEmail']['type']) || (isset($this->data['UserEmail']['type']) && $this->data['UserEmail']['type']=='USERS')) {
				$userSearch = '';
			}
			if(isset($this->data['UserEmail']['type']) && $this->data['UserEmail']['type']=='GROUPS') {
				$groupSearch = '';
			}
			if(isset($this->data['UserEmail']['type']) && $this->data['UserEmail']['type']=='MANUAL') {
				$manualEmail = '';
			}
		?>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Type');?></label>
			<div class="controls radio">
				<?php echo $this->Form->radio('type', array('USERS' => 'Selected Users', 'GROUPS' => 'Group Users', 'MANUAL' => 'Manual Emails'), array('legend'=>false, 'default'=>'USERS', 'autocomplete'=>'off')); ?>
			</div>
		</div>
		<div class="um-form-row control-group" id='groupSearch' style="display:<?php echo $groupSearch; ?>">
			<label class="control-label required"><?php echo __('Select Groups(s)');?></label>
			<div class="controls">
				<?php echo $this->Form->input('user_group_id', array('div'=>false, 'label'=>false, 'options'=>$groups, 'multiple' => true, 'autocomplete'=>'off', 'data-placeholder'=>'Select Group(s)')); ?>
			</div>
		</div>
		<div class="um-form-row control-group" id='userSearch' style="display:<?php echo $userSearch; ?>">
			<label class="control-label required"><?php echo __('Select User(s)');?></label>
			<div class="controls">
				<?php echo $this->Form->input('user_id', array('type' => 'select', 'multiple' => true, 'options'=>$sel_users, 'label' => false, 'div' => false, 'autocomplete'=>'off', 'data-placeholder'=>'Select User(s)'));?>
			</div>
		</div>
		<div class="um-form-row control-group" id='manualEmail' style="display:<?php echo $manualEmail; ?>">
			<label class="control-label required"><?php echo __('To Email(s)');?></label>
			<div class="controls">
				<?php echo $this->Form->input('to_email', array('type' => 'textarea', 'label' => false, 'div' => false, 'class'=>'span4'));?>
				<span class='tagline'><?php echo __('multiple emails comma separated');?></span>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('CC To');?></label>
			<div class="controls">
				<?php echo $this->Form->input('cc_to', array('type'=>'text', 'label'=>false, 'div'=>false, 'class'=>'span4')); ?>
				<span class='tagline'><?php echo __('multiple emails comma separated');?></span>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('From Name');?></label>
			<div class="controls">
				<?php echo $this->Form->input('from_name', array('label'=>false, 'div'=>false, 'class'=>'span4')); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('From Email');?></label>
			<div class="controls">
				<?php echo $this->Form->input('from_email', array('label'=>false, 'div'=>false, 'class'=>'span4')); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Subject');?></label>
			<div class="controls">
				<?php echo $this->Form->input('subject', array('label'=>false, 'div'=>false, 'class'=>'span4')); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Select Template');?></label>
			<div class="controls">
				<?php echo $this->Form->input('template', array('div'=>false, 'label'=>false, 'options'=>$templates, 'autocomplete'=>'off')); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Select Signature');?></label>
			<div class="controls">
				<?php echo $this->Form->input('signature', array('div'=>false, 'label'=>false, 'options'=>$signatures, 'autocomplete'=>'off')); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Message');?></label>
			<div class="controls">
				<?php  echo $this->Ckeditor->textarea('UserEmail.message', array('type' => 'textarea', 'label' => false, 'div' => false, 'style'=>'height:400px', 'class'=>'span6'), array('language'=>'en', 'uiColor'=> '#14B8C4'), 'full');?>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit('Next', array('class'=>'btn btn-primary', 'id'=>'sendMailSubmitBtn')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>