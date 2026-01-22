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
	$allergies = trim($_POST['allergies']);

	switch ($gender) {
		case '':
			$gender = 'Other';
		case 'Male':
		case 'Female':
			break;
		default:
			$message = 'gender';
			throw new InvalidFormException();
	}
	try {
		$phone = preg_replace('/\D/', '', $phone);
		if (preg_match('/^\d{10}$/', $phone) === 0) {
			$message = 'phone number';
			throw new InvalidFormException();
		}
		$phone = '+1'.$phone;
		if (preg_match('/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-\.]+$/',
		$email) === 0) {
			$message = 'email address';	
			throw new InvalidFormException();
		}
		switch ($tSize) {
			case 'XS':
			case 'S':
			case 'M':
			case 'L':
			case 'XL':
				break;
			default:
				$message = 'shirt size';
				throw new InvalidFormException();
		}

		@$db = new mysqli('localhost', 'web_user', 'summer_camp123', 'summer_camp');
		if (mysql_connect_errno()) {
			throw new FileException();
		}

		$query = "INSERT INTO applicants
		/*(first_name, last_name, age, gender, phone_number, email_address, shirt_size)*/
 		VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, DEFAULT)";
		$stmt = $db->prepare($query);
		$stmt->bind_param('ssissss', $fName, $lName, $age, $gender, $phone, $email, $tSize);
		$stmt->execute();

		if (!($stmt->affected_rows > 0)) {
			throw new FileException();
		}
		/*$id = $db->insert_id;

		$query = "INSERT INTO allergy_information VALUES (?, ?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param('is', $id, $allergy);
		$allergies = explode(',', $allergies);
		foreach($allergies as $allergy) {
			$stmt->execute();
		}*/

		$db->close();

		$content = "<p>Congratulations, ".$fName.
			", your application form has been successfully submitted!</p>
			<p><strong>Here is your application</strong></p>
			<p>Name: ".$fName." ".$lName.
			"<p>Age: ".$age.
			"<p>Gender: ".$gender.
			"<p>Phone Number: ".$phone.
			"<p>Email Address: ".$email.
			"<p>T-Shirt size: ".$tSize.
			"<p>Allergies: ".$allergies;
		$header = "Your Application Has Been Submitted</h1>";
	}
	catch (InvalidFormException $ife) {
		$content = "<p><strong>You have not entered a valid ".$message.".<br />
			Please return to the previous page and try again.</strong></p>";
	}
	catch (FileException $f) {
		$content = "<p><strong>An error occurred trying to connect to the database.<br />
			Please try again later.</strong></p>";
	}
	catch (Exception $o) {
		$content = "<p><strong>An unkown error occurred.<br /> Please try again later.
		</strong></p>";
	}
	finally {
		$page = new Page([], $header, $content);
		$page->Display();
	}
?>