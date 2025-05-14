<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemName = $_POST['itemName'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $catName = $_POST['catName'];
    $dateCreated = date("Y-m-d H:i:s");
    $updatedDate = date("Y-m-d H:i:s");

    // Xử lý tải lên tệp
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    
    // Cho phép tất cả các định dạng tệp
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        
        $uploadOk = 1;
    } else {
        // Remove the image check if you want to accept any file
        // echo "File is not an image.";
        // $uploadOk = 0;
    }

 
    if ($_FILES["image"]["size"] > 50000000) { 
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";

    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $_FILES["image"]["name"];
            $stmt = $conn->prepare("INSERT INTO menuitem (itemName, price, description, image, status, catName, dateCreated, updatedDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $itemName, $price, $description, $image, $status, $catName, $dateCreated, $updatedDate);

            if ($stmt->execute()) {
                echo '<script>alert("New item added successfully."); window.location.href="admin_menu.php";</script>';
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $conn->close();
    
    header("Location: admin_menu.php");
    exit();
}
?>
