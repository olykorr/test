<?php
$pdo = new PDO('mysql:host=localhost;dbname=shop', 'root', '');

$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'price_asc';

$orderBy = 'price ASC';
if ($sortOrder == 'price_desc') {
    $orderBy = 'price DESC';
} elseif ($sortOrder == 'name_asc') {
    $orderBy = 'name ASC';
} elseif ($sortOrder == 'name_desc') {
    $orderBy = 'name DESC';
} elseif ($sortOrder == 'date_newest') {
    $orderBy = 'created_at DESC';
} elseif ($sortOrder == 'date_oldest') {
    $orderBy = 'created_at ASC';
}

$query = 'SELECT * FROM products';
if ($categoryId) {
    $query .= ' WHERE category_id = :category_id';
}
$query .= ' ORDER BY ' . $orderBy;

$stmt = $pdo->prepare($query);
if ($categoryId) {
    $stmt->execute(['category_id' => $categoryId]);
} else {
    $stmt->execute();
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($products);
