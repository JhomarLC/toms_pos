<?php
session_start();
require("./db_connection.php");

if(isset($_POST['action'])){
    if($_POST['action'] == "add_expense"){
        $expense_name = mysqli_real_escape_string($connection, $_POST['expense_name']);
        $amount = mysqli_real_escape_string($connection, $_POST['amount']);
        
        $query = "INSERT INTO expenseInventory (expense_name, expense_total) VALUE (?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("si", $expense_name, $amount);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $activity_description = "Add new expense inventory";
            include("../controllers/activitylog.php");
            echo json_encode(
                array(
                    "message" => "Expense successfully added!",
                    "type" => "success"
                )
            );
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "No new menu expense were created.",
                    "type" => "info"
                )
            ); 
            exit;
        }
        $stmt->close();
    }
    if($_POST['action'] == "get_expense_details"){
        $expense_id = mysqli_real_escape_string($connection, $_POST['expense_id']);
        $query = "SELECT * FROM expenseInventory WHERE expense_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $expense_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $expense = $result->fetch_assoc();
            echo json_encode(
                array(
                    "expense_id" => $expense['expense_id'],
                    "expense_name" => $expense['expense_name'],
                    "expense_total" => $expense['expense_total'],
                )
            );
            exit;
        }
        $stmt->close();
    }
    if($_POST['action'] == "update_expense"){
        $expense_id = mysqli_real_escape_string($connection, $_POST['expense_id']);
        $expense_name = mysqli_real_escape_string($connection, $_POST['expense_name']);
        $expense_total = mysqli_real_escape_string($connection, $_POST['expense_total']);

        $query = "UPDATE expenseInventory SET expense_name = ?, expense_total = ? WHERE expense_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sii", $expense_name, $expense_total, $expense_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            // $activity_description = "Update expense";
            // include("./activitylog.php");
            echo json_encode(
                array(
                    "message" => "Expense successfully updated!",
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
    if($_POST['action'] == "delete_expense"){
        $expense_id = mysqli_real_escape_string($connection, $_POST['expense_id']);

        $query = "DELETE FROM expenseInventory WHERE expense_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $expense_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            // $activity_description = "Update expense";
            // include("./activitylog.php");
            echo json_encode(
                array(
                    "message" => "Expense successfully deleted!",
                    "type" => "success"
                )
            );
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "There's no expense deleted.",
                    "type" => "info"
                )
            );
            exit;
        }
        $stmt->close();
    }
}