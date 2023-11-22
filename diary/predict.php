<?php
	$output = shell_exec('python sentiment.py');
	header("Location: diary.php");

?>