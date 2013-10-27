Last Modification of this file is 06-oct-2013

UserMgmt is a User Management Plugin for cakephp 2.x
Plugin Premium version 2.3 (stable)

Hey wanna Demo ??? http://umpremium.ektanjali.com

For All	featues	go to http://umpremium.ektanjali.com

For Documentations go to http://developers.ektanjali.com/docs/umpremium/version2.3/index.html

INSTALLATION
------------

1. Download the	latest version from http://www.ektanjali.com/products
	go to yourapp/app/Plugin
	extract	here
	name it	Usermgmt

2. Schema import (use your favorite sql	tool to	import the schema)

	yourapp/app/Plugin/Usermgmt/Config/Schema/usermgmt-2.3.sql

3. Configure your AppController	class
	
	you can download the app controller from http://www.ektanjali.com/products/downloadAppController/umpremium2.3
	
	or you can write manual code as following

	Your yourapp/app/Controller/AppController.php should look like this:

<?php
	class AppController extends Controller {
		var $helpers = array('Form', 'Html', 'Session',	'Js', 'Usermgmt.UserAuth', 'Usermgmt.Image');
		public $components = array('Session', 'RequestHandler', 'Usermgmt.UserAuth');

		/* Override functions */
		public function paginate($object = null, $scope = array(), $whitelist = array()) {
			$sessionKey = sprintf('UserAuth.Search.%s.%s', $this->name, $this->action);
			if ($this->Session->check($sessionKey)) {
				$persistedData = $this->Session->read($sessionKey);
				if(!empty($persistedData['page_limit'])) {
					$this->paginate['limit']=$persistedData['page_limit'];
				}
			}
			return parent::paginate($object, $scope, $whitelist);
		}
		function beforeFilter() {
			$this->userAuth();
		}
		private	function userAuth() {
			$this->UserAuth->beforeFilter($this);
		}
	}
?>

4. (Optional)
	This plugin is CSRF protection enabled and If you want to use CSRF in rest Application just use	Security component
	for ex.	$components in Your yourapp/app/Controller/AppController.php should look like this:
	public $components = array('Session', 'RequestHandler', 'Usermgmt.UserAuth', 'Security');

5. Enable Plugin in your bootstrap.php

	yourapp/app/Config/bootstrap.php should	include	this line

	// load	Usermgmt plugin	and apply plugin routes. Keep all the other plugins you	are using here
	CakePlugin::loadAll(array(
	    'Usermgmt' => array('routes' => true, 'bootstrap' => true),
	));

6. Download twitter bootstrap framework from http://getbootstrap.com/2.3.2/
extract this somewhere now do following-

copy all css files for e.g. bootstrap.css, bootstrap.min.css, bootstrap-responsive.css, bootstrap-responsive.min.css
and paste them in to yourapp/app/webroot/css directory

copy all js files for e.g. bootstrap.js, bootstrap.min.js
and paste them in to yourapp/app/webroot/js directory

copy all images
and paste them in to yourapp/app/webroot/img directory

7. Create a folder in yourapp/app/webroot directory named "plugins" without quotes

8. Download bootstrap datepicker zip file from https://github.com/eternicode/bootstrap-datepicker
extract this yourapp/app/webroot/plugins

Directory structure should look like
/app
--- /webroot
----------- /plugins
------------------- /bootstrap-datepicker
---------------------------------------- /build
---------------------------------------- /css
---------------------------------------- /js		etc

9. Download bootstrap datepicker zip file from https://github.com/smalot/bootstrap-datetimepicker
extract this yourapp/app/webroot/plugins

Directory structure should look like
/app
--- /webroot
----------- /plugins
------------------- /bootstrap-datetimepicker
--------------------------------------------- /build
--------------------------------------------- /css
--------------------------------------------- /js		etc

10. Download bootstrap chosen zip file from https://github.com/harvesthq/chosen/releases/tag/0.14.0 (you can download latest 0.x version at this time 0.14.0 is latest)
extract this yourapp/app/webroot/plugins

Directory structure should look like
/app
--- /webroot
----------- /plugins
------------------- /chosen
-------------------------- /chosen.css
-------------------------- /chosen.jquery.min.js		etc

11. Download bootstrap typeahead zip file from https://github.com/biggora/bootstrap-ajax-typeahead
extract this yourapp/app/webroot/plugins

Directory structure should look like
/app
--- /webroot
----------- /plugins
------------------- /bootstrap-ajax-typeahead
-------------------------------------------- /demo
-------------------------------------------- /js		etc

12.	Download the jquery from http://jquery.com (at this time latest version is 1.10.2)
	Please note I am using jquery-1.10.2.min.js in default layout if you download other jquery version then do not forget to change in default layout.
Directory structure should look like
/app
--- /webroot
----------- /js
--------------- /jquery-1.10.2.min.js


13.	Download the tinymce editor from http://www.tinymce.com/download/download.php (at this time latest version is TinyMCE 4.0.6)
	Extract	it somewhere now go tinymce/js directory	and copy tinymce folder and go	to yourapp/app/webroot/js directory and paste here.
