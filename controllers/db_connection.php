<?php 
$server_name = "localhost";
$username = "root";
$password = "";
$database = "toms";
$connection = new mysqli($server_name, $username, $password, $database);

if($connection->connect_error){
    die ("Connection Failed! " . $connection->connect_error);
}
?>