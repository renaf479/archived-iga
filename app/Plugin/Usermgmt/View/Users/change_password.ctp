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
			<?php echo __('Change Password') ?>
		</span>
	</div>
	<div class="um-panel-content">
		<?php echo $this->Form->create('User', array('class'=>'form-horizontal')); ?>
		<?php if(!$this->Session->check('UserAuth.FacebookChangePass') && !$this->Session->check('UserAuth.TwitterChangePass') && !$this->Session->check('UserAuth.GmailChangePass') && !$this->Session->check('UserAuth.LinkedinChangePass') && !$this->Session->check('UserAuth.FoursquareChangePass') && !$this->Session->check('UserAuth.YahooChangePass')){ ?>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Old Password');?></label>
			<div class="controls">
				<?php echo $this->Form->input('oldpassword', array('type'=>'password', 'label'=>false, 'div'=>false)); ?>
			</div>
		</div>
		<?php } ?>
		<?php if($this->Session->check('UserAuth.TwitterChangePass') || ($this->Session->check('UserAuth.LinkedinChangePass') && !$this->Session->check('UserAuth.LinkedinEmail'))) { ?>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('Email');?></label>
			<div class="controls">
				<?php echo $this->Form->input('email', array('label'=>false, 'div'=>false)); ?>
				<?php
					if(($this->Session->check('UserAuth.TwitterChangePass') || $this->Session->check('UserAuth.LinkedinChangePass')) && isset($this->validationErrors['User']['email']) && $this->validationErrors['User']['email'][0]==__('This email is already registered')) {
						echo __('If this email is yours please verify');
						echo $this->Form->Submit(__('Verify'), array('div'=>false, 'name'=>'verify', 'class'=>'btn'));
						if($this->Session->check('UserAuth.EmailVerifyCode')) {
							echo __('Verification Code');
							echo $this->Form->input('emailVerifyCode', array('label' => false, 'div'=> false, 'style'=>'width:50px'));
						}
					}
				?>
			</div>
		</div>
		<?php } ?>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo __('New Password');?></label>
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
		<div class="um-button-row">
			<?php echo $this->Form->Submit('Change Password', array('div'=>false, 'class'=>'btn btn-primary')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>