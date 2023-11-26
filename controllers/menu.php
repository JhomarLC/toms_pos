<?php
session_start();
require("./db_connection.php");

if(isset($_POST['action'])){
    if($_POST['action'] == "get_category_details"){
        $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
        $query = "SELECT * FROM category WHERE category_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->num_rows > 0){
            while($category = $result->fetch_assoc()){
                echo json_encode(
                    array(
                        "category_id" => $category['category_id'],
                        "category_image" => $category['image'],
                        "category_name" => $category['category_name'],
                    )
                );
                exit;
            }
        }
        $stmt->close();
    }
    
    if($_POST['action'] == "add_category"){
        $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);

        $target_dir = "../images/uploads/";
    
        if (isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name'])) {
            $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $file_name = uniqid();
            // Create a new name for the uploaded file (you can use a variety of methods to generate a unique name)
            $new_file_name = "TOMSCATEGORY" . $file_name . "." . $imageFileType;

            $target_file = $target_dir . $new_file_name;
            include("./upload_category.php");
            
            if($uploadOk == 1){
                $query = "INSERT INTO category (image, category_name) VALUE (?, ?)";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("ss", $new_file_name, $category_name);
                $stmt->execute();
                if($stmt->affected_rows > 0){
                    if(move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)){
                        $activity_description = "Added new menu category";
                        $activity_category = "Menu Category";
                        include("./activitylog.php");
                        
                        echo json_encode(
                            array(
                                "message" => "Category successfully added!",
                                "type" => "success"
                            )
                        );
                        exit;
                    } else {
                        echo json_encode(
                            array(
                                "message" => "Sorry, there was an error uploading your file.",
                                "type" => "error"
                            )
                        );
                        exit;
                    }
                } else {
                    echo json_encode(
                        array(
                            "message" => "No new menu item created.",
                            "type" => "info"
                        )
                    ); 
                    exit;
                }
                $stmt->close();
            }
        } else {
            $default_img_name = "do-not-delete/logo.png";
            $query = "INSERT INTO category (image, category_name) VALUE (?, ?)";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ss", $default_img_name, $category_name);
            $stmt->execute();
            
            if($stmt->affected_rows > 0){
                $activity_description = "Added new menu category";
                $activity_category = "Menu Category";
                include("./activitylog.php");
                
                echo json_encode(
                    array(
                        "message" => "Category successfully added!",
                        "type" => "success"
                    )
                );
                exit;
            } else {
                echo json_encode(
                    array(
                        "message" => "No new menu category created.",
                        "type" => "info"
                    )
                );
                exit;
    
            }
            $stmt->close();
        }
        
    }
    
    
    if($_POST['action'] == "add_item"){
        $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
        $item_name = mysqli_real_escape_string($connection, $_POST['item_name']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);
        
        $target_dir = "../images/uploads/";

        if (isset($_FILES['item_image']['name']) && !empty($_FILES['item_image']['name'])) {
            $target_file = $target_dir . basename($_FILES["item_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $file_name = uniqid();
            // Create a new name for the uploaded file (you can use a variety of methods to generate a unique name)
            $new_file_name = "TOMSITEM" . $file_name . "." . $imageFileType;

            $target_file = $target_dir . $new_file_name;
            include("./upload.php");
            
            if($uploadOk == 1){
                $query = "INSERT INTO items (category_id, item_name, price, image, description) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("isiss", $category_id, $item_name, $price, $new_file_name, $description);
                $stmt->execute();
                if($stmt->affected_rows > 0){
                    if(move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)){
                        $activity_description = "Added new menu item";
                        $activity_category = "Menu Item";
                        include("./activitylog.php");
                        
                        echo json_encode(
                            array(
                                "message" => "Item successfully added!",
                                "type" => "success"
                            )
                        );
                        $activity_description = "Add new menu item";
                        include("../controllers/activitylog.php");
                        exit;
                    } else {
                        echo json_encode(
                            array(
                                "message" => "Sorry, there was an error uploading your file.",
                                "type" => "error"
                            )
                        );
                        exit;
                    }
                } else {
                    echo json_encode(
                        array(
                            "message" => "No new menu item created.",
                            "type" => "info"
                        )
                    ); 
                    exit;
                }
                $stmt->close();
            } else {
                echo json_encode(
                    array(
                        "message" => "Please upload valid image only",
                        "type" => "error"
                    )
                );
            }
        } else {
            $default_img_name = "do-not-delete/logo.png";
            $query = "INSERT INTO items (category_id, item_name, price, image, description) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("isiss", $category_id, $item_name, $price, $default_img_name, $description);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                $activity_description = "Added new menu item";
                $activity_category = "Menu Item";
                include("./activitylog.php");
                
                echo json_encode(
                    array(
                        "message" => "Item successfully added!",
                        "type" => "success"
                    )
                ); 
                exit;
            } else {
                echo json_encode(
                    array(
                        "message" => "No new menu item created.",
                        "type" => "info"
                    )
                ); 
                exit;
            }
            $stmt->close();
        }
       
    }
    if($_POST['action'] == "update_category"){
        $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
        $category_name = mysqli_real_escape_string($connection, $_POST['category_name']);
        $image_old = mysqli_real_escape_string($connection, $_POST['image_old']);

        $uploadOk = 1;
        $target_dir = "../images/uploads";
        
  
        // Check if a file was uploaded
        if (isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name'])) {
            $image = mysqli_real_escape_string($connection, $_FILES['category_image']['name']);
            $target_file = $target_dir . "/" . basename($_FILES["category_image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $file_name = uniqid();
            // Create a new name for the uploaded file (you can use a variety of methods to generate a unique name)
            $new_file_name = "TOMSCATEGORY" . $file_name . "." . $imageFileType;
            $target_file = $target_dir . "/" . $new_file_name;

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)) {
                    if($image_old !== "do-not-delete/logo.png"){
                        if (file_exists($target_dir . "/" . $image_old)) {
                            unlink($target_dir . "/" . $image_old);
                        }
                    }
                    
                    $query = "UPDATE category SET image = ?, category_name = ? WHERE category_id = ?";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("ssi", $new_file_name, $category_name, $category_id);
                    $stmt->execute();
                    
                    if ($stmt->affected_rows > 0) {
                        $activity_description = "Updated the menu category";
                        $activity_category = "Menu Category";
                        include("./activitylog.php");
                        
                        echo json_encode(
                            array(
                                "message" => "Category successfully updated!",
                                "type" => "success"
                            )
                        );
                        exit;
                    } else {
                        $activity_description = "Update menu category";
                        include("./activitylog.php");
                        echo json_encode(
                            array(
                                "message" => "No new menu category created.",
                                "type" => "info"
                            )
                        );
                        exit;
                    }
                    $stmt->close();
                } else {
                    echo json_encode(
                        array(
                            "message" => "Sorry, there was an error uploading your file.",
                            "type" => "error"
                        )
                    );
                    exit;
                }
            } else {
                echo json_encode(
                    array(
                        "message" => "Please upload a valid image only",
                        "type" => "error"
                    )
                );
                exit;
            }
        } else {
            $query = "UPDATE category SET category_name = ? WHERE category_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("si", $category_name, $category_id);
            $stmt->execute();
          
            if($stmt->affected_rows > 0){
                $activity_description = "Updated the menu category";
                $activity_category = "Menu Category";
                include("./activitylog.php");
                
                echo json_encode(
                    array(
                        "message" => "Category successfully updated!",
                        "type" => "success"
                    )
                );
                $activity_description = "Edit category menu";
                include("./activitylog.php");
                exit;
    
            } else {
                echo json_encode(
                    array(
                        "message" => "No category menu updated.",
                        "type" => "info"
                    )
                );
                exit;
            }
            $stmt->close();
        }
    }
    if($_POST['action'] == "get_item_details"){
        $item_id = mysqli_real_escape_string($connection, $_POST['item_id']);
        $query = "SELECT * FROM items WHERE item_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $_POST['item_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $item = $result->fetch_assoc();
            echo json_encode(
                array(
                    "item_id" => $item['item_id'],
                    "category_id" => $item['category_id'],
                    "item_name" => $item['item_name'],
                    "price" => $item['price'],
                    "description" => $item['description'],
                    "item_image" => $item['image'],
                )
            );
            exit;
        }
        $stmt->close();
    }
    if($_POST['action'] == "update_item"){
        $item_id = mysqli_real_escape_string($connection, $_POST['item_id']);
        $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
        $item_name = mysqli_real_escape_string($connection, $_POST['item_name']);
        $image_old = mysqli_real_escape_string($connection, $_POST['image_old']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);
    
        $uploadOk = 1;
        $target_dir = "../images/uploads";
        
        // Check if a file was uploaded
        if (isset($_FILES['item_image']['name']) && !empty($_FILES['item_image']['name'])) {
            $image = mysqli_real_escape_string($connection, $_FILES['item_image']['name']);
            $target_file = $target_dir . "/" . basename($_FILES["item_image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $file_name = uniqid();
            // Create a new name for the uploaded file (you can use a variety of methods to generate a unique name)
            $new_file_name = "TOMSITEM" . $file_name . "." . $imageFileType;
            $target_file = $target_dir . "/" . $new_file_name;
    
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
                    if($image_old !== "do-not-delete/logo.png"){
                        if (file_exists($target_dir . "/" . $image_old)) {
                            unlink($target_dir . "/" . $image_old);
                        }
                    }
    
                    $query = "UPDATE items SET category_id = ?, item_name = ?, price = ?, image = ?, description = ? WHERE item_id = ?";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("isissi", $category_id, $item_name, $price, $new_file_name, $description, $item_id);
                    $stmt->execute();
    
                    if ($stmt->affected_rows > 0) {
                        $activity_description = "Updated the menu item";
                        $activity_category = "Menu Item";
                        include("./activitylog.php");
                        
                        echo json_encode(
                            array(
                                "message" => "Item successfully updated!",
                                "type" => "success"
                            )
                        );
                        exit;
                    } else {
                        echo json_encode(
                            array(
                                "message" => "No new menu item created.",
                                "type" => "info"
                            )
                        );
                        exit;
                    }
                    $stmt->close();
                } else {
                    echo json_encode(
                        array(
                            "message" => "Sorry, there was an error uploading your file.",
                            "type" => "error"
                        )
                    );
                    exit;
                }
            } else {
                echo json_encode(
                    array(
                        "message" => "Please upload a valid image only",
                        "type" => "error"
                    )
                );
                exit;
            }
        } else {
            // No file uploaded, use the existing image value
            $query = "UPDATE items SET category_id = ?, item_name = ?, price = ?, description = ? WHERE item_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("isisi", $category_id, $item_name, $price, $description, $item_id);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) {
                $activity_description = "Updated the menu item";
                $activity_category = "Menu Item";
                include("./activitylog.php");
                
                echo json_encode(
                    array(
                        "message" => "Item successfully updated!",
                        "type" => "success"
                    )
                );
                exit;
            } else {
                echo json_encode(
                    array(
                        "message" => "No new menu item created.",
                        "type" => "info"
                    )
                );
                exit;
            }
            $stmt->close();
        }
    }
    
    if($_POST['action'] == "archive_item"){
        $item_id = mysqli_real_escape_string($connection, $_POST['item_id']);
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        $query = "UPDATE items SET status = ? WHERE item_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("si", $status, $item_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $activity_description = ucfirst($status) . " menu item";
            $activity_category = "Menu Item";
            include("./activitylog.php");
            
            echo json_encode(
                array(
                    "message" => "Item successfully " . $status,
                    "type" => "success"
                )
            );
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "Item failed to " . $status,
                    "type" => "error"
                )
            );
            exit;
        }
        $stmt->close();
    }

    if($_POST['action'] == "archive_category"){
        $category_id = mysqli_real_escape_string($connection, $_POST['category_id']);
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        $query = "UPDATE category SET status = ? WHERE category_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("si", $status, $category_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $activity_description = ucfirst($status) . " menu category";
            $activity_category = "Menu Category";
            include("./activitylog.php");
                
            echo json_encode(
                array(
                    "message" => "Category successfully " . $status,
                    "type" => "success"
                )
            );
            exit;
        } else {
            echo json_encode(
                array(
                    "message" => "Category failed to " . $status,
                    "type" => "error"
                )
            );
            exit;
        }
        $stmt->close();
    }
}