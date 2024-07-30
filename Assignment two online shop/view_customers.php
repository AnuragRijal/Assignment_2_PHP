<?php
include 'includes/header.php';
include 'includes/db.php';

// Fetch all customers from the database
$result = $connnection->query("SELECT * FROM customers");

if (!$result) {
    die("Database query failed: " . $connnection->error);
}
?>

<main>
    <h2>All Customers</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td><img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Photo" width="50"></td>
                <td>
                    <a href="editformanage.php?id=<?php echo $row['id']; ?>" class="button">Edit</a>
                    <form action="deleteformanage.php" method="post" style="display:inline;">
                        <input type="hidden" name="customer_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="button" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include 'includes/footer.php'; ?>

<?php
$result->free();
$connnection->close();
?>

<style>
    /* Style for actions buttons */
    .actions {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .actions .button, .button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #333;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin: 0 10px;
        transition: background-color 0.3s, transform 0.3s;
    }
    .actions .button:hover, .button:hover {
        background-color: #00aaff;
        transform: translateY(-2px);
        color: #fff;
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #333;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #ddd;
    }
</style>
