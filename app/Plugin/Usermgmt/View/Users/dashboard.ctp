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
			<?php echo __('Dashboard') ?>
		</span>
	</div>
	<div class="um-panel-content with-padding">
<?php   if ($this->UserAuth->isLogged()) {
			echo __('Hello').' '.h($var['User']['first_name']).' '.h($var['User']['last_name']); ?>
			<br/><br/>
	<?php   $lastLoginTime = $this->UserAuth->getLastLoginTime();
			if($lastLoginTime) {
				echo __('Your last login time is ').$lastLoginTime;
				echo "<br/><br/>";
			} ?>
<?php       if($this->UserAuth->HP('Users', 'addUser')) {
				echo $this->Html->link(__('Add User'), array('controller'=>'Users', 'action'=>'addUser', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('Users', 'addMultipleUsers')) {
				echo $this->Html->link(__('Add Multiple Users'), array('controller'=>'Users', 'action'=>'addMultipleUsers', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('Users', 'index')) {
				echo $this->Html->link(__('All Users'), array('controller'=>'Users', 'action'=>'index', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('Users', 'online')) {
				echo $this->Html->link(__('Online Users'), array('controller'=>'Users', 'action'=>'online', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserGroups', 'addGroup')) {
				echo $this->Html->link(__('Add Group'), array('controller'=>'UserGroups', 'action'=>'addGroup', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserGroups', 'index')) {
				echo $this->Html->link(__('All Groups'), array('controller'=>'UserGroups', 'action'=>'index', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserGroupPermissions', 'index')) {
				echo $this->Html->link(__('Group Permissions'), array('controller'=>'UserGroupPermissions', 'action'=>'index', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserGroupPermissions', 'subPermissions')) {
				echo $this->Html->link(__('Subgroup Permissions'), array('controller'=>'UserGroupPermissions', 'action'=>'subPermissions', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserSettings', 'index')) {
				echo $this->Html->link(__('All Settings'), array('controller'=>'UserSettings', 'action'=>'index', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserSettings', 'cakelog')) {
				echo $this->Html->link(__('Cake Logs'), array('controller'=>'UserSettings', 'action'=>'cakelog', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('Users', 'deleteCache')) {
				echo $this->Html->link(__('Delete Cache'), array('controller'=>'Users', 'action'=>'deleteCache', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserEmails', 'send')) {
				echo $this->Html->link(__('Send Mail'), array('controller'=>'UserEmails', 'action'=>'send', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserEmails', 'index')) {
				echo $this->Html->link(__('View Sent Mails'), array('controller'=>'UserEmails', 'action'=>'index', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserContacts', 'index')) {
				echo $this->Html->link(__('Contact Enquiries'), array('controller'=>'UserContacts', 'action'=>'index', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserEmailTemplates', 'index')) {
				echo $this->Html->link(__('Email Templates'), array('controller'=>'UserEmailTemplates', 'action'=>'index', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('UserEmailSignatures', 'index')) {
				echo $this->Html->link(__('Email Signatures'), array('controller'=>'UserEmailSignatures', 'action'=>'index', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('Contents', 'addPage')) {
				echo $this->Html->link(__('Add Page'), array('controller'=>'Contents', 'action'=>'addPage', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('Contents', 'index')) {
				echo $this->Html->link(__('All Pages'), array('controller'=>'Contents', 'action'=>'index', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('Users', 'myprofile')) {
				echo $this->Html->link(__('View Profile'), array('controller'=>'Users', 'action'=>'myprofile', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('Users', 'editProfile')) {
				echo $this->Html->link(__('Edit Profile'), array('controller'=>'Users', 'action'=>'editProfile', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if($this->UserAuth->HP('Users', 'changePassword')) {
				echo $this->Html->link(__('Change Password'), array('controller'=>'Users', 'action'=>'changePassword', 'plugin'=>'usermgmt'), array('class'=>'btn'));
			}
			if(ALLOW_DELETE_ACCOUNT && $this->UserAuth->HP('Users', 'deleteAccount')) {
				echo $this->Form->postLink(__('Delete Account'), array('controller'=>'Users', 'action'=>'deleteAccount', 'plugin'=>'usermgmt'), array('escape' => false, 'class'=>'btn', 'confirm' => __('Are you sure you want to delete your account?')));
			}
		} ?>
	</div>
</div>