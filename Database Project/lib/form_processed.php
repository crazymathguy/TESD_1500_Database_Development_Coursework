<?php
require("page.inc");

try {
	require("database_connect.inc");

	// Create variables
	$header = "";
	$fName = htmlspecialchars(trim($_POST['fName']));
	$lName = htmlspecialchars(trim($_POST['lName']));
	$age = intval($_POST['age']);
	$gender = $_POST['gender'];
	$phone = trim($_POST['phone']);
	$email = trim($_POST['email']);
	$tSize = $_POST['tSize'];
	$allergies = htmlspecialchars($_POST['allergies']);

	$user = trim($_POST['username']);
	$pass = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

	if ($age < 12 || $age > 99) {
		throw new InvalidFormException('age');
	}
	switch ($gender) {
		case '':
			$gender = 'Other';
		case 'Male':
		case 'Female':
			break;
		default:
			throw new InvalidFormException('gender');
	}
	$phone = preg_replace('/\D/', '', $phone);
	if (preg_match('/^\d{10}$/', $phone) === 0) {
		throw new InvalidFormException('phone number');
	}
	$phone = '+1'.$phone;
	if (preg_match('/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-\.]+$/',
	$email) === 0) {
		throw new InvalidFormException('email address');
	}
	switch ($tSize) {
		case 'XS':
		case 'S':
		case 'M':
		case 'L':
		case 'XL':
			break;
		default:
			throw new InvalidFormException('shirt size');
	}
	$query = "SELECT applicant_id FROM login_info
	WHERE username = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('s', $user);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		throw new InvalidFormException('username. That username is already taken');
	}

	$query = "INSERT INTO applicants
	VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, DEFAULT)";
	$stmt = $db->prepare($query);
	$stmt->bind_param('ssissss', $fName, $lName, $age, $gender, $phone, $email, $tSize);
	$stmt->execute();

	if ($stmt->affected_rows == 0) {
		throw new FileException();
	}

	$id = $db->insert_id;

	$query = "INSERT INTO allergy_information VALUES (?, ?)";
	$stmt = $db->prepare($query);
	$stmt->bind_param('is', $id, $allergy);
	$allergiesArray = explode(',', $allergies);
	foreach($allergiesArray as $allergy) {
		$allergy = strtolower(trim($allergy));
		$stmt->execute();
	}

	$query = "INSERT INTO login_info VALUES (?, ?, ?, DEFAULT)";
	$stmt = $db->prepare($query);
	$stmt->bind_param('iss', $id, $user, $pass);
	$stmt->execute();

	if ($stmt->affected_rows == 0) {
		throw new FileException();
	}

	$_SERVER['PHP_AUTH_USER'] = $user;
	$_SERVER['PHP_AUTH_PW'] = $pass;

	$db->close();

	$content = "<p>Congratulations, ".$fName.
		", your application form has been successfully submitted!</p>
		<p><strong>Here is your application</strong><br />
		------------------------------".
		"<br />Name: ".$fName." ".$lName.
		"<br />Age: ".$age.
		"<br />Gender: ".$gender.
		"<br />Phone Number: ".$phone.
		"<br />Email Address: ".$email.
		"<br />T-Shirt size: ".$tSize.
		"<br />Allergies: ".$allergies;
	$header = "Your Application Has Been Submitted";
}
catch (InvalidFormException $ife) {
	$content = "<p><strong>You have not entered a valid ".$ife->getMessage().".<br />
		Please return to the previous page and try again.</strong></p>";
}
catch (FileException $f) {
	$content = "<p><strong>An error occurred trying to connect to the database.<br />
		Please try again later.</strong></p>";
}
catch (Exception $e) {
	$content = "<p><strong>An unkown error occurred.<br /> Please try again later.<br />
		Message: ".$e->getMessage()."</strong></p>";
}
finally {
	$page = new Page([], $header, $content);
	$page->Display();
}
?>