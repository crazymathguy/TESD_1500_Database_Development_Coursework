<?php
// Create variables
$eventFeedback = htmlspecialchars(str_replace("~", "--", $_POST['feedback'])).
	"~ ".$_POST['fName']." ".$_POST['lName']."|\n";

	require('header.php');
	echo '<h1>Your Feedback</h1>';

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

	echo "<p>".$_POST['feedback']."<p>";
	echo "<p><strong>Your response has been recorded. Thank you for your feedback.</strong></p>";
	require('footer.php');
?>