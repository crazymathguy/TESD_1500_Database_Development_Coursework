<?php
// Create variables
extract($_POST);
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
	<title>Application Form Submitted</title>
	<link href="styles.css" rel="stylesheet" />
</head>

<body>
	<header><h1>Event Application</h1></header>
	<?php
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