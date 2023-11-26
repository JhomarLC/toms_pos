<?php
session_start();
require("./db_connection.php");

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    
    $query = "SELECT * FROM accounts WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $response =  $stmt->get_result();
    
    if($response->num_rows > 0){
        $user = $response->fetch_assoc();

        $needUserData = array(
            "account_id" => $user['account_id'], 
            "full_name" => $user['full_name'],
            "email" => $user['email'],
            "username" => $user['username'],
            "role" => $user['role'], 
            "status" => $user['status'], 
        );
        
        if(password_verify($password, $user['password'])){
            if($user['role'] == "Admin"){
                setcookie("account_signed_in", json_encode($needUserData), time() + 86400, "/", "", true, true);
                header("Location: ../admin");
            } elseif ($user['role'] == "Staff") {
                setcookie("account_signed_in", json_encode($needUserData), time() + 86400, "/", "", true, true);
                header("Location: ../staff");
            } else {
                $_SESSION['alert'] = array(
                    "message" => "Undefined Role",
                    "type" => "error"
                );
                header("Location: ../");
            }
        } else {
            $_SESSION['alert'] = array(
                "message" => "Invalid email or password",
                "type" => "error"
            );
        }
    } else {
        $_SESSION['alert'] = array(
            "message" => "Invalid email or password",
            "type" => "error"
        );
    }
    header("Location: ../");
} 

if (isset($_POST['action'])) {
    if ($_POST['action'] == "login_account") {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        
        $query = "SELECT * FROM accounts WHERE username = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $response =  $stmt->get_result();
        
        if($response->num_rows > 0){
            $user = $response->fetch_assoc();
    
            $needUserData = array(
                "account_id" => $user['account_id'], 
                "full_name" => $user['full_name'],
                "email" => $user['email'],
                "username" => $user['username'],
                "role" => $user['role'], 
                "status" => $user['status'], 
            );
            
            if(password_verify($password, $user['password'])){
                if($user['role'] == "Admin"){
                    setcookie("account_signed_in", json_encode($needUserData), time() + 86400, "/", "", true, true);
                    // $activity_description = "Signed In as an admin";
                    // $activity_category = "Signed In";
                    // include("./activitylog.php");
                    
                    echo json_encode(
                        array(
                            "message" => "Account successfully signed in",
                            "type" => "success"
                        )
                    );
                    exit;
                } elseif ($user['role'] == "Staff") {
                    setcookie("account_signed_in", json_encode($needUserData), time() + 86400, "/", "", true, true);
                    // $activity_description = "Signed In as staff";
                    // $activity_category = "Signed In";
                    // include("./activitylog.php");
                    
                    echo json_encode(
                        array(
                            "message" => "Account successfully signed in",
                            "type" => "success"
                        )
                    );
                    exit;
                } else {
                    echo json_encode(
                        array(
                            "message" => "Undefined Role",
                            "type" => "error"
                        )
                    );
                    exit;
                }
            } else {
                echo json_encode(
                    array(
                        "message" => "Invalid email or password",
                        "type" => "error"
                    )
                );
                exit;
            }
        } else {
            echo json_encode(
                array(
                    "message" => "Invalid email or password",
                    "type" => "error"
                )
            );
            exit;
        }
    }
}