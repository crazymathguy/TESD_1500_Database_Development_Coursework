<?php
	require("database_connect.inc");

	if ((!isset($_SERVER['PHP_AUTH_USER'])) &&
		(!isset($_SERVER['PHP_AUTH_PW'])) &&
		(substr($_SERVER['HTTP_AUTHORIZATION'], 0, 6) == 'Basic ')) {

		list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = 
			explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
	}

	$query = "SELECT applicant_id, `password`, `status` FROM login_info
	WHERE username = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('s', $_SERVER['PHP_AUTH_USER']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $hash, $status);

	if ($stmt->num_rows == 0) {
		throw new InvalidFormException('username');
	}

	if (!password_verify($_SERVER['PHP_AUTH_PW'], $hash)) {
		
		// visitor has not yet given details, or their
		// name and password combination are not correct
		header('WWW-Authenticate: Basic realm="Realm-Name"');
		header('HTTP/1.0 401 Unauthorized');
		exit;
	}
?>