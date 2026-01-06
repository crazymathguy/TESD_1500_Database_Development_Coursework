<?php
	require('header.php');
	echo '<link href="form_styles.css" rel="stylesheet" />';
?>

<h1 text-align="center">Application Form</h1>
<form action="form_processed.php" method="post">
	<table>
		<tbody>
			<tr>
				<td>First Name*</td>
				<td><input type="text" name="fName" required /></td>
			</tr>
			<tr>
				<td>Last Name*</td>
				<td><input type="text" name="lName" required /></td>
			</tr>
			<tr>
				<td>Age*</td>
				<td><input type="number" name="age" min="12" max="100" required /></td>
			</tr>
			<tr>
				<td>Gender</td>
				<td><select name="gender">
					<option></option>
					<option value="m">Male</option>
					<option value="f">Female</option>
				</select></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Phone Number*</td>
				<td><input type="tel" name="phone" required /></td>
			</tr>
			<tr>
				<td>Email Address*</td>
				<td><input type="email" name="email" required /></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>T-shirt size*</td>
				<td><select name="tSize" required>
					<option></option>
					<option value="xs">XS</option>
					<option value="s">S</option>
					<option value="m">M</option>
					<option value="l">L</option>
					<option value="xl">XL</option>
				</select></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>Do you have allergies?</td>
				<td><input type="checkbox" name="haveAllergies" /></td>
			</tr>
			<tr>
				<td>If yes, please list</td>
				<td><input type="text" name="allergies" /></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2" style="text-align: center;">
					<input type="submit" value="Submit Application" /></td>
			</tr>
		</tfoot>
	</table>
</form>
</body>

<?php
	require('footer.php');
?>