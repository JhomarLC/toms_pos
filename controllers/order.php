<?php
session_start();
require("./db_connection.php");
$user = json_decode($_COOKIE['account_signed_in'], true);

if (isset($_POST['action'])) {
    if ($_POST['action'] == "save_order") {
        $account_id = $user['account_id'];
        $order_method = mysqli_real_escape_string($connection, $_POST['order_method']);
        $payment_method = mysqli_real_escape_string($connection, $_POST['payment_method']);
        $customer_cash = mysqli_real_escape_string($connection, $_POST['customer_cash']);
        $change_amount = mysqli_real_escape_string($connection, $_POST['change']);
        $leftover = mysqli_real_escape_string($connection, $_POST['leftover']);
        $discount = mysqli_real_escape_string($connection, $_POST['discount']);
        $grand_total = mysqli_real_escape_string($connection, $_POST['grand_total']);

        $prefix = "TOMS";
        $date = date("Ymd");
        $uniqueIdentifier = mt_rand(1000, 9999);
        $order_id = $prefix . $date . $uniqueIdentifier;

        $connection->begin_transaction(); // Start the transaction

        // First set of statements
        $query = "INSERT INTO `orders` (order_id, account_id, order_method, payment_method, cash, change_amount, discount, leftover, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtOrders = $connection->prepare($query);
        $stmtOrders->bind_param("sissiiiii", $order_id, $account_id, $order_method, $payment_method, $customer_cash, $change_amount, $discount, $leftover, $grand_total);
        $stmtOrders->execute();

        if ($stmtOrders->affected_rows > 0) {
            $query = "INSERT INTO orderItems (order_id, item_id, quantity, price, item_total) VALUES (?, ?, ?, ?, ?)";
            $stmtOrderItems = $connection->prepare($query);
            $stmtOrderItems->bind_param("siiii", $order_id, $item_id, $quantity, $price, $subtotal);

            foreach ($_POST['orderItems'] as $item) {
                $item_id = $item['item_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                $subtotal = $item['subtotal'];

                $stmtOrderItems->execute();

                if ($stmtOrderItems->affected_rows <= 0) {
                    $connection->rollback(); // Rollback the transaction on error
                    echo json_encode(array("message" => "Error in executing the statement.", "type" => "error"));
                    exit;
                }

                // Re-bind parameters for the next iteration
                $stmtOrderItems->bind_param("siiii", $order_id, $item_id, $quantity, $price, $subtotal);
            }

            $connection->commit(); // Commit the transaction

            echo json_encode(array("message" => "Order was successfully made.", "type" => "success"));
            exit;
        } else {
            $connection->rollback(); // Rollback the transaction on error
            echo json_encode(array("message" => "No orders were made.", "type" => "info"));
            exit;
        }

        $stmtOrders->close();
        $stmtOrderItems->close();
    }
}
?>