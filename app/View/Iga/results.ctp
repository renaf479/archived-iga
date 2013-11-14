<?php
	if($results) {
		echo '<ul>';
		foreach($results as $key=>&$result) {
			$result['meta']	= json_decode($result['meta']);
			//print_r($result);
			echo "<li>{$result['meta']->title} --- {$result['votes']}</li>";
		}
		echo '</ul>';
	} else {
		echo 'Authentication Failed. Please try again';
	}
	