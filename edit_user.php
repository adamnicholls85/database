<?php
require('config.php');
require('database.class.php');

$database = new database($db_host, $db_name, $db_username, $db_password);
$edit_user = $database->select_row('users', $_REQUEST);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Edit User - <?php echo $edit_user[0]['first_name'] . " " . $edit_user[0]['last_name']; ?></title>
	</head>
	<body>
		<form action="update_user.php?id=<?php echo $edit_user[0]['id']; ?>" method="post">
			<p>
				<label for="first_name">First Name:</label>
				<input type="text" name="first_name" id="first_name" value="<?php echo $edit_user[0]['first_name']; ?>">
			</p>
			<p>
				<label for="last_name">Last Name:</label>
				<input type="text" name="last_name" id="last_name" value="<?php echo $edit_user[0]['last_name']; ?>">
			</p>
			<p>
				<label for="email_address">E-Mail Address:</label>
				<input type="text" name="email_address" id="email_address" value="<?php echo $edit_user[0]['email_address']; ?>">
			</p>
			<input type="submit" value="Submit">
		</form>
	</body>
</html>