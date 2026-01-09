<?php
// Create variables
$eventFeedback = htmlspecialchars(str_replace("~", "--", $_POST['feedback'])).
	"~ ".$_POST['fName']." ".$_POST['lName']."|\n";

	require('page.php');
	$header = "";
	$success = true;

	@$fp = fopen("feedback.txt", 'ab');
	flock($fp, LOCK_EX);

	if ($fp) {
		fwrite($fp, $eventFeedback);
		flock($fp, LOCK_UN);
		fclose($fp);
	} else {
		$content = "<p><strong>Unsuccessful submission.
				Please try again later.";
		$success = false;
	}

	if ($success) {
		$content = "<p>".$_POST['feedback']."<p>
			<p><strong>Your response has been recorded. Thank you for your feedback.</strong></p>";
		$header = "Your Feedback";
	}

	$page = new Page([], $header, $content);
	$page -> Display();
?>