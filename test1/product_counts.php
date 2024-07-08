<?php
$pdo = new PDO('mysql:host=localhost;dbname=shop', 'root', '');
$counts = $pdo->query('SELECT category_id, COUNT(*) as count FROM products GROUP BY category_id')->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($counts);
