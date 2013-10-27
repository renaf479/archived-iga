<script type="text/javascript">
	$(function(){
		$('.contcheckall').change(function() {
			if ($(this).is(':checked')) {
				$(".contcheck").prop("checked", true);
			} else {
				$(".contcheck").prop("checked", false);
			}
		});
		$('.grpcheckall').change(function() {
			if ($(this).is(':checked')) {
				$(".grpcheck").prop("checked", true);
			} else {
				$(".grpcheck").prop("checked", false);
			}
		});
		$('#perOptions').click(function() {
			$('#perOptionsDetails').slideToggle();
		});
	});
	function validateForm() {
		if (!$(".contcheck").is(':checked')) {
			alert('Please select atleast one controller to get permissions');
			return false;
		} else {
		}
		return true;
	}
</script>
<div class="um-panel">
	<div class="um-panel-header">
		<span class="um-panel-title">
			<?php echo __('Sub Group Permissions Matrix') ?>
		</span>
		<span class="um-panel-title">
			<?php echo $this->Html->link(__('View Standard', true), '/subPermissions');?>
		</span>
		<span class="um-panel-title-right">
			<?php echo "<a id='perOptions' href='javascript:void(0)'>Choose Options</a>"; ?>
		</span>
		<span class="um-panel-title-right">
			<div id='per_loading_text' style='color:red;text-decoration: blink;'>Please wait while page is loading...</div>
		</span>
	</div>
	<div class="um-panel-content">
		<div style='padding:10px'><?php echo $this->Html->image(SITE_URL.'usermgmt/img/approve.png', array('alt' => __('Yes')));?> = The sub group has permission of controller's action<br/><?php echo $this->Html->image(SITE_URL.'usermgmt/img/dis-approve2.png', array('alt' => __('Yes')));?> = The sub group has not permission of controller's action<br/>
		<span style='color:green'>(inherit)</span> = Permission is from parent group</div>
		<?php   $tDisplay='none';
				if (empty($controllers)) {
					$tDisplay='block';
				} ?>
		<div style='padding:10px; display:<?php echo $tDisplay; ?>' id='perOptionsDetails'>
			<?php echo $this->Form->create('UserGroupPermission', array('onSubmit'=>'return validateForm()')); ?>
			<div style='float:left'>
				<table class="table table-striped table-bordered table-hover" style='width:auto'>
					<thead>
						<tr>
							<th><?php echo $this->Form->input('sel_cont_all', array('type'=>'checkbox', 'label' => false, 'checked' => false, 'hiddenField' => false, 'class'=>'contcheckall')); ?></th>
							<th><?php echo __('Controller');?></th>
						</tr>
					</thead>
					<tbody>
			<?php       if (!empty($allControllers)) {
							foreach ($allControllers as $key=>$cont) {
								$checked=false;
								if(!empty($this->request->data['controller'][$key])) {
									$checked=true;
								}
								echo "<tr>";
								echo "<td>";
								echo $this->Form->input('controller.'.$key.'.contcheck', array('type'=>'checkbox', 'label' => false, 'checked' => $checked, 'hiddenField' => false, 'class'=>'contcheck'));
								echo "</td>";
								echo "<td>".$cont."</td>";
								echo "</tr>";
							}
						} ?>
					</tbody>
				</table>
			</div>
			<div style='float:left'>
				<table class="table table-striped table-bordered table-hover" style='width:auto'>
					<thead>
						<tr>
							<th><?php echo $this->Form->input('sel_grp_all', array('type'=>'checkbox', 'label' => false, 'checked' => false, 'hiddenField' => false, 'class'=>'grpcheckall')); ?></th>
							<th><?php echo __('Sub Group');?></th>
						</tr>
					</thead>
					<tbody>
			<?php       if (!empty($user_groups)) {
							foreach ($user_groups as $key=>$group) {
								$checked=false;
								if(!empty($this->request->data['group'][$group['id']])) {
									$checked=true;
								}
								echo "<tr>";
								echo "<td>";
								echo $this->Form->input('group.'.$group['id'].'.grpcheck', array('type'=>'checkbox', 'label' => false, 'checked' => $checked, 'hiddenField' => false, 'class'=>'grpcheck'));
								echo "</td>";
								echo "<td>".$group['name']."</td>";
								echo "</tr>";
							}
						} ?>
					</tbody>
				</table>
			</div>
			<div style='float:left'>
				<?php echo $this->Form->Submit('Get Permissions', array('class'=>'btn btn-primary')); ?>
			</div>
			<div style='clear:both'></div>
			<?php echo $this->Form->end(); ?>
		</div>
		<?php if (!empty($controllers)) { ?>
			<table class="table table-striped table-bordered table-hover" style='width:auto'>
				<thead>
					<tr id='per_float_header' style='background-color:#CACACA'>
						<th><div style='width:100px'><?php echo __('Controller');?></div></th>
						<th><div style='width:130px'><?php echo __('Action');?></div></th>
				<?php   foreach ($sel_user_groups as $group) {
							echo "<th style='padding:0;text-align:center;'><div style='width:65px'>".$group['name']."</div></th>";
						} ?>
					</tr>
				</thead>
				<tbody>
	<?php           foreach ($controllers as $cont=>$actions) {
						$t=count($actions);
						foreach ($actions as $key=>$action) {
							$url=$cont."/".$action;
							echo "<tr>";
							echo "<td><div class='break-word' style='width:100px'>".$cont."</div></td>";
							echo "<td><div class='break-word' style='width:130px'>".$action;
							if(!empty($funcDesc[$cont][$action])) {
								echo "<br/><span style='color:red;font-size:10px;font-style:italic'>".$funcDesc[$cont][$action]."</span>";
							}
							echo "</div></td>";
							$loadingImg = '<img src="'.SITE_URL.'usermgmt/img/loading-circle.gif">';
							foreach ($sel_user_groups as $group) {
								echo "<td style='text-align:center;padding:5px'><div style='width:55px;height:35px'>";
								$inherit='';
								if (isset($controllerActions[$cont][$action][$group['alias_name']]) && $controllerActions[$cont][$action][$group['alias_name']]==1) {
									$img=$this->Html->image(SITE_URL.'usermgmt/img/approve.png', array('alt' => __('Yes')));
								} else if (isset($controllerActions[$cont][$action][$group['alias_name']]) && $controllerActions[$cont][$action][$group['alias_name']]==0) {
									$img=$this->Html->image(SITE_URL.'usermgmt/img/dis-approve2.png', array('alt' => __('No')));
								} else {
									$inherit='(Inherit)';
									if(isset($parentPermissions[$url]) && $parentPermissions[$url]['allowed']==1) {
										$img=$this->Html->image(SITE_URL.'usermgmt/img/approve.png', array('alt' => __('Yes')));
									} else {
										$img=$this->Html->image(SITE_URL.'usermgmt/img/dis-approve2.png', array('alt' => __('No')));
									}
								}
								echo $this->Js->link($img, array('action' => 'changePermission', $cont, $action, $group['id']), array('escape' => false, 'title' => $group['name'].' (Click to change permission)', 'before'=>"var targetId = event.currentTarget.id; $('#'+targetId).html('".$loadingImg."');", 'success'=>"var targetId = event.currentTarget.id; if(data) { $('#'+targetId).html(data); }"));
								echo " <span style='color:green'>".$inherit."</span><br/>";
								echo "</div></td>";
							}
							echo "</tr>";
						}
						echo "<tr><td colspan='".(count($sel_user_groups) + 2)."'><br/></td></tr>";
					}  ?>
				</tbody>
			</table>
<?php   } ?>
	</div>
</div>
<?php echo $this->Js->writeBuffer(); ?>