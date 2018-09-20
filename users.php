<?php
require('config.php');
require('database.class.php');

$database = new database($db_host, $db_name, $db_username, $db_password);

if($_REQUEST) {
	$users = $database->select_all('users', $_REQUEST);
} else {
	$users = $database->select_all('users');
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Users</title>
	</head>
	<body>
		<?php
		if($users) {
		?>
		<table>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>E-Mail Address</th>
				<th>Modify User</th>
			</tr>
			<?php
			for($i = 0; $i < count($users); $i++) {
			?>
			<tr>
				<td><?php echo $users[$i]['first_name']; ?></td>
				<td><?php echo $users[$i]['last_name']; ?></td>
				<td><?php echo $users[$i]['email_address']; ?></td>
				<td><a href="edit_user.php?id=<?php echo $users[$i]['id']; ?>">Edit User</a> | <a href="delete_user.php?id=<?php echo $users[$i]['id']; ?>">Delete User</a></td>
			</tr>
			<?php
			}
			?>
		</table>
		<?php
		} else {
		?>
		<p>No users</p>
		<?php
		}
		?>
	</body>
</html>