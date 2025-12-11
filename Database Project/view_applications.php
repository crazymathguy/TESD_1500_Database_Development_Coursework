<!DOCTYPE html>
<html lang="en">
<head>
	<!--
	This file is to allow coordinators to view the applications
    that have been submitted

	Author: Sean Briggs
	Date:   2025-12-11

	Filename: view_applications.php
	-->

	<meta charset="utf-8" />
	<title>Submitted Applications</title>
	<link href="styles.css" rel="stylesheet" />
</head>

<body>
    <header><h1>Submitted Applications</h1></header>
    <?php
        @$fp = fopen("applications.txt", 'rb');
        flock($fp, LOCK_SH);

        if (!$fp) {
            echo "<p>An error occured: file missing, please try again later.</p>";
            exit;
        }

        echo "<p>Here are the applications that have been submitted.</p>";

        while (!feof($fp)) {
            $app = fgets($fp);
            echo "<p>".htmlspecialchars($app)."</p>";
        }
        
        flock($fp, LOCK_UN);
        fclose($fp);
    ?>
</body>
</html>