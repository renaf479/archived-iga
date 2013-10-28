<?php
	foreach($games as $key=>&$game) {
		$game['Game']['meta']	= json_decode($game['Game']['meta']);
	}
	
	echo json_encode($games);