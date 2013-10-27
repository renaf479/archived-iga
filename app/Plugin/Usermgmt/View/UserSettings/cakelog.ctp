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
			<?php echo __('Cake Logs') ?>
		</span>
	</div>
	<div class="um-panel-content">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('SL');?></th>
					<th><?php echo __('Log File');?></th>
					<th><?php echo __('Size');?></th>
					<th><?php echo __('Last Modified');?></th>
					<th style="width:150px;"><?php echo __('Action');?></th>
				</tr>
			</thead>
			<tbody>
		<?php   $i=0;
				foreach($logFiles as $logFile) {
					$i++;
					$pathinfo = pathinfo($logFile);
					$filesize =round((filesize($logFile) / 1024), 2);
					$filesizeText = $filesize.' KB';
					if($filesize > 1024) {
						$filesize =round(($filesize / 1024), 2);
						$filesizeText = $filesize.' MB';
					}
					$filemtime = filemtime($logFile);
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$pathinfo['basename']."</td>";
					echo "<td>".$filesizeText."</td>";
					echo "<td>".date('d-M-Y h:i:s A',$filemtime)."</td>";
					echo "<td class='action'>";
						echo $this->Html->link(__('View/Edit', true), array('action'=>'cakelog', $pathinfo['basename']));
						echo "<br/>";
						echo $this->Html->link(__('Create Backup Copy', true), array('action'=>'cakelogbackup', $pathinfo['basename']), array('confirm'=>__('Are you sure, you want to create a copy of ').$pathinfo['basename'].'?'));
						echo "<br/>";
						echo $this->Html->link(__('Delete', true), array('action'=>'cakelogdelete', $pathinfo['basename']), array('confirm'=>__('Are you sure, you want to delete log file ').$pathinfo['basename'].'?'));
						echo "<br/>";
						echo $this->Html->link(__('Empty File', true), array('action'=>'cakelogempty', $pathinfo['basename']), array('confirm'=>__('Are you sure, you want to empty log file ').$pathinfo['basename'].'? '.__('You should create a backup before doing empty this file.')));
					echo "</td>";
					echo "</tr>";
				} ?>
			</tbody>
		</table>
		<div style='padding:15px'>
			<?php echo __('I recommend to take a backup log files then make empty them weekly or monthly. It can improve site performance.');?>
			<br/><br/>

	<?php   if(!empty($filename)) { ?>
				<div style='float:right;'><?php echo $this->Html->link(__('Close', true), array('action'=>'cakelog'), array('class'=>'btn btn-primary'));?></div>
				<h4><?php echo $filename.__(' details');?></h4>
				<div class='clearfix'></div>
	<?php       $filepath= LOGS.$filename;
				$filesize =round((filesize($filepath) / 1024), 1);
				$pathinfo = pathinfo($filepath);
				echo $this->Form->create('UserSetting', array('onsubmit'=>'return confirm("Are you sure, Saving this file will overwrite existing file")')); ?>
				<textarea id="UserSettingLogfile" style="width:99%;height:800px" name="data[UserSetting][logfile]"><?php echo file_get_contents($filepath);?></textarea>
				<div class="um-button-row">
					<?php echo $this->Form->Submit('Save', array('class'=>'btn btn-primary')); ?>
				</div>
				<?php echo $this->Form->end(); ?>
	<?php   } ?>
		</div>
	</div>
</div>