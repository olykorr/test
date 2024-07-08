<?php

class ProductController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $categoryId = $_GET['category_id'] ?? null;
        $sortOrder = $_GET['sort_order'] ?? 'price_asc';

        $orderBy = $this->getOrderBy($sortOrder);
        $sql = 'SELECT * FROM products';
        if ($categoryId) {
            $sql .= ' WHERE category_id = :categoryId';
        }
        $sql .= " ORDER BY $orderBy";

        $stmt = $this->pdo->prepare($sql);
        if ($categoryId) {
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        }
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/products.php';
    }

    public function show() {
        $productId = $_GET['id'] ?? null;
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :productId');
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($product);
    }

    private function getOrderBy($sortOrder) {
        switch ($sortOrder) {
            case 'price_asc':
                return 'price ASC';
            case 'price_desc':
                return 'price DESC';
            case 'name_asc':
                return 'name ASC';
            case 'name_desc':
                return 'name DESC';
            case 'date_newest':
                return 'created_at DESC';
            case 'date_oldest':
                return 'created_at ASC';
            default:
                return 'price ASC';
        }
    }
}
?>
