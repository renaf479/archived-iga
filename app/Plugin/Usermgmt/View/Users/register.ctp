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
			<?php echo __('Sign Up or') ?>
		</span>
		<span class="um-panel-title">
			<?php echo $this->Html->link(__('Sign In', true), array('controller'=>'Users', 'action'=>'login', 'plugin'=>'usermgmt'));?>
		</span>
	</div>
	<div class="um-panel-content">
		<div class="row">
			<div class="span6">
				<?php echo $this->element('Usermgmt.ajax_validation', array('formId' => 'registerForm', 'submitButtonId' => 'registerSubmitBtn')); ?>
				<?php echo $this->Form->create('User', array('id'=>'registerForm', 'class'=>'form-horizontal')); ?>
				<?php if (count($userGroups) >2) { ?>
				<div class="um-form-row control-group">
					<label class="control-label required"><?php echo __('Group');?></label>
					<div class="controls">
						<?php echo $this->Form->input('user_group_id', array('type' => 'select', 'label'=>false, 'div'=>false)); ?>
					</div>
				</div>
				<?php } ?>
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
					<label class="control-label required"><?php echo __('Password');?></label>
					<div class="controls">
						<?php echo $this->Form->input('password', array('type'=>'password', 'label'=>false, 'div'=>false)); ?>
					</div>
				</div>
				<div class="um-form-row control-group">
					<label class="control-label required"><?php echo __('Confirm Password');?></label>
					<div class="controls">
						<?php echo $this->Form->input('cpassword', array('type'=>'password', 'label'=>false, 'div'=>false)); ?>
					</div>
				</div>
				<?php if($this->UserAuth->canUseRecaptha('registration')) { ?>
				<div class="um-form-row control-group">
					<?php   $this->Form->unlockField('recaptcha_challenge_field');
							$this->Form->unlockField('recaptcha_response_field'); ?>
					<label class="control-label required"><?php echo __('Prove you\'re not a robot');?></label>
					<div class="controls">
						<?php echo $this->UserAuth->showCaptcha(isset($this->validationErrors['User']['captcha'][0]) ? $this->validationErrors['User']['captcha'][0] : ""); ?>
					</div>
				</div>
				<?php } ?>
				<div class="um-button-row">
					<?php echo $this->Form->Submit('Sign Up', array('div'=>false, 'class'=>'btn btn-primary', 'id'=>'registerSubmitBtn')); ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
			<div class="span5 right">
				<?php echo $this->element('Usermgmt.provider'); ?>
			</div>
		</div>
	</div>
</div>