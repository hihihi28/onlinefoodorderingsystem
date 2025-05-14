<?php
header('Content-Type: application/json');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "
    SELECT 
        c.catName AS Category,
        DATE(o.order_date) AS OrderDate,
        SUM(o.grand_total) AS TotalEarnings
    FROM 
        orders o
    JOIN 
        order_items oi ON o.order_id = oi.order_id
    JOIN 
        menuitem mi ON oi.itemName = mi.itemName
    JOIN 
        menucategory c ON mi.catName = c.catName
    GROUP BY 
        c.catName, DATE(o.order_date)
    ORDER BY 
        DATE(o.order_date), c.catName;
";

// Execute the query
$result = $conn->query($sql);

$categories = [];
$dates = [];

while ($row = $result->fetch_assoc()) {
    $category = $row['Category'];
    $date = $row['OrderDate'];
    $totalEarnings = $row['TotalEarnings'];

    if (!isset($categories[$category])) {
        $categories[$category] = [];
    }

    if (!in_array($date, $dates)) {
        $dates[] = $date;
    }

    $categories[$category][$date] = $totalEarnings;
}

$conn->close();


sort($dates);


$earningsArray = [];
foreach ($categories as $category => $data) {
    $earningsArray[$category] = [];
    foreach ($dates as $date) {
        $earningsArray[$category][] = isset($data[$date]) ? $data[$date] : 0;
    }
}

echo json_encode([
    'dates' => $dates,
    'categories' => array_keys($earningsArray),
    'earnings' => $earningsArray
]);
?>
