<?php
// Create variables
$eventFeedback = htmlspecialchars(str_replace("~", "--", $_POST['feedback'])).
	"~ ".$_POST['fName']." ".$_POST['lName']."|\n";

	require("page.php");
	require("exceptions.php");
	$header = "";
	
	try {
		if (!($fp = @fopen("feedback.txt", 'ab'))) {
			throw new FileException();
		}
		if (!flock($fp, LOCK_EX)) {
			throw new FileException();
		}
		if (!fwrite($fp, $eventFeedback)) {
			throw new FileException();
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		$content = "<p>".$_POST['feedback']."<p>
			<p><strong>Your response has been recorded. Thank you for your feedback.</strong></p>";
		$header = "Your Feedback";
	}
	catch (FileException $fe) {
		$content = "<p><strong>Unsuccessful submission.<br />
			Please try again later.";
	}
	finally {
		$page = new Page([], $header, $content);
		$page -> Display();
	}
?>