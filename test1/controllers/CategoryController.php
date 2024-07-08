<?php

class CategoryController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $stmt = $this->pdo->query('SELECT * FROM categories');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require 'views/categories.php';
    }

    public function productCounts() {
        $stmt = $this->pdo->query('SELECT category_id, COUNT(*) as count FROM products GROUP BY category_id');
        $counts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($counts);
    }
}
?>
