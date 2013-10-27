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
			<?php echo __('Edit Setting') ?>
		</span>
		<span class="um-panel-title-right">
			<?php $page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1; ?>
			<?php echo $this->Html->link(__('Back', true), array('action'=>'index', 'page'=>$page));?>
		</span>
	</div>
	<div class="um-panel-content">
		<?php echo $this->Form->create('UserSetting', array('class'=>'form-horizontal')); ?>
		<?php echo $this->Form->hidden('id'); ?>
		<div class="um-form-row control-group">
			<label class="control-label"><?php echo __('Setting Category');?></label>
			<div class="controls">
				<?php echo $this->Form->input('category', array('label'=>false, 'div'=>false, 'options'=>$settingCategories)); ?>
			</div>
		</div>
		<div class="um-form-row control-group">
			<label class="control-label required"><?php echo $userSetting['UserSetting']['name_public'];?></label>
			<div class="controls">
			<?php   if($userSetting['UserSetting']['type']=='checkbox') {
						echo $this->Form->input('value', array('type'=>'checkbox', 'label' => false, 'div' => false));
					} else {
						echo $this->Form->input('value', array('label' => false, 'div' => false, 'class'=>'span6'));
					}
				?>
			</div>
		</div>
		<div class="um-button-row">
			<?php echo $this->Form->Submit('Update Setting', array('class'=>'btn btn-primary')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>