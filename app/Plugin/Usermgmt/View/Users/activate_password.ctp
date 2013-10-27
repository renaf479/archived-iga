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
				<?php echo __('Reset Password') ?>
			</span>
		</div>
		<div class="um-panel-content">
			<?php echo $this->Form->create('User', array('class'=>'form-horizontal')); ?>
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
				<?php   if (!isset($ident)) { $ident=''; }
						if (!isset($activate)) { $activate=''; } ?>
				<?php echo $this->Form->hidden('ident', array('value'=>$ident)); ?>
				<?php echo $this->Form->hidden('activate', array('value'=>$activate)); ?>
				<?php echo $this->Form->Submit('Save New Password', array('div'=>false, 'class'=>'btn btn-primary')); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>