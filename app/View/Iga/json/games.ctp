<?php
	foreach($games as $key=>&$game) {
		$game['meta']	= json_decode($game['meta']);
		unset($game['votes']);
	}
	
	echo json_encode($games);