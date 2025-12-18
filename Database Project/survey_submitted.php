<?php
// Create variables
$eventFeedback = htmlspecialchars(str_replace("|", "\\", str_replace(
	"~", "-", $_POST['feedback'])))
	." ~".$_POST['fName']." ".$_POST['lName']."|\n";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!--
	This file is the post survey page

	Author: Sean Briggs
	Date:   2025-12-09

	Filename: survey_submitted.php
	-->

	<meta charset="utf-8" />
	<title>Survey Submitted</title>
	<link href="styles.css" rel="stylesheet" />
</head>

<body>
	<header><h1>Event Feedback</h1></header>
	<?php
		@$fp = fopen("feedback.txt", 'ab');
		flock($fp, LOCK_EX);

		if (!$fp) {
			echo "<p><strong>Unsuccessful submission.
				  Please try again later.";
			exit;
		}

		fwrite($fp, $eventFeedback);
		flock($fp, LOCK_UN);
		fclose($fp);

		echo "<p><strong>Your response has been recorded. Thank you for your feedback.</strong></p>";
	?>
</body>
</html>