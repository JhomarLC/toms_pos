<?php
$user = json_decode($_COOKIE['account_signed_in'], true);

$query_alog = "INSERT INTO activitylog (account_id, activity_category, activity_description) VALUES (?, ?, ?)";
$stmt_alog = $connection->prepare($query_alog);
$stmt_alog->bind_param("iss", $user['account_id'], $activity_category, $activity_description);
$stmt_alog->execute();
$stmt_alog->close();