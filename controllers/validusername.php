<?php
session_start();
require("./db_connection.php");

$usernameToCheck = $_POST['username'];
$currentUsername = $_POST['current_username'];

$sql = "SELECT * FROM accounts WHERE username = '$usernameToCheck' AND username != '$currentUsername'";
$result = $connection->query($sql);

// Check if the username exists
if ($result->num_rows > 0) {
    echo json_encode(array('valid' => false, 'message' => 'Username already exists' . $currentUsername));
} else {
    echo json_encode(array('valid' => true, 'message' => 'Username is available'));
}

?>