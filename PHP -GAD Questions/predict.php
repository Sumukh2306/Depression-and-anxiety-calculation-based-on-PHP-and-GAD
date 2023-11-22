<!DOCTYPE html>
<html>
<head>
	<title>Predicted Score</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f5f5f5;
		}
		.container {
			margin: 0 auto;
			max-width: 800px;
			padding: 20px;
			background-color: white;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
		}
		h1 {
			margin-top: 0;
		}
		pre {
			font-size: 16px;
			line-height: 1.5;
			max-width: 100%;
			white-space: pre-wrap;
			word-wrap: break-word;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php
		// import required Python modules
		$python = 'C:\Users\TAKSHAK\AppData\Local\Programs\Python\Python311\python.exe';  // change this path to the location of your Python executable
		$script = 'C:\xampp\htdocs\Login\questions\predict.py';  // change this path to the location of your Python script

		// execute the Python script and capture its output
		$output = shell_exec("$python $script 2>&1");

		// print the output on the screen
		echo "<h1>Predicted Score</h1>";
		echo "<pre>$output</pre>";
		?>
	</div>
</body>
</html>
