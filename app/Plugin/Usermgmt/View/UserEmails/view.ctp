<div class="um-panel">
	<div class="um-panel-header">
		<span class="um-panel-title">
			<?php echo __('Email Details') ?>
		</span>
		<span class="um-panel-title-right">
			<?php $page= (isset($this->request->params['named']['page'])) ? $this->request->params['named']['page'] : 1; ?>
			<?php echo $this->Html->link(__('Back', true), array('action'=>'index', 'page'=>$page));?>
		</span>
	</div>
	<div class="um-panel-content">
		<table class="table table-striped table-bordered">
			<tr>
				<th>Type</th>
				<td>
				<?php   if($userEmail['UserEmail']['type']=='USERS') {
							echo "Selected Users";
						} else if($userEmail['UserEmail']['type']=='GROUPS') {
							echo "Group Users";
						} else {
							echo "Manual Emails";
						} ?>
				</td>
			</tr>
			<?php if($userEmail['UserEmail']['type']=='GROUPS') { ?>
				<tr><th>Groups(s)</th><td><?php echo $userEmail['UserEmail']['group_name'];?></td></tr>
			<?php } ?>
			<tr><th>Cc To</th><td><?php echo $userEmail['UserEmail']['cc_to'];?></td></tr>
			<tr><th>From Name</th><td><?php echo $userEmail['UserEmail']['from_name'];?></td></tr>
			<tr><th>From Email</th><td><?php echo $userEmail['UserEmail']['from_email'];?></td></tr>
			<tr><th>Subject</th><td><?php echo $userEmail['UserEmail']['subject'];?></td></tr>
			<tr><th>Message</th><td><?php echo $userEmail['UserEmail']['message'];?></td></tr>
			<tr><th>Sent By</th><td><?php echo $userEmail['User']['first_name'].' '.$userEmail['User']['last_name'];?></td></tr>
			<tr>
				<th>Sent?</th>
				<td>
				<?php   if ($userEmail['UserEmail']['is_email_sent']==1) {
							echo "<span style='color:green;font-weight:bold'>Yes</span>";
						} else {
							echo "<span style='color:red;font-weight:bold'>No</span>";
						}?>
				</td>
			</tr>
			<tr><th>Date Sent</th><td><?php echo date('d-M-Y H:i:s', strtotime($userEmail['UserEmail']['created']));?></td></tr>

		</table>
	</div>
</div>
<div class="um-panel">
	<div class="um-panel-header">
		<span class="um-panel-title">
			<?php echo __('Email Recipients') ?>
		</span>
	</div>
	<div class="um-panel-content">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th><?php echo __('Id');?></th>
					<th><?php echo __('Name');?></th>
					<th><?php echo __('Email');?></th>
					<th><?php echo __('Sent?');?></th>
				</tr>
			</thead>
			<tbody>
	<?php       if (!empty($userEmailRecipients)) {
					foreach ($userEmailRecipients as $row) {
						echo "<tr>";
						echo "<td>".$row['UserEmailRecipient']['id']."</td>";
						echo "<td>".$row['User']['first_name'].' '.$row['User']['last_name']."</td>";
						echo "<td>".$row['UserEmailRecipient']['email_address']."</td>";
						echo "<td>";
						if($row['UserEmailRecipient']['is_email_sent']) {
							echo "<span style='color:green;font-weight:bold'>Sent</span>";
						} else {
							echo "<span style='color:red;font-weight:bold'>Not Sent</span>";
						}
						echo "</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan=7><br/><br/>".__('No Data')."</td></tr>";
				} ?>
			</tbody>
		</table>
	</div>
</div>