<?php
require('page.php');
$styles = ["form_styles"];
$header = "Event Application";

$content = '<form action="survey_submitted.php" method="post">
	<table>
		<tr>
			<td>First Name*</td>
			<td><input type="text" name="fName" required /></td>
		</tr>
		<tr>
			<td>Last Name*</td>
			<td><input type="text" name="lName" required /></td>
		</tr>
		<tr>
			<td>How was your<br />experience at this<br />event?*</td>
			<td><textarea name="feedback" rows="10" cols="30" required></textarea></td>
		</tr>
		<tfoot>
			<tr>
				<td colspan="2" style="text-align: center;">
					<input type="submit" value="Submit Survey"/></td>
			</tr>
		</tfoot>
	</table>
</form>';

	$page = new Page($styles, $header, $content);
	$page->Display();
?>