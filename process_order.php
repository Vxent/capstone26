<?php
// Start session
session_start();
include 'db_connection.php';

// Assuming you have the user ID stored in the session
$user_id = $_SESSION['user_id']; // Get the logged-in user ID
$product_id = $_POST['product_id']; // Get product ID from form submission
$facebook_account = $_POST['facebook_account']; // Get Facebook account from form submission
$status = "Pending"; // Set initial order status

// Insert order record
$stmt = $db->prepare("INSERT INTO orders (user_id, product_id, facebook_account, order_date, status) VALUES (?, ?, ?, NOW(), ?)");
$stmt->bind_param("iiss", $user_id, $product_id, $facebook_account, $status);

if ($stmt->execute()) {
    $order_success = true; // Flag for order success
} else {
    $order_success = false; // Flag for order failure
}

// Close connections
$stmt->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
        <?php if ($order_success): ?>
            <h1 class="text-2xl font-bold text-green-600">Order Successful!</h1>
            <p class="mt-2 text-gray-700">Your order has been recorded successfully.</p>
        <?php else: ?>
            <h1 class="text-2xl font-bold text-red-600">Order Failed</h1>
            <p class="mt-2 text-gray-700">There was an error recording your order. Please try again.</p>
        <?php endif; ?>
        <a href="apparelShop.php" class="mt-4 inline-block px-4 py-2 bg-yellow-600 text-black rounded hover:bg-yellow-500 transition">
            Back to Shop
        </a>
    </div>
</body>
</html>