Directory structure should look like
/app
--- /webroot
----------- /js
-------------- /tinymce
---------------------- /tinymce.min.js
---------------------- /plugins
---------------------- /langs	etc

14. Download the ckeditor (full package) editor from http://ckeditor.com/download (at this time latest version is ckeditor 4.2.1)
	Make sure you have downloaded full package
	Extract	it somewhere now go copy ckeditor folder and go to yourapp/app/webroot/js directory and paste here.
Directory structure should look like
/app
--- /webroot
----------- /js
-------------- /ckeditor
---------------------- /ckeditor.js
---------------------- /plugins
---------------------- /lang	etc


15. Add all plugin, bootstrap and other css and js files in head of your layout file, for example yourapp/app/View/Layouts/default.ctp
	
	you can download the default layout from http://www.ektanjali.com/products/downloadLayout/umpremium2.3
	
	or you can write manual code as following

	Your yourapp/app/View/Layouts/default.php should look like this:

    <!DOCTYPE html>
	<html lang="en">
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>Cakephp 2.x User Management Premium Plugin with Twitter Bootstrap | Ektanjali Softwares</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script language="javascript">
			var urlForJs="<?php echo SITE_URL ?>";
		</script>
		<?php
			echo $this->Html->meta('icon');
			/* Bootstrap CSS */
			echo $this->Html->css('bootstrap.css?q='.QRDN);
			echo $this->Html->css('bootstrap-responsive.css?q='.QRDN);
			
			/* Usermgmt Plugin CSS */
			echo $this->Html->css('/usermgmt/css/umstyle.css?q='.QRDN);
			
			/* Bootstrap Datepicker is taken from https://github.com/eternicode/bootstrap-datepicker */
			echo $this->Html->css('/plugins/bootstrap-datepicker/css/datepicker.css?q='.QRDN);

			/* Bootstrap Datepicker is taken from https://github.com/smalot/bootstrap-datetimepicker */
			echo $this->Html->css('/plugins/bootstrap-datetimepicker/css/datetimepicker.css?q='.QRDN);
			
			/* Chosen is taken from https://github.com/harvesthq/chosen/releases/tag/0.14.0 */
			echo $this->Html->css('/plugins/chosen/chosen.css?q='.QRDN);

			/* Jquery latest version taken from http://jquery.com */
			echo $this->Html->script('jquery-1.10.2.min.js');
			
			/* Bootstrap JS */
			echo $this->Html->script('bootstrap.js?q='.QRDN);

			/* Bootstrap Datepicker is taken from https://github.com/eternicode/bootstrap-datepicker */
			echo $this->Html->script('/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js?q='.QRDN);

			/* Bootstrap Datepicker is taken from https://github.com/smalot/bootstrap-datetimepicker */
			echo $this->Html->script('/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js?q='.QRDN);
			
			/* Bootstrap Typeahead is taken from https://github.com/biggora/bootstrap-ajax-typeahead */
			echo $this->Html->script('/plugins/bootstrap-ajax-typeahead/js/bootstrap-typeahead.min.js?q='.QRDN);
			
			/* Chosen is taken from https://github.com/harvesthq/chosen/releases/tag/0.14.0 */
			echo $this->Html->script('/plugins/chosen/chosen.jquery.min.js?q='.QRDN);

			/* Usermgmt Plugin JS */
			echo $this->Html->script('/usermgmt/js/umscript.js?q='.QRDN);
			echo $this->Html->script('/usermgmt/js/ajaxValidation.js?q='.QRDN);

			echo $this->Html->script('/usermgmt/js/chosen/chosen.ajaxaddition.jquery.js?q='.QRDN);

			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<?php
					if($this->UserAuth->isLogged()) {
						echo $this->element('Usermgmt.dashboard');
					} ?>
				<?php echo $this->element('Usermgmt.message'); ?>
				<?php echo $this->element('Usermgmt.message_validation'); ?>
				<?php echo $this->fetch('content'); ?>
				<div style="clear:both"></div>
			</div>
		</div>
		<div id="footer">
			<div class="container">
				<p class="muted">Copyright &copy; <?php echo date('Y');?> Your Site. All Rights Reserved. <a href="http://www.ektanjali.com/" target='_blank'>Developed By</a>.</p>
			</div>
		</div>
		<?php if(class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) { echo $this->Js->writeBuffer(); } ?>
	</body>
	</html>




16. Please make sure you have email.php in yourapp/app/Config if not rename email.php.default to email.php
now open email.php go to line no 40 (in cakephp 2.4.1) find public $default
change 'from' => 'you@localhost', to 'from' => 'valid_email',
valid_email means any valid email like test@test.com


17. Go to yourdomain/login
Default	user name password
username- admin
password- 123456

ALL DONE !





HOW TO UPGRADE from Old	Version	to New Version

see the	guide http://developers.ektanjali.com/docs/umpremium/version2.3/upgrade.html


If you have any	problem	please do not hesitate to contact me at	chetanvarshney@gmail.com