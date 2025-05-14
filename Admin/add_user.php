<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
   


   
    $sql = "INSERT INTO users (email, firstName, lastName, contact, password) 
            VALUES (?, ?, ?, ?, ?)";

  
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssss", $email, $firstName, $lastName, $contact, $password);

   
    if ($stmt->execute()) {
        echo '<script>alert("User Added successfully!"); window.location.href="users.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

  
    $stmt->close();
}


$conn->close();
?>