<?php
session_start();
require("./db_connection.php");

if(isset($_POST['action'])){
    if($_POST['action'] == "add_voucher"){
        $voucher_code = mysqli_real_escape_string($connection, $_POST['voucher_code']);
        $voucher_percent = mysqli_real_escape_string($connection, $_POST['voucher_percent']);

        $query = "INSERT INTO vouchers (voucher_code, voucher_percent) VALUES (?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("si", $voucher_code, $voucher_percent);
        $stmt->execute();
        
        if($stmt->affected_rows > 0){
            $activity_description = "Added new discount";
            $activity_category = "Discount";
            include("./activitylog.php");
            
            echo json_encode(
                array(
                    "message" => "Voucher successfully added!",
                    "type" => "success"
                )
            );
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "No new voucher were created.",
                    "type" => "info"
                )
            );
            exit;
        }
    }
    if($_POST['action'] == "get_voucher_details"){
        $voucher_id = mysqli_real_escape_string($connection, $_POST['voucher_id']);
        $query = "SELECT * FROM vouchers WHERE voucher_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $voucher_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $voucher = $result->fetch_assoc();
            echo json_encode(
                array(
                    "voucher_id" => $voucher['voucher_id'],
                    "voucher_code" => $voucher['voucher_code'],
                    "voucher_percent" => $voucher['voucher_percent'],
                )
            );
            exit;
        }
        $stmt->close();
    }
    if($_POST['action'] == "update_voucher"){
        $voucher_id = mysqli_real_escape_string($connection, $_POST['voucher_id']);
        $voucher_code = mysqli_real_escape_string($connection, $_POST['voucher_code']);
        $voucher_percent = mysqli_real_escape_string($connection, $_POST['voucher_percent']);
        
        $query = "UPDATE vouchers SET voucher_code = ?, voucher_percent = ? WHERE voucher_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sii", $voucher_code, $voucher_percent, $voucher_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $activity_description = "Updated the discount";
            $activity_category = "Discount";
            include("./activitylog.php");

            echo json_encode(
                array(
                    "message" => "Voucher successfully updated!",
                    "type" => "success",
                )
            );
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "No changes were made.",
                    "type" => "info",
                )
            );
            exit;
        }
        $stmt->close();
    }
    
    if($_POST['action'] == "set_status"){
        $voucher_id = mysqli_real_escape_string($connection, $_POST['voucher_id']);
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        $query = "UPDATE vouchers SET voucher_status = ? WHERE voucher_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("si", $status, $voucher_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $activity_description = "Set the discount " . ucfirst($status);
            $activity_category = "Discount";
            include("./activitylog.php");
            
            echo json_encode(
                array(
                    "message" => "Voucher successfully set to " . $status,
                    "type" => "success"
                )
            );
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "Category failed to set " . $status,
                    "type" => "error"
                )
            );
            exit;
        }
        $stmt->close();
    }
    if ($_POST['action'] == "get_vouchers") {
        $query = "SELECT * FROM vouchers WHERE voucher_status = 'active'";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $vouchers = array();
    
        if ($result->num_rows > 0) {
            while ($voucher = $result->fetch_assoc()) {
                $vouchers[] = array(
                    "voucher_code" => $voucher['voucher_code'],
                    "voucher_percent" => $voucher['voucher_percent'],
                );
            }
        }
    
        $stmt->close();
    
        // Output the entire array as JSON
        echo json_encode($vouchers);
        exit;
    }
    if ($_POST['action'] == "get_items") {
        $query = "SELECT item_name, price FROM items WHERE category_id = 32";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = array();
    
        if ($result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                $items[] = array(
                    "price" => $item['price'],
                    "item_name" => $item['item_name'],
                );
            }
        }
    
        $stmt->close();
    
        // Output the entire array as JSON
        echo json_encode($items);
        exit;
    }
}
?>