<?php

class Product
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getByCategory($categoryId = null, $sortOrder = 'price_asc')
    {
        $sql = 'SELECT id, name, price, created_at FROM products';
        if ($categoryId) {
            $sql .= ' WHERE category_id = :category_id';
        }
        switch ($sortOrder) {
            case 'price_asc':
                $sql .= ' ORDER BY price ASC';
                break;
            case 'price_desc':
                $sql .= ' ORDER BY price DESC';
                break;
            case 'name_asc':
                $sql .= ' ORDER BY name ASC';
                break;
            case 'name_desc':
                $sql .= ' ORDER BY name DESC';
                break;
            case 'date_newest':
                $sql .= ' ORDER BY created_at DESC';
                break;
            case 'date_oldest':
                $sql .= ' ORDER BY created_at ASC';
                break;
        }
        $stmt = $this->pdo->prepare($sql);
        if ($categoryId) {
            $stmt->execute(['category_id' => $categoryId]);
        } else {
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategoryAndSortOrder($categoryId, $sortOrder)
    {
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getOrderBy($sortOrder)
    {
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

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}




