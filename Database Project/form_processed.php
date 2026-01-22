<?php
require('page.php');
require('exceptions.php');
	// Create variables
	$header = "";
	$fName = trim($_POST['fName']);
	$lName = trim($_POST['lName']);
	$age = intval($_POST['age']);
	$gender = $_POST['gender'];
	$phone = trim($_POST['phone']);
	$email = trim($_POST['email']);
	$tSize = $_POST['tSize'];
	$allergies = $_POST['allergies'];

	switch ($gender) {
		case '':
			$gender = 'Other';
		case 'Male':
		case 'Female':
			break;
		default:
			throw new InvalidFormException('gender');
	}
	try {
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

		$db = new mysqli('localhost', 'web_user', 'summer_camp123', 'summer_camp');
		if (mysqli_connect_errno()) {
			throw new FileException();
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