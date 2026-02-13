<!DOCTYPE html>
<html>
<head>
	<title>Todo Lookup</title>
</head>
<body>
	<h1>Todo Item</h1>

<?php
	$number = 1;

	$url = 'https://jsonplaceholder.typicode.com/todos/'.$number;

	if (!($contents = file_get_contents($url))) {
		die('Failed to open '.$url);
	}
	$contents = trim($contents, '{}');

	// exctract data
	$list = explode(',', $contents);
	echo '<p>';

	foreach ($list as $item) {
		list($key, $value) = explode(': ', $item);
		$key = str_replace('"', '', $key);
		$value = str_replace('"', '', $value);
		echo $key.': '.$value.'<br />';
	}
	echo '</p>';
?>
</body>
</html>