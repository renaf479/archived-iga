<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Inside Gaming Awards 2013</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('iga');
		
/*
		echo $this->Html->script('plugins/angular.min');
		echo $this->Html->script('plugins/angular-ui/carousel');
		echo $this->Html->script('plugins/angular-ui/transition');
		echo $this->Html->script('plugins/timer');
		
		echo $this->Html->script('min/app.min');
		echo $this->Html->script('min/controller.min');
		echo $this->Html->script('min/directives.min');
		echo $this->Html->script('min/services.min');
*/
		echo $this->Html->script('min/iga.min.js');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body data-ng-app="igaApp">
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
