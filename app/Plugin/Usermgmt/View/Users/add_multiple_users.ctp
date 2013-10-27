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
	form {
		width:100%
	}
	input, textarea,select {
		font-size: 100%;
	}
</style>
<script type="text/javascript">
	$(function(){
		$('.usercheckall').change(function() {
			if ($(this).is(':checked')) {
				$(".usercheck").prop("checked", true);
			} else {
				$(".usercheck").prop("checked", false);
			}
		});
		if($.fn.chosen) {
			$(".ugroup").chosen();
		}
	});
</script>
<div class="um-panel">
	<div class="um-panel-header">
		<span class="um-panel-title">
			<?php echo __('Add Multiple Users' , true) ?>
		</span>
		<span class="um-panel-title-right">
			<?php echo $this->Html->link(__('Back', true), array('action'=>'uploadCsv'));?>
		</span>
	</div>
	<div class="um-panel-content" >
		<?php echo $this->element('Usermgmt.ajax_validation', array('formId' => 'addMultipleUserForm', 'submitButtonId' => 'addMultipleUserSubmitBtn')); ?>
		<?php echo $this->Form->create('User', array('id'=>'addMultipleUserForm', 'class'=>'form-horizontal')); ?>
		<div style='padding:15px'><strong><?php echo __('Please Note: unchecked row will not save in database.');?></strong></div>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th><?php echo $this->Form->input('Select.all', array('type'=>'checkbox', 'label' => false, 'hiddenField' => false, 'class'=>'usercheckall', 'autocomplete'=>'off')); ?></th>
				<th><?php echo __('User Group');?></th>
				<th><?php echo __('First Name');?></th>
				<th><?php echo __('Last Name');?></th>
				<th><?php echo __('Username');?></th>
				<th><?php echo __('Email');?></th>
				<th><?php echo __('Password');?></th>
				<th><?php echo __('Gender');?></th>
				<th><?php echo __('Birthday');?></th>
				<th><?php echo __('Location');?></th>
				<th><?php echo __('Marital Status');?></th>
				<th><?php echo __('Cellphone');?></th>
				<th><?php echo __('Web Page');?></th>
			</tr>
<?php   $i = 0;
		$total_users = 0;
		if(!empty($this->request->data['User'])) {
			$total_users = count($this->request->data['User']);
		}
		for($c=0; $c<$total_users; $c++) {
			$rowCheck = true;
			?>
			<tr>
				<td style='text-align:center'>
				<?php echo $this->Form->input("usercheck.".$i ,array('type'=>'checkbox', 'label' => false, 'hiddenField' => false, 'class'=>'usercheck', 'autocomplete'=>'off')); ?>
				</td>
				<td><?php echo $this->Form->input('User.'.$i.'.user_group_id', array('type' => 'select', 'options'=>$userGroups, 'multiple' => true, 'label'=>false, 'div'=>false, 'data-placeholder'=>'Select Group(s)', 'class'=>'ugroup', 'style'=>'width:100px')); ?></td>
				<td><?php echo $this->Form->input('User.'.$i.'.first_name', array('type'=>'text', 'div'=>false, 'label'=>false, 'style'=>'width:100px'));?></td>
				<td><?php echo $this->Form->input('User.'.$i.'.last_name', array('type'=>'text', 'div'=>false, 'label'=>false, 'style'=>'width:100px'));?></td>
				<td><?php echo $this->Form->input('User.'.$i.'.username', array('type'=>'text', 'div'=>false, 'label'=>false, 'style'=>'width:100px'));?></td>
				<td><?php echo $this->Form->input('User.'.$i.'.email', array('type'=>'text', 'div'=>false, 'label'=>false, 'style'=>'width:200px'));?></td>
				<td><?php echo $this->Form->input('User.'.$i.'.password', array('type'=>'text', 'div'=>false, 'label'=>false, 'type'=>'text', 'style'=>'width:100px'));?></td>
				<td><?php echo $this->Form->input('UserDetail.'.$i.'.gender', array('type' => 'select', 'options'=>$gender, 'label'=>false, 'div'=>false, 'style'=>'width:85px')); ?></td>
				<td><?php echo $this->Form->input('UserDetail.'.$i.'.bday', array('type'=>'text', 'div'=>false, 'label'=>false, 'style'=>'width:80px', 'class'=>'datepicker'));?></td>
				<td><?php echo $this->Form->input('UserDetail.'.$i.'.location', array('type'=>'text', 'div'=>false, 'label'=>false, 'style'=>'width:50px'));?></td>
				<td><?php echo $this->Form->input('UserDetail.'.$i.'.marital_status', array('type' => 'select', 'options'=>$marital, 'label'=>false, 'div'=>false, 'style'=>'width:85px')); ?></td>
				<td><?php echo $this->Form->input('UserDetail.'.$i.'.cellphone', array('type'=>'text', 'div'=>false, 'label'=>false, 'style'=>'width:100px'));?></td>
				<td><?php echo $this->Form->input('UserDetail.'.$i.'.web_page', array('type'=>'text', 'div'=>false, 'label'=>false));?></td>
			</tr>

<?php   $i++; }
		?>
		</table>
		<div class="um-button-row">
			<?php echo $this->Form->Submit('Add Users', array('class'=>'btn btn-primary', 'id'=>'addMultipleUserSubmitBtn')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
