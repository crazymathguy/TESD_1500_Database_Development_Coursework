<?php
	require('page.php');
	$styles = ["application_table_styles"];
	$header = "Applicants";
	$content = '<p><a href="view_feedback.php">View Feedback</a></p>';
	$success = true;

	if (!file_exists("applications.txt")) {
		$content .= "<p><strong>No applications have been submitted.<br/ >
			Please try again later.</strong></p>";
		$success = false;
	}
	if ($success) {
		$applications = file("applications.txt");
		$numOfApplicants = count($applications);

		if ($numOfApplicants == 0) {
			$content .= "<p><strong>No applications have been submitted.<br/ >
				Please try again later.</strong></p>";
			$success = false;
		}
	}

	if ($success) {
		for ($i = 0; $i < $numOfApplicants; $i++) {
			$applicants[$i] = explode("\t", $applications[$i]);
		}
		usort($applicants, 'compareApplicants');

		$content .= "<table>\n
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th>Phone Number</th>
				<th>Email Address</th>
				<th>T-Shirt Size</th>
				<th>Allergies</th>
			</tr>";
		
		for ($j = 0; $j < $numOfApplicants; $j++) {
			$content .= "<tr>";
			for ($k = 0; $k < 8;$k++) {
				$content .= "<td>".$applicants[$j][$k]."</td>";
			}
			$content .= "</tr>";
		}
		$content .= "</table>";
	}

	function compareApplicants($x, $y) {
		if ($x[1] < $y[1]) {
			return -1;
		} else if ($x[1] > $y[1]) {
			return 1;
		} else {
			if ($x[0] < $y[0]) {
				return -1;
			} else if ($x[0] > $y[0]) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	$page = new Page($styles, $header, $content);
	$page -> Display();
?>