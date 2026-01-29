<?php
require("database_connect.inc");
require("page.inc");
require("exceptions.inc");
	// Create variables
	$header = "";
	$feedback =  htmlspecialchars($_POST['feedback']);
	$fName = htmlspecialchars($_POST['fName']);
	$lName =  htmlspecialchars($_POST['lName']);
	
	try {
		$db = new mysqli($hostName, $userName, $password, $dbName);
		if (mysqli_connect_errno()) {
			throw new FileException();
		}

		$query = "SELECT applicant_id FROM applicants WHERE first_name = ? AND last_name = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param('ss', $fName, $lName);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id);

		if ($stmt->num_rows != 1) {
			throw new InvalidFormException('name');
		}
		else {
			$stmt->fetch();
		}

		$query = "INSERT INTO feedback VALUES (NULL, ?, ?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param('is', $id, $feedback);
		$stmt->execute();

		if ($stmt->affected_rows == 0) {
			throw new FileException();
		}

		$db->close();

		$content = "<p>".$feedback."<p>
			<p><strong>Your response has been recorded. Thank you for your feedback.</strong></p>";
		$header = "Your Feedback";
	}
	catch (InvalidFormException $ife) {
		$content = "<p><strong>You have not entered a valid ".$ife->getMessage().".<br />
			Please return to the previous page and try again.</strong></p>";
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
		$page = new Page([], $header, $content);
		$page -> Display();
	}
?>