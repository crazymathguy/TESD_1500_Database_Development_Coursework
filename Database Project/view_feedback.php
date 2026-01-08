<?php
	require('header.php');
	echo '<link href="feedback_table_styles.css" rel="stylesheet" />';
	echo '<h1>Feedback</h1>';
	echo '<p><a href="view_applications.php">View Applications</a></p>';

	if (!file_exists("feedback.txt")) {
		echo "<p><strong>No feedback has been submitted.<br/ >
				Please try again later.</strong></p>";
		exit;
	}
	$file = file_get_contents("feedback.txt");
	$feedback = explode("|", $file);
	$numOfApplicants = count($feedback);

	if ($numOfApplicants == 0) {
		echo "<p><strong>No feedback has been submitted.<br/ >
				Please try again later.</strong></p>";
		exit;
	}

	feedbackType('Positive Experiences', ['fun', 'love', 'like', 'enjoy'], $feedback);
	feedbackType('Negative Experiences', ['hate', 'scary', 'negative'], $feedback);
	feedbackType('Criticisms', ['better', 'improve'], $feedback);
	feedbackType('All Feedback', ['.'], $feedback);

	function feedbackType($heading, $terms, $feedback) {
		$searchTerms = '/('.implode(')|(', $terms).')/i';
		
		echo "<h2>".$heading."</h2>";
		echo "<table>\n";
		
		$matches = preg_grep($searchTerms, $feedback);
		foreach ($matches as $match) {
			echo "<tr>";
			$entry = array_reverse(explode("~", $match));
			foreach ($entry as $field) {
				echo "<td>".$field."</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}

	require('footer.php');
?>