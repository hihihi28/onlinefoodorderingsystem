<?php
include('db_connection.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $catName = $_POST['catName'];

    
    $catName = mysqli_real_escape_string($conn, $catName);

    
    $sql = "DELETE FROM menucategory WHERE catName='$catName'";
    if (mysqli_query($conn, $sql)) {
        echo "Category deleted successfully.";
    } else {
        echo "Error deleting category: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
