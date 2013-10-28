<?php
	foreach($games as $key=>&$game) {
		$game['meta']	= json_decode($game['meta']);
	}
	
	echo json_encode($games);