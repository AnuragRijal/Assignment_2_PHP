<?php
include 'includes/header.php';
?>

<main>
    <h1>Welcome to Our Online Shop</h1>
    <p>Discover a wide range of products at unbeatable prices. Whether you're looking for electronics, fashion, home goods, or more, we've got something for everyone.</p>
    <div class="actions">
        <a href="register.php" class="button">Register</a>
        <a href="login.php" class="button">Login</a>
        <a href="view_customers.php" class="button">View All Customers</a> 
    </div>
</main>

<?php
include 'includes/footer.php';
?>

<style>
    .actions {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .actions .button,
    .button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #333;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin: 0 10px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .actions .button:hover,
    .button:hover {
        background-color: #00aaff;
        transform: translateY(-2px);
        color: #fff;
    }

    /* General page styling */
    main {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
    }

    h1 {
        color: #333;
    }

    p {
        font-size: 1.2em;
        color: #555;
    }
</style>
