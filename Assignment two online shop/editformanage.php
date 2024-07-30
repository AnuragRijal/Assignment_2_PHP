<?php
include 'includes/header.php';
include 'includes/db.php';

// Display all errors for debugging purposes (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if customer ID is provided via GET for fetching data
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Fetch customer data from the database
    $stmt = $connnection->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if (!$customer) {
        echo "Customer not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Handle form submission for updating data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $photo = $customer['photo']; // Default to the current photo path

    // Check if a new photo was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    // Update the customer data in the database
    $stmt = $connnection->prepare("UPDATE customers SET name=?, email=?, phone=?, address=?, photo=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $email, $phone, $address, $photo, $customer_id);
    
    if ($stmt->execute()) {
        header("Location: view_customers.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

if (isset($connnection)) {
    $connnection->close();
}
?>

<main>
    <h2>Edit Customer</h2>
    <form action="editformanage.php?id=<?php echo $customer['id']; ?>" method="post" enctype="multipart/form-data">
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
        <img src="<?php echo htmlspecialchars($customer['photo']); ?>" alt="Current Photo" width="100">

        <button type="submit">Update Information</button>
    </form>
</main>

<?php include 'includes/footer.php'; ?>

<style>
    /* Style for the form container */
    main {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    /* Form styling */
    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-top: 10px;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    textarea,
    input[type="file"] {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 100%;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    textarea:focus {
        border-color: #00aaff;
        outline: none;
    }

    button[type="submit"] {
        padding: 10px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #00aaff;
        transform: translateY(-2px);
    }

    img {
        margin-top: 10px;
        border-radius: 5px;
    }
</style>
