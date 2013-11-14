<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Results</title>
	<?php
		echo $this->Html->meta('icon');
		//echo $this->Html->css('iga.min');
		//echo $this->Html->script('iga.min');
		
		echo $this->fetch('meta');
		//echo $this->fetch('css');
		//echo $this->fetch('script');
	?>
</head>
<body data-ng-app="igaApp">
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
