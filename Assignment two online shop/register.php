<?php
// Display all errors for debugging purposes (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include 'includes/header.php';
include 'includes/db.php';

// Check if $connnection is defined and check for connection errors
if (!isset($connnection)) {
    die("Database connection variable is not set.");
}

if ($connnection->connect_error) {
    die("Database connection error: " . $connnection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Handle file upload
    $photo = $_FILES['photo'];
    $photoPath = 'cookie/' . basename($photo['name']);

    if (!file_exists('cookie')) {
        mkdir('cookie', 0777, true); // Create the directory if it doesn't exist
    }

    if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
        $stmt = $connnection->prepare("INSERT INTO customers (name, photo, email, phone, address, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $photoPath, $email, $phone, $address, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Failed to upload photo.";
    }

    $connnection->close();
}
?>

<main>
    <h2>Register</h2>
    <form action="register.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone">
        
        <label for="address">Address:</label>
        <textarea id="address" name="address"></textarea>
        
        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Register</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
