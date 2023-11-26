<?php
session_start();
require("../../controllers/db_connection.php");

$user = json_decode($_COOKIE['account_signed_in'], true);
$activity_description = "Accessing the admin page";

$query = "INSERT INTO activitylog (account_id, activity_description) VALUES (?, ?)";
$stmt = $connection->prepare($query);
$stmt->bind_param("is", $user['account_id'], $activity_description);
$stmt->execute();

if($stmt->affected_rows > 0){
    $_SESSION['alert'] = array(
        "message" => "You have no access to that page!",
        "type" => "error"
    );
    header("Location: ../../staff");
}