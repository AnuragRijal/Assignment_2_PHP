<?php
// Display all errors for debugging purposes (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if a new photo is uploaded
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo'];
        $photoPath = 'cookie/' . basename($photo['name']);
        
        if (!file_exists('cookie')) {
            mkdir('cookie', 0777, true); // Create the directory if it doesn't exist
        }

        if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
            // Update customer with new photo
            $stmt = $connnection->prepare("UPDATE customers SET name=?, photo=?, email=?, phone=?, address=?, password=? WHERE id=?");
            $stmt->bind_param("ssssssi", $name, $photoPath, $email, $phone, $address, $password, $customer_id);
        } else {
            echo "Failed to upload new photo.";
            exit();
        }
    } else {
        // Update customer without changing the photo
        $stmt = $connnection->prepare("UPDATE customers SET name=?, email=?, phone=?, address=?, password=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $password, $customer_id);
    }

    // Execute the update statement
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connnection->close();
} else {
    echo "Invalid request method.";
}
?>
