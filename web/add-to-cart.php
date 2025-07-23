<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

// Check if the request is AJAX
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Direct access not allowed']);
    exit;
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Check if product ID and quantity are provided
if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id']) || 
    !isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid product ID or quantity']);
    exit;
}

$productId = (int)$_POST['product_id'];
$quantity = (int)$_POST['quantity'];

// Validate quantity
if ($quantity <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Quantity must be greater than 0']);
    exit;
}

try {
    // Get database connection
    $db = getDBConnection();
    
    // Check if product exists and has enough stock
    $stmt = $db->prepare("SELECT id, name, price, stock FROM products WHERE id = :id");
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }
    
    if ($product['stock'] < $quantity) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Not enough stock available']);
        exit;
    }
    
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Add or update cart item
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = [
            'id' => $productId,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity
        ];
    }
    
    // Calculate total items in cart
    $totalItems = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalItems += $item['quantity'];
    }
    
    // Return success response with updated cart count
    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart successfully',
        'cartCount' => $totalItems
    ]);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred while adding to cart']);
} 