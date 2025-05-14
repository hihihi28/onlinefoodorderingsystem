<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT COUNT(*) AS totalReservations FROM reservations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $totalReservations = $row["totalReservations"];
} else {
  $totalReservations = 0;
}

$conn->close();


header('Content-Type: application/json');
echo json_encode(['totalReservations' => $totalReservations]);
?>

