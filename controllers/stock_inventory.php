<?php
header('Content-Type: application/json');
session_start();
require("./db_connection.php");

if(isset($_POST['action'])){
    if($_POST['action'] == "get_stock_details"){
        $stock_id = mysqli_real_escape_string($connection, $_POST['stock_id']);
        $query = "SELECT * FROM stockInventory WHERE stock_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $stock_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            while($stock = $result->fetch_assoc()){
                echo json_encode(
                    array(
                        "stock_id" => $stock['stock_id'],
                        "stock_category" => $stock['stock_category'],
                        "delivery" => $stock['delivery'],
                        "total_out" => $stock['total_out'],
                        "price" => $stock['price_today'],
                    )
                );
                exit;
            }
        }
        $stmt->close();
    }
    if($_POST['action'] == "update_stock"){
        $stock_id = mysqli_real_escape_string($connection, $_POST['stock_id']);
        $delivery = mysqli_real_escape_string($connection, $_POST['delivery']);
        $total_out = mysqli_real_escape_string($connection, $_POST['total_out']);
        $price_today = mysqli_real_escape_string($connection, $_POST['price_today']);
        $stock_category = mysqli_real_escape_string($connection, $_POST['stock_category']);

        $query = "UPDATE stockinventory
        SET
            old_stock = COALESCE((SELECT newstock FROM stockinventory WHERE stock_category = ? ORDER BY stock_date DESC LIMIT 1 OFFSET 1), 0),
            delivery = ?,
            total_stock = COALESCE((SELECT newstock FROM stockinventory WHERE stock_category = ? ORDER BY stock_date DESC LIMIT 1 OFFSET 1), 0) + ?,
            total_out = ?,
            newstock = (COALESCE((SELECT newstock FROM stockinventory WHERE stock_category = ? ORDER BY stock_date DESC LIMIT 1 OFFSET 1), 0) + ?) - ?,
            price_today = ?,
            expense_today = ? * ?
        WHERE
            stock_id = ?;";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sisiisiiiiii", $stock_category, $delivery, $stock_category, $delivery, $total_out, $stock_category, $delivery, $total_out, $price_today, $total_out, $price_today, $stock_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $activity_description = "Updated $stock_category stock";
            $activity_category = "Stock";
            include("./activitylog.php");
            
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
    }
    if($_POST['action'] == "add_stock"){
        $stock_category = mysqli_real_escape_string($connection, $_POST['stock_category']);
        $delivery_today = mysqli_real_escape_string($connection, $_POST['delivery']);
        $total_out = mysqli_real_escape_string($connection, $_POST['total_out']);
        
        $checkQuery = "SELECT COUNT(*) FROM stockinventory WHERE stock_date = CURDATE() && stock_category = ?";
        $stmt = $connection->prepare($checkQuery);
        $stmt->bind_param("s", $stock_category);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        
        if ($row[0] > 0) {
            echo json_encode(
                array(
                    "message" => "You can only add " . $stock_category . " stock per day.",
                    "type" => "error"
                )
            );
            exit;
        } else {
            $query = "INSERT INTO stockinventory (stock_category, stock_date, old_stock, delivery, total_stock, total_out, newstock)
            SELECT
                ? as stock_category,
                CURDATE() as stock_date,
                COALESCE((SELECT newstock FROM stockinventory WHERE stock_category = ? ORDER BY stock_date DESC LIMIT 1), 0) as old_stock,
                ? as delivery,
                COALESCE((SELECT newstock FROM stockinventory WHERE stock_category = ? ORDER BY stock_date DESC LIMIT 1), 0) + ? as total_stock,
                ? as total_out,
                (COALESCE((SELECT newstock FROM stockinventory WHERE stock_category = ? ORDER BY stock_date DESC LIMIT 1), 0) + ?) - ? as newstock;
            ";

            $stmt = $connection->prepare($query);
            $stmt->bind_param("ssisiisii", $stock_category, $stock_category, $delivery_today, $stock_category, $delivery_today, $total_out, $stock_category, $delivery_today, $total_out);
            $success = $stmt->execute();

            if ($success) {
                $activity_description = "Added $stock_category stock";
                $activity_category = "Stock";
                include("./activitylog.php");
                
                echo json_encode(
                    array(
                        "message" => "Stock successfully added.",
                        "type" => "success"
                    )
                );
                exit;
            } else {
                echo json_encode(
                    array(
                        "message" => "No new stock was created. Error: No inserted ID.",
                        "type" => "info"
                    )
                );
                exit;
            }
            $stmt->close();
        }
    }
}
?>