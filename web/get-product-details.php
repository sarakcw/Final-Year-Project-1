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

// Check if product ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

$productId = (int)$_GET['id'];

try {
    // Get database connection
    $db = getDBConnection();
    
    // Prepare and execute query
    $stmt = $db->prepare("
        SELECT 
            p.id,
            p.name,
            p.description,
            p.price,
            p.stock,
            p.sku,
            p.image_url,
            c.name as category
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = :id
    ");
    
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }
    
    // Return product data
    echo json_encode([
        'success' => true,
        'product' => $product
    ]);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred while fetching product details']);
} 