<!DOCTYPE html>
<html lang="en">
<head>
	<!--
	This file is to allow coordinators to view the feedback
	that has been submitted

	Author: Sean Briggs
	Date:   2025-12-17

	Filename: view_feedback.php
	-->

	<meta charset="utf-8" />
	<title>Feedback</title>
	<link href="styles.css" rel="stylesheet" />
	<link href="feedback_table_styles.css" rel="stylesheet" />
</head>

<body>
	<header><h1>Feedback</h1></header>
	<p><a href="view_applications.php">View Applications</a></p>
	<?php
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
	?>
</body>
</html>