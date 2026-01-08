<?php
	// Create variables
	extract($_POST);
	require('header.php');
	echo '<h1>Your Application Has Been Submitted</h1>';

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
		echo "<p><strong>You have not entered a valid phone number. ".
			"Please return to the previous page and try again.</strong></p>";
		exit;
	}
	$phone = preg_replace('/\D/', '', $phone);
	$phone = "+1".$phone;
	if (preg_match('/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z0-9_\-\.]+$/', $email) === 0) {
		echo "<p><strong>You have not entered a valid email address. ".
			"Please return to the previous page and try again.</strong></p>";
		exit;
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

	$outputString = $fName."\t".$lName."\t".$age."\t".$gender.
		"\t".$phone."\t".$email."\t".$tSize."\t".$allergies."\n";

	@$fp = fopen("applications.txt", 'ab');
	flock($fp, LOCK_EX);

	if (!$fp) {
		echo "<p><strong>Unsuccessful submission.
				Please try again later.";
		exit;
	}

	fwrite($fp, $outputString);
	flock($fp, LOCK_UN);
	fclose($fp);

	echo "<p>Congratulations, ".$fName.
			", your application form has been successfully submitted!</p>";
	echo "<p><strong>Here is your application</strong></p>";
	echo "<p>Name: ".$fName." ".$lName;
	echo "<p>Age: ".$age;
	echo "<p>Gender: ".$gender;
	echo "<p>Phone Number: ".$phone;
	echo "<p>Email Address: ".$email;
	echo "<p>T-Shirt size: ".$tSize;
	echo "<p>Allergies: ".$allergies;

	require('footer.php');
?>