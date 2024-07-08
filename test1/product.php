<?php
$pdo = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
$productId = isset($_GET['id']) ? (int)$_GET['id'] : null;

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$stmt->execute(['id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($product);
