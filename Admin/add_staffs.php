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
    // Collecting form data
    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];
    $password = $_POST['password'];
   


   
    $sql = "INSERT INTO staff (email, firstName, lastName, contact, role, password) 
            VALUES (?, ?, ?, ?, ?, ?)";

  
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssssss", $email, $firstName, $lastName, $contact, $role, $password);


    if ($stmt->execute()) {
        echo '<script>alert("Thêm thành công!"); window.location.href="staffs.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

  
    $stmt->close();
}


$conn->close();
?>