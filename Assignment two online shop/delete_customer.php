<?php
// Display all errors for debugging purposes (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include 'includes/db.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if customer_id is set
    if (isset($_POST['customer_id'])) {
        $customer_id = $_POST['customer_id'];

        // Prepare and execute the deletion statement
        $stmt = $connnection->prepare("DELETE FROM customers WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $customer_id);
            if ($stmt->execute()) {
                // Redirect to homepage or a confirmation page
                header("Location: index.php");
                exit();
            } else {
                echo "Error executing delete statement: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing delete statement: " . $connnection->error;
        }
    } else {
        echo "No customer ID provided.";
    }
} else {
    echo "Invalid request method.";
}

if (isset($connnection)) {
    $connnection->close();
}
?>
