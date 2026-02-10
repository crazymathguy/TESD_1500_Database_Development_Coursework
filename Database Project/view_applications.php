<?php
require("lib/page.inc");

$styles = ["application_table_styles"];
$header = "Applicants";

try {
	require("lib/login.inc");

	if ($status !== "admin") {
		$content = "<p><strong>You are not authorized to view this page.</strong></p>";
	} 
	else {
		$query = "SELECT * FROM applicants ORDER BY last_name";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->store_result();

		$stmt->bind_result($id, $fName, $lName, $age, $gender, $phone, $email, $tSize, $status);

		if ($stmt->num_rows == 0) {
			$content = "<p><strong>No applications have been submitted.<br/ >
				Please try again later.</strong></p>";
		}
		else {
			$content = "<table>\n
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>ID Number</th>
					<th>Age</th>
					<th>Gender</th>
					<th>Phone Number</th>
					<th>Email Address</th>
					<th>T-Shirt Size</th>
					<th>Allergies</th>
					<th>Status</th>
				</tr>";
			
			while ($stmt->fetch()) {
				$content .= "<tr>".
				"<td>".$fName."</td>".
				"<td>".$lName."</td>".
				"<td>".$id."</td>".
				"<td>".$age."</td>".
				"<td>".$gender."</td>".
				"<td>".$phone."</td>".
				"<td>".$email."</td>".
				"<td>".$tSize."</td>";

				$allergyQuery = "SELECT allergy FROM allergy_information WHERE applicant_id = ?";
				$allergyStmt = $db->prepare($allergyQuery);
				$allergyStmt->bind_param('i', $id);
				$allergyStmt->execute();
				$allergyStmt->store_result();
				$allergyStmt->bind_result($allergy);
				
				if ($allergyStmt->fetch()) {
					$allergies = $allergy;
				}
				else {
					$allergies = "none";
				}
				while ($allergyStmt->fetch()) {
					$allergies .= ", ".$allergy;
				}
				$content .= "<td>".$allergies."</td>";
				$content .= "<td>".$status."</td></tr>";

				$allergyStmt->free_result();
			}
			$content .= "</table>";
		}

		$stmt->free_result();
		$db->close();
	}
}
catch (InvalidFormException $e) {
	$content = "<p><strong>You have not entered a valid username.<br />
		Please try again.</strong></p>";
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
	$content = '<p><a href="view_feedback.php">View Feedback</a></p>'.$content;
	$page = new Page($styles, $header, $content);
	$page -> Display();
}
?>