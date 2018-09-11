<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Add Record Form</title>
	</head>
	<body>
		<form action="insert.php" method="post">
			<p>
				<label for="first_name">First Name:</label>
				<input type="text" name="first_name" id="first_name">
			</p>
			<p>
				<label for="last_name">Last Name:</label>
				<input type="text" name="last_name" id="last_name">
			</p>
			<p>
				<label for="email_address">E-Mail Address:</label>
				<input type="text" name="email_address" id="email_address">
			</p>
			<input type="submit" value="Submit">
		</form>
	</body>
</html>