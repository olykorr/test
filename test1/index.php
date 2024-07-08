<?php

require 'db.php';
require 'controllers/CategoryController.php';
require 'controllers/ProductController.php';

$pdo = getPDO();

$categoryController = new CategoryController($pdo);
$productController = new ProductController($pdo);

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'categories':
        $categoryController->index();
        break;
    case 'products':
        $productController->index();
        break;
    case 'product':
        $productController->show();
        break;
    case 'product_counts':
        $categoryController->productCounts();
        break;
    default:
        require 'views/index.php';
        break;
}
?>
