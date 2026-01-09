<?php
require('page.php');
	// Create variables
	extract($_POST);
	$header = "";
	$success = true;

	switch ($gender) {
		case '':
			$gender = "none";
			break;
		case 'm':
			$gender = "male";
			break;
		case 'f':
			$gender = "female";
			break;
	}
	if (preg_match('/^[0-9()\-\h]+$/', $phone) === 0) {
		$content = "<p><strong>You have not entered a valid phone number.
			Please return to the previous page and try again.</strong></p>";
		$success = false;
	}
	$phone = preg_replace('/\D/', '', $phone);
	$phone = "+1".$phone;
	if (preg_match('/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z0-9_\-\.]+$/', $email) === 0) {
		$content = "<p><strong>You have not entered a valid email address.
			Please return to the previous page and try again.</strong></p>";
		$success = false;
	}
	switch ($tSize) {
		case 'xs':
			$tSize = "extra small";
			break;
		case 's':
			$tSize = "small";
			break;
		case 'm':
			$tSize = "medium";
			break;
		case 'l':
			$tSize = "large";
			break;
		case 'xl':
			$tSize = "extra large";
	}

	if (!$haveAllergies) {
		$allergies = "none";
	}

	if ($success) {
		$outputString = $fName."\t".$lName."\t".$age."\t".$gender.
			"\t".$phone."\t".$email."\t".$tSize."\t".$allergies."\n";

		@$fp = fopen("applications.txt", 'ab');
		flock($fp, LOCK_EX);

		if ($fp) {
			fwrite($fp, $outputString);
			flock($fp, LOCK_UN);
			fclose($fp);
		} else {
			$content = "<p><strong>Unsuccessful submission.
				Please try again later.</strong></p>";
			$success = false;
		}

	}

	if ($success) {
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

	$page = new Page([], $header, $content);
	$page -> Display();
?>