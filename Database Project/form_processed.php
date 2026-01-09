<?php
require("page.php");
require("exceptions.php");
	// Create variables
	extract($_POST);
	$header = "";

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
	try {
		if (preg_match('/^[0-9()\-\h]+$/', $phone) === 0) {
			$message = "phone number";
			throw new InvalidFormException();
		}
		$phone = preg_replace('/\D/', '', $phone);
		$phone = "+1".$phone;
		if (preg_match('/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z0-9_\-\.]+$/', $email) === 0) {
			$message = "email address";	
			throw new InvalidFormException();
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

		if(!($fp = @fopen("applications.txt", 'ab'))) {
			throw new FileException();
		}
		if(!flock($fp, LOCK_EX)) {
			throw new FileException();
		}
		if(!fwrite($fp, $outputString)) {
			throw new FileException();
		}
		flock($fp, LOCK_UN);
		fclose($fp);

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
	catch (FileException $fe) {
		$content = "<p><strong>Unsuccessful submission. Please try again later.</strong></p>";
	}
	finally {
		$page = new Page([], $header, $content);
		$page -> Display();
	}
?>