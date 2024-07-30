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
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $connnection->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
    
    if ($customer && password_verify($password, $customer['password'])) {
        // Start the session and set a session variable
        session_start();
        $_SESSION['customer_id'] = $customer['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid credentials.";
    }
}
?>

<main>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
