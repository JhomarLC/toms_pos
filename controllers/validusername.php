<?php
session_start();
require("./db_connection.php");

$usernameToCheck = $_POST['username'];

$sql = "SELECT * FROM accounts WHERE username = '$usernameToCheck'";
$result = $connection->query($sql);

// Check if the username exists
if ($result->num_rows > 0) {
    echo json_encode(array('valid' => false, 'message' => 'Username already exists'));
} else {
    echo json_encode(array('valid' => true, 'message' => 'Username is available'));
}

?>