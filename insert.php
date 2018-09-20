<?php
require('config.php');
require('database.class.php');

$database = new database($db_host, $db_name, $db_username, $db_password);
$database->insert_row('users', $_REQUEST);
?>