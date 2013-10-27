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
<?php echo $this->Html->script(array('/usermgmt/js/umupdate.js?q='.QRDN)); ?>
<div class="um-panel">
	<div class="um-panel-header">
		<span class="um-panel-title">
			<?php echo __('Sub Group Permissions') ?>
		</span>
		<span class="um-panel-title">
			<?php echo $this->Html->link(__('View Matrix', true), '/permissionSubGroupMatrix');?>
		</span>
		<span class="um-panel-title-right">
			<?php echo __('Controller');?>
			<?php echo $this->Form->input('controller', array('type'=>'select', 'div'=>false, 'options'=>$allControllers, 'selected'=>$c, 'label'=>false, 'onchange'=>"window.location='".SITE_URL."subPermissions/?g=".$group_id."&c='+(this).value"))?>
		</span>
		<span class="um-panel-title-right">
			<?php echo __('Get Sub Groups of');?>
			<?php echo $this->Form->input('controller', array('type'=>'select', 'div'=>false, 'options'=>$parentGroups, 'selected'=>$group_id, 'label'=>false, 'onchange'=>"window.location='".SITE_URL."subPermissions/?g='+(this).value"))?>
		</span>
	</div>
	<div class="um-panel-content">
<?php   if (!empty($controllers)) { ?>
			<input type="hidden" id="BASE_URL" value="<?php echo SITE_URL;?>">
			<input type="hidden" id="groups" value="<?php echo $groups;?>">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th><?php echo __("Controller");?></th>
						<th><?php echo __("Action");?></th>
						<th><?php echo __("Permission");?></th>
						<th style='width:125px'><?php echo __("Operation");?></th>
					</tr>
				</thead>
				<tbody>
	<?php
			$k=1;
			foreach ($controllers as $key=>$value) {
				if (!empty($value)) {
					for ($i=0; $i<count($value); $i++) {
						if (isset($value[$i])) {
							$action=$value[$i];
							echo $this->Form->create();
							echo $this->Form->hidden('controller',array('id'=>'controller'.$k,'value'=>$key));
							echo $this->Form->hidden('action',array('id'=>'action'.$k,'value'=>$action));
							echo "<tr>";
							echo "<td>".$key."</td>";
							echo "<td>".$action;
							if(!empty($funcDesc[$key][$action])) {
								echo "<br/><span style='color:red;font-size:10px;font-style:italic'>".$funcDesc[$key][$action]."</span>";
							}
							echo "</td>";
							echo "<td>";
							$url=$key."/".$action;
							foreach ($subGroups as $subGroup) {
								$ugname=$subGroup['name'];
								$ugname_alias=$subGroup['alias_name'];
								$inherit='';
								if (isset($value[$action][$ugname_alias]) && $value[$action][$ugname_alias]==1) {
									$checked=true;
								} else if(isset($value[$action][$ugname_alias]) && $value[$action][$ugname_alias]==0) {
									$checked=false;
								} else {
									$inherit='(Inherit)';
									if(isset($finalPermissions[$url]) && $finalPermissions[$url]['allowed']==1) {
										$checked=true;
									} else {
										$checked=false;
									}
								}
								echo $this->Form->input($ugname, array('id'=>$ugname_alias.$k, 'type'=>'checkbox', 'checked'=>$checked, 'label'=>false, 'div'=>false, 'style'=>'margin: 3px 4px'));
								echo " <label style='width:auto;display: inline;' for='".$ugname_alias.$k."'>".$ugname."</label>";
								echo " <span style='color:green'>".$inherit."</span><br/>";
							}
							echo "</td>";
							echo "<td>";
							echo $this->Form->button('Update', array('type'=>'button', 'name'=>$k,'onClick'=>'javascript:update_fields('.$k.');', 'class'=>'btn btn-primary'));
							echo "<div id='updateDiv".$k."' align='right' style='display: inline;'>&nbsp;</div>";
							echo "</td>";
							echo "</tr>";
							echo $this->Form->end();
							$k++;
						}
					}
				}
			} ?>
				</tbody>
			</table>
<?php   }   ?>
	</div>
</div>