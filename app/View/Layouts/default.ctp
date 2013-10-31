<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
	</title>
	<?php
		//echo $this->Html->meta('icon');
		//echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('iga');
		
		echo $this->Html->script('jquery.min');
		echo $this->Html->script('angular.min');
		echo $this->Html->script('iga/app');
		
		echo $this->Html->script('iga/controller');
		echo $this->Html->script('iga/directives');
		echo $this->Html->script('iga/services');
		
		echo $this->Html->script('plugins/timer');
		
		echo $this->Html->script('plugins/angular-ui/carousel');
		echo $this->Html->script('plugins/angular-ui/transition');
		//echo $this->Html->script('iga/filters');
		
		
		
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
