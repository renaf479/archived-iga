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
<div id="updateUserEmailTemplateIndex">
	<?php echo $this->Search->searchForm('UserEmailTemplate', array('legend' => false, 'updateDivId' => 'updateUserEmailTemplateIndex')); ?>
	<?php echo $this->element('Usermgmt.paginator', array('useAjax' => true, 'updateDivId' => 'updateUserEmailTemplateIndex')); ?>

	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th><?php echo __('SL');?></th>
				<th><?php echo $this->Paginator->sort('UserEmailTemplate.template_name', __('Template Name')); ?></th>
				<th><?php echo __('Header');?></th>
				<th><?php echo __('Footer');?></th>
				<th><?php echo $this->Paginator->sort('UserEmailTemplate.created', __('Created')); ?></th>
				<th><?php echo __('Action');?></th>
			</tr>
		</thead>
		<tbody>
	<?php   if (!empty($userEmailTemplates)) {
				$page = $this->request->params['paging']['UserEmailTemplate']['page'];
				$limit = $this->request->params['paging']['UserEmailTemplate']['limit'];
				$i=($page-1) * $limit;
				foreach ($userEmailTemplates as $row) {
					$i++;
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$row['UserEmailTemplate']['template_name']."</td>";
					echo "<td>".nl2br($row['UserEmailTemplate']['header'])."</td>";
					echo "<td>".nl2br($row['UserEmailTemplate']['footer'])."</td>";
					echo "<td>".date('d-M-Y',strtotime($row['UserEmailTemplate']['created']))."</td>";
					echo "<td>";
					echo "<div class='btn-group'>";
						echo "<button class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button>";
						echo "<ul class='dropdown-menu'>";
							echo "<li>".$this->Html->link(__('Edit Template'), array('controller'=>'UserEmailTemplates', 'action'=>'edit', $row['UserEmailTemplate']['id'], 'page'=>$page), array('escape'=>false))."</li>";

							echo "<li>".$this->Form->postLink(__('Delete Template'), array('controller'=>'UserEmailTemplates', 'action' => 'delete', $row['UserEmailTemplate']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to delete this template?')))."</li>";
						echo "</ul>";
					echo "</div>";
					echo "</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan=6><br/><br/>".__('No Data')."</td></tr>";
			} ?>
		</tbody>
	</table>
	<?php if(!empty($userEmailTemplates)) { echo $this->element('Usermgmt.pagination', array("totolText" => __('Number of Templates'))); } ?>
</div>