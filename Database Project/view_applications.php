<?php
	require('header.php');
	echo '<link href="application_table_styles.css" rel="stylesheet" />';
	echo '<h1>Applicants</h1>';
	echo '<p><a href="view_feedback.php">View Feedback</a></p>';

	if (!file_exists("applications.txt")) {
		echo "<p><strong>No applications have been submitted.<br/ >
				Please try again later.</strong></p>";
		exit;
	}
	$applications = file("applications.txt");
	$numOfApplicants = count($applications);

	if ($numOfApplicants == 0) {
		echo "<p><strong>No applications have been submitted.<br/ >
				Please try again later.</strong></p>";
		exit;
	}

	for ($i = 0; $i < $numOfApplicants; $i++) {
		$applicants[$i] = explode("\t", $applications[$i]);
	}
	usort($applicants, 'compareApplicants');

	echo "<table>\n";
	echo "<tr>
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
		echo "<tr>";
		for ($k = 0; $k < 8;$k++) {
			echo "<td>".$applicants[$j][$k]."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";

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

	require('footer.php');
?>