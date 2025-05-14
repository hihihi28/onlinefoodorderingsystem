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
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $noOfGuests = $_POST['noOfGuests'];
    $reservedTime = $_POST['reservedTime']; 
    $reservedDate = $_POST['reservedDate']; 

 
    echo "Raw Reserved Time: " . htmlspecialchars($reservedTime) . "<br>";


    $reservedTimeWithSeconds = date('H:i:s', strtotime($reservedTime));
    
   
    echo "Processed Reserved Time: " . htmlspecialchars($reservedTimeWithSeconds) . "<br>";


    $sql = "INSERT INTO reservations (email, name, contact, noOfGuests, reservedTime, reservedDate) 
            VALUES (?, ?, ?, ?, ?, ?)";

   
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssiis", $email, $name, $contact, $noOfGuests, $reservedTimeWithSeconds, $reservedDate);


    if ($stmt->execute()) {
        echo '<script>alert("Đặt bàn thành công!"); window.location.href="reservations.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


$conn->close();
?>
