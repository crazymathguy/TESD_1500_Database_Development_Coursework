<?php
// Create variables
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$tSize = $_POST['tSize'];
$haveAllergies = $_POST['haveAllergies'];
$allergies = $_POST['allergies'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!--
	This file is the post submission form page

	Author: Sean Briggs
	Date:   2025-12-09

	Filename: form_processed.php
	-->

	<meta charset="utf-8" />
	<title>Sign-Up Form Submitted</title>
	<link href="styles.css" rel="stylesheet" />
</head>

<body>
	<header><h1>Event Sign-Up</h1></header>
	<?php
		switch ($gender) {
			case '':
				$gender = "None";
				break;
			case 'm':
				$gender = "Male";
				break;
			case 'f':
				$gender = "Female";
				break;
		}
		switch ($tSize) {
			case 'xs':
				$tSize = "Extra small";
				break;
			case 's':
				$tSize = "Small";
				break;
			case 'm':
				$tSize = "Medium";
				break;
			case 'l':
				$tSize = "Large";
				break;
			case 'xl':
				$tSize = "Extra Large";
		}

		if (!$haveAllergies) {
			$allergies = "None";
		}

		$outputString = $fName."\t".$lName."\t".$age."\t".$gender."\t".$tSize."\t".$allergies."\n";

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

		echo "<p>Congratulations, ".$fName." ".$lName.
			 ", your application form has been successfully submitted!</p>";
		echo "<p><strong>Here is your application</strong></p>";
		echo "<p>Name: ".$fName." ".$lName;
		echo "<p>Age: ".$age;
		echo "<p>Gender: ".$gender;
		echo "<p>T-Shirt size: ".$tSize;
		echo "<p>Allergies: ".$allergies;
	?>
</body>
</html>