<?php
$user = json_decode($_COOKIE['account_signed_in'], true);

$query = "INSERT INTO activitylog (account_id, activity_description) VALUES (?, ?)";
$stmt = $connection->prepare($query);
$stmt->bind_param("is", $user['account_id'], $activity_description);
$stmt->execute();
$stmt->close();