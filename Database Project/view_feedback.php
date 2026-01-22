<?php
	require('page.php');
	$styles = ["feedback_table_styles"];
	$header = "Feedback";

	try {
		$db = new mysqli('localhost', 'web_user', 'summer_camp123', 'summer_camp');
		if (mysqli_connect_errno()) {
			throw new FileException();
		}

		$query = "SELECT feedback.feedback, applicants.first_name, applicants.last_name
			FROM feedback, applicants WHERE applicants.applicant_id = feedback.applicant_id";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->store_result();

		$stmt->bind_result($feedback, $fName, $lName);

		if ($stmt->num_rows == 0) {
			$content = "<p><strong>No feedback has been submitted.<br/ >
				Please try again later.</strong></p>";
		}
		else {
			$allFeedback = [];
			$people = [];
			while ($stmt->fetch()) {
				$allFeedback[] = $feedback;
				$people[] = $fName." ".$lName;
			}
			$content = feedbackType('Positive Experiences', ['fun', 'love', 'like', 'enjoy']).
			feedbackType('Negative Experiences', ['hate', 'scary', 'negative', 'bad']).
			feedbackType('Criticisms', ['better', 'improve']).
			feedbackType('All Feedback', ['.']);
		}
	}
	catch (FileException $f) {
		$content = "<p><strong>An error occurred trying to connect to the database.<br />
			Please try again later.</strong></p>";
	}
	catch (Exception $e) {
		$content = "<p><strong>An unkown error occurred.<br /> Please try again later.<br />
			Message: ".$e->getMessage()."</strong></p>";
	}
	finally {
		$content = '<p><a href="view_applications.php">View Applications</a></p>'.$content;
		$page = new Page($styles, $header, $content);
		$page -> Display();
	}

	function feedbackType($heading, $terms) {
		global $allFeedback;
		global $people;
		$searchTerms = '/('.implode(')|(', $terms).')/i';
		
		$content .= "<h2>".$heading."</h2>\n<table>\n";
		
		for ($i = 0; $i < count($allFeedback); $i++) {
			if (preg_match($searchTerms, $allFeedback[$i])) {
				$content .= "<tr><td>".$allFeedback[$i]."</td>\n<td>".$people[$i]."</td></tr>";
			}
		}
		$content .= "</table>";
		return $content;
	}
?>