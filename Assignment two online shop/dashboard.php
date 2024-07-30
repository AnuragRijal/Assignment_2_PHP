<?php
// Display all errors for debugging purposes (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include 'includes/header.php';
include 'includes/db.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Fetch customer data from the database
$stmt = $connnection->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
    echo "Error fetching customer data.";
    exit();
}
?>

<main>
    <h1>Welcome, <?php echo htmlspecialchars($customer['name']); ?></h1>
    <p>Your email: <?php echo htmlspecialchars($customer['email']); ?></p>
    <p>Your phone: <?php echo htmlspecialchars($customer['phone']); ?></p>
    <p>Your address: <?php echo htmlspecialchars($customer['address']); ?></p>

    <form action="update_customer.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
        
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>">
        
        <label for="address">Address:</label>
        <textarea id="address" name="address"><?php echo htmlspecialchars($customer['address']); ?></textarea>
        
        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo">
        
        <button type="submit">Update Information</button>
    </form>
    
    <form action="delete_customer.php" method="post">
        <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
        <button type="submit">Delete Account</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
