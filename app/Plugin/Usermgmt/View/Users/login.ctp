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
<div class="row">
	<div class="um-panel span6 offset3">
		<div class="um-panel-header">
			<span class="um-panel-title">
				<?php
					echo __('Sign In');
					if(SITE_REGISTRATION) {
						echo ' '.__('or');
					}?>
			</span>
			<?php if(SITE_REGISTRATION) { ?>
			<span class="um-panel-title">
				<?php echo $this->Html->link(__('Sign Up', true), '/register');?>
			</span>
			<?php } ?>
		</div>
		<div class="um-panel-content">
			<?php echo $this->element('Usermgmt.ajax_validation', array('formId' => 'loginForm', 'submitButtonId' => 'loginSubmitBtn')); ?>
			<?php echo $this->Form->create('User', array('id'=>'loginForm', 'class'=>'form-horizontal')); ?>
			<div class="um-form-row control-group">
				<label class="control-label required"><?php echo __('Email / Username');?></label>
				<div class="controls">
					<?php echo $this->Form->input('email', array('type'=>'text', 'label'=>false, 'div'=>false, 'placeholder'=>__('Email / Username'))); ?>
				</div>
			</div>
			<div class="um-form-row control-group">
				<label class="control-label required"><?php echo __('Password');?></label>
				<div class="controls">
					<?php echo $this->Form->input('password', array('type'=>'password', 'label'=>false, 'div'=>false, 'placeholder'=>__('Password'))); ?>
				</div>
			</div>
			<?php if(USE_REMEMBER_ME) { ?>
			<div class="um-form-row control-group">
			<?php   if(!isset($this->request->data['User']['remember'])) {
						$this->request->data['User']['remember']=true;
					} ?>
				<label class="control-label"><?php echo __('Remember me');?></label>
				<div class="controls">
					<?php echo $this->Form->input('remember', array('type'=>'checkbox', 'label'=>false, 'div'=>false)); ?>
				</div>
			</div>
			<?php } ?>
			<?php if($this->UserAuth->canUseRecaptha('login')) { ?>
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
				<?php echo $this->Form->Submit('Sign In', array('div'=>false, 'class'=>'btn btn-primary', 'id'=>'loginSubmitBtn')); ?>
				<?php echo $this->Html->link(__('Forgot Password?'), '/forgotPassword', array('class'=>'right btn')); ?>
				<?php echo $this->Html->link(__('Email Verification'), '/emailVerification', array('class'=>'right btn')); ?>
			</div>
			<?php echo $this->Form->end(); ?>
			<?php echo $this->element('Usermgmt.provider'); ?>
		</div>
	</div>
</div>