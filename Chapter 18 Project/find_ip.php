<!DOCTYPE html>
<html>
<head>
	<title>IP Search Results</title>
</head>
<body>
	<h1>IP Address Search Results</h1>

<?php

	$url = $_POST['url'];

	$url = parse_url($url);
	$host = $url['host'];

	if (!($ip = gethostbyname($host)))
	{
		echo 'Host for URL does not have valid IP address.';
		exit;
	}

	echo 'Host ('.$host.') is at IP '.$ip.'<br/>';
	echo 'File path: '.$url['path'];
    
?>
</body>
</html>