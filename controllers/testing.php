<?php
require("./db_connection.php");

$stock_id = 35;
$delivery = 120;
$total_out = 25;
$price_today = 165;
$stock_category = "Chicken";

$query = "UPDATE stockinventory
SET
    old_stock = COALESCE((SELECT newstock FROM stockinventory WHERE stock_category = ? ORDER BY stock_date DESC LIMIT 1 OFFSET 1), 0),
    delivery = ?,
    total_stock = COALESCE((SELECT newstock FROM stockinventory WHERE stock_category = ? ORDER BY stock_date DESC LIMIT 1 OFFSET 1), 0) + ?,
    total_out = ?,
    newstock = (COALESCE((SELECT newstock FROM stockinventory WHERE stock_category = ? ORDER BY stock_date DESC LIMIT 1 OFFSET 1), 0) + ?) - ?
WHERE
    stock_id = ?;";
$stmt = $connection->prepare($query);
$stmt->bind_param("sisiisiii", $stock_category, $delivery, $stock_category, $delivery, $total_out, $stock_category, $delivery, $total_out, $stock_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(
        array(
            "message" => "Stock successfully updated",
            "type" => "success"
        )
    );
    exit;
} else {
    echo json_encode(
        array(
            "message" => "There's no changes.",
            "type" => "info"
        )
    );
    exit;
}
$stmt->close();

?>