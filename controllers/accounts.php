<?php
session_start();
require("./db_connection.php");

if (isset($_POST['edit'])) {
    $account_id = mysqli_real_escape_string($connection, $_POST['edit']);
    $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);

    $query = "UPDATE accounts SET full_name = ?, username = ?, email = ?, status = ? WHERE account_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssssi", $full_name, $username, $email, $status, $account_id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0){
        $_SESSION['alert'] = array(
            "message" => "Account successfully updated!",
            "type" => "success"
        );  
        
        $activity_description = "Updated account details: $full_name, $username, $email, Status: $status";
        include("../controllers/activitylog.php");

        header("Location: ../admin/");
    } else {
        $_SESSION['alert'] = array(
            "message" => "No changes were made to the account.",
            "type" => "info"
        );
        header("Location: ../admin/");
    }
    $stmt->close();
}

if (isset($_POST['add'])) {
    if(isset($_COOKIE['correct_values'])){
        setcookie("correct_values", "", time() - 3600, "/", "", true, true);
    }
    $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $cpassword = mysqli_real_escape_string($connection, $_POST['cpassword']);
   
    if($password !== $cpassword){
        $correctValues = array(
            "full_name" => $full_name, 
            "username" => $username, 
            "email" => $email, 
        );
    
        setcookie("correct_values", json_encode($correctValues), time() + 3600, "/", "", true, true);

        $_SESSION['alert'] = array(
            "message" => "Password does not match!",
            "type" => "error"
        );
        header("Location: ../admin/account-add/");
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO accounts (username, password, email, full_name) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $full_name);
        $stmt->execute();
        
        if($stmt->affected_rows > 0){
            $_SESSION['alert'] = array(
                "message" => "Account successfully added!",
                "type" => "success"
            );  
            
            $activity_description = "Add new staff account";
            include("../controllers/activitylog.php");
    
            header("Location: ../admin/");
        } else {
            $_SESSION['alert'] = array(
                "message" => "No new account created.",
                "type" => "info"
            );
            header("Location: ../admin/");
        }
        $stmt->close();
    }

}

if(isset($_POST['action'])){
    if($_POST['action'] == "get_staff_details"){
        $staff_id = mysqli_real_escape_string($connection, $_POST['staff_id']);
        $query = "SELECT * FROM accounts WHERE account_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            while($account = $result->fetch_assoc()){
                echo json_encode(
                    array(
                        "staff_id" => $account['account_id'],
                        "full_name" => $account['full_name'],
                        "username" => $account['username'],
                        "current_username" => $account['username'],
                        "email" => $account['email'],
                        "status" => $account['status'],
                    )
                );
                exit;
            }
        }
        $stmt->close();
    }
    
    if($_POST['action'] == "add_staff"){
        $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $cpassword = mysqli_real_escape_string($connection, $_POST['cpassword']);
        $query = "SELECT * FROM accounts WHERE username = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    
        if($stmt->num_rows() > 0){
            $_SESSION['alert'] = array(
                "message" => "Username already exist!",
                "type" => "error"
            );  
            exit;
        } 
        $stmt->close();
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO accounts (username, password, email, full_name) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $full_name);
        $stmt->execute();
        
        if($stmt->affected_rows > 0){
            $activity_description = "Add new staff account";
            $activity_category = "Staff Accounts";
            include("./activitylog.php");
            
            echo json_encode(
                array(
                    "message" => "Account successfully added!",
                    "type" => "success"
                )
            );
            
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "No new account created.",
                    "type" => "info"
                )
            );
            exit;

        }
        $stmt->close();
    
    }

    if($_POST['action'] == "update_staff"){
        $account_id = mysqli_real_escape_string($connection, $_POST['staff_id']);
        $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $status = mysqli_real_escape_string($connection, $_POST['status']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        if(empty($password)){
            $query = "UPDATE accounts SET full_name = ?, username = ?, email = ?, status = ? WHERE account_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ssssi", $full_name, $username, $email, $status, $account_id);
            $stmt->execute();
        } else {
            $query = "UPDATE accounts SET full_name = ?, username = ?, email = ?, status = ?, password = ? WHERE account_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("sssssi", $full_name, $username, $email, $status, $hashed_password, $account_id);
            $stmt->execute();
        }
      
        if($stmt->affected_rows > 0){
            $activity_description = "Update account details";
            $activity_category = "Staff Accounts";
            include("./activitylog.php");

            echo json_encode(
                array(
                    "message" => "Account successfully updated!",
                    "type" => "success"
                )
            );
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "No account updated.",
                    "type" => "info"
                )
            );
            exit;

        }
        $stmt->close();
    
    }
}

    // $user = json_decode($_COOKIE['account_signed_in'], true);


    // if($_POST['action'] == "get_staffs"){
    //     $acc_query = "SELECT account_id, full_name, username, email, role, status, created_at FROM accounts WHERE account_id != ?";
    //     $acc_stmt = $connection->prepare($acc_query);
    //     $acc_stmt->bind_param("i", $user['account_id']);
    //     $acc_stmt->execute();
    //     $result =  $acc_stmt->get_result();
    //     $staff_data = "";
    //     if($result->num_rows > 0){
    //         while($accounts = $result->fetch_assoc()){
    //             $acc_created_at = date("M d, Y | h:i:s A", strtotime($accounts['created_at']));
    //             $staff_data .= '<tr>';
    //                 $staff_data .= '<td>';
    //                     $staff_data .= '<div class="form-check form-check-sm form-check-custom form-check-solid"> <input class="form-check-input" type="checkbox" value="1" /> </div>';
    //                 $staff_data .= '</td>';
    //                 $staff_data .= '<td>' . $accounts['full_name'] . '</td>';
    //                 $staff_data .= '<td>';
    //                     $staff_data .= '<div class="badge badge-light fw-bold">' . $accounts['username'] . '</div>';
    //                 $staff_data .= '</td>';
    //                 $staff_data .= '<td>' . $accounts['email'] . '</td>';
    //                 if ($accounts['status'] == "Active"){ 
    //                     $staff_data .= '<td><div class="badge badge-light-success fw-bold">Active</div></td>';
    //                 } elseif ($accounts['status'] == "Inactive"){ 
    //                     $staff_data .= '<td><div class="badge badge-light-danger fw-bold">Inactive</div></td>';
    //                 } 
    //                 $staff_data .= "<td>" . $acc_created_at . "</td>";
    //                 $staff_data .= '<td class="text-end">';
    //                     $staff_data .= '<div class="menu-item px-3">';
    //                         $staff_data .= '<a href="../" class="menu-link px-3">Edit</a>';
    //                     $staff_data .= '</div>';
    //                 $staff_data .= '</td>';
    //             $staff_data .= '</tr>';
    //         }
    //         echo json_encode(
    //             array("staff_data" => $staff_data)
    //         );
    //     }
    // } else {
    //     echo json_encode(
    //         array("shet" => "Shett")
    //     );
    // }