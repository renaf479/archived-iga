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
	$(function(){
		$('.emailcheckall').change(function() {
			if ($(this).is(':checked')) {
				$(".emailcheck").prop("checked", true);
			} else {
				$(".emailcheck").prop("checked", false);
			}
		});
	});
	function validateForm() {
		if (!$(".emailcheck").is(':checked')) {
			alert('Please select atleast one student to send email');
			return false;
		} else {
			if (!confirm('Are you sure, you want to continue sending emails?')) {
				return false;
			}
		}
		return true;
	}
</script>
<div class="um-panel">
	<div class="um-panel-header">
		<span class="um-panel-title">
			<?php echo __('Confirm Sending Email') ?>
		</span>
		<span class="um-panel-title-right">
			<?php echo $this->Html->link(__('Edit', true), array('action'=>'send'));?>
		</span>
	</div>
	<div class="um-panel-content">
		<?php echo $this->Form->create('UserEmail', array('action'=>'send/confirm', 'onSubmit'=>'return validateForm()')); ?>
		<table class="table" style="width:auto">
			<tr>
				<th>Email Type</th>
				<td>
				<?php   if($data['UserEmail']['type']=='USERS') {
							echo "Selected Users";
						} else if($data['UserEmail']['type']=='GROUPS') {
							echo "Group Users";
						} else {
							echo "Manual Emails";
						}
				?>
				</td>
			</tr>
			<?php if($data['UserEmail']['type']=='GROUPS') { ?>
			<tr>
				<th>Group(s)</th>
				<td>
				<?php   $groupNames=array();
						foreach($data['UserEmail']['user_group_id'] as $groupId) {
							$groupNames[]=$groups[$groupId];
						}
						echo implode(', ', $groupNames);
				?>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<th>CC Email(s)</th>
				<td><?php echo $data['UserEmail']['cc_to']; ?></td>
			</tr>
			<tr>
				<th>From Name</th>
				<td><?php echo $data['UserEmail']['from_name']; ?></td>
			</tr>
			<tr>
				<th>From Email</th>
				<td><?php echo $data['UserEmail']['from_email']; ?></td>
			</tr>
			<tr>
				<th>Email Subject</th>
				<td><?php echo $data['UserEmail']['subject']; ?></td>
			</tr>
			<tr>
				<th>Email Message</th>
				<td>
				<?php
					$message = '';
					if(!empty($template['UserEmailTemplate']['header'])) {
						$message .= nl2br($template['UserEmailTemplate']['header'])."<br/><br/>";
					}
					$message .= $data['UserEmail']['message'];
					if(!empty($signature['UserEmailSignature']['signature'])) {
						$message .= "<br/>".$signature['UserEmailSignature']['signature'];
					}
					if(!empty($template['UserEmailTemplate']['footer'])) {
						$message .= "<br/>".nl2br($template['UserEmailTemplate']['footer']);
					}
					echo $message;
				?>
				</td>
			</tr>
		</table>

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('Sr No.');?></th>
					<th><?php echo $this->Form->input('sel_all', array('type'=>'checkbox', 'label' => false, 'checked' => true, 'hiddenField' => false, 'class'=>'emailcheckall')); ?></th>
					<th><?php echo __('Name');?></th>
					<th><?php echo __('Email');?></th>
				</tr>
			</thead>
			<tbody>
	<?php       if (!empty($users)) {
					$i=1;
					foreach ($users as $row) {
						$trclass='';
						$checked=true;
						$cls = 'emailcheck';
						if(empty($row['User']['email'])) {
							$trclass='error';
							$checked=false;
							$cls = '';
						}
						echo "<tr class='".$trclass."'>";
						echo "<td>".$i."</td>";
						echo "<td>";
						echo $this->Form->input('email.'.$i.'.emailcheck', array('type'=>'checkbox', 'label' => false,'checked' => $checked, 'hiddenField' => false, 'class'=>$cls));
						echo $this->Form->input('email.'.$i.'.uid', array('type'=>'hidden', 'value'=>$row['User']['id']));
						echo $this->Form->input('email.'.$i.'.email', array('type'=>'hidden', 'value'=>$row['User']['email']));
						echo "</td>";
						echo "<td>".$row['User']['first_name']." ".$row['User']['last_name']."</td>";
						echo "<td>".$row['User']['email']."</td>";
						echo "</tr>";
						$i++;
					}
				} else {
					echo "<tr><td colspan=7><br/><br/>".__('No Data')."</td></tr>";
				} ?>
			</tbody>
		</table>
		<div class="um-button-row">
			<?php echo $this->Form->Submit('Send Mail', array('class'=>'btn btn-primary')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>