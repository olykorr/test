<?php

class Category
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM categories');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductCounts()
    {
        $stmt = $this->pdo->query('
            SELECT category_id, COUNT(*) as count 
            FROM products 
            GROUP BY category_id
        ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



