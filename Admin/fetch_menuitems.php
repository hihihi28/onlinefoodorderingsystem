

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT COUNT(*) AS totalItems FROM menuitem";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $totalItems = $row["totalItems"];
} else {
  $totalItems = 0;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['totalItems' => $totalItems]);
?>
