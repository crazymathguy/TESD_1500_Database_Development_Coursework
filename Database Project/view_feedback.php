<?php
	require('page.php');
	$styles = ["feedback_table_styles"];
	$header = "Feedback";
	$content = '<p><a href="view_applications.php">View Applications</a></p>';
	$success = true;

	if (!file_exists("feedback.txt")) {
		$content .= "<p><strong>No feedback has been submitted.<br/ >
			Please try again later.</strong></p>";
		$success = false;
	}

	if ($success) {
		$file = file_get_contents("feedback.txt");
		$feedback = explode("|", $file);
		$numOfApplicants = count($feedback);

		if ($numOfApplicants == 0) {
			$content .= "<p><strong>No feedback has been submitted.<br/ >
				Please try again later.</strong></p>";
			$success = false;
		}
	}

	if ($success) {
		feedbackType('Positive Experiences', ['fun', 'love', 'like', 'enjoy'], $feedback);
		feedbackType('Negative Experiences', ['hate', 'scary', 'negative', 'bad'], $feedback);
		feedbackType('Criticisms', ['better', 'improve'], $feedback);
		feedbackType('All Feedback', ['.'], $feedback);
	}

	function feedbackType($heading, $terms, $feedback) {
		global $content;
		$searchTerms = '/('.implode(')|(', $terms).')/i';
		
		$content .= "<h2>".$heading."</h2>\n<table>\n";
		
		$matches = preg_grep($searchTerms, $feedback);
		foreach ($matches as $match) {
			$content .= "<tr>";
			$entry = array_reverse(explode("~", $match));
			foreach ($entry as $field) {
				$content .= "<td>".$field."</td>";
			}
			$content .= "</tr>";
		}
		$content .= "</table>";
	}

	$page = new Page($styles, $header, $content);
	$page -> Display();
?>