<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дерево категорій</title>
    <style>
        .nested {
            display: none;
            list-style-type: none;
            padding-left: 20px;
        }

        .toggle {
            cursor: pointer;
            padding-right: 5px;
        }

        .toggle:hover {
            color: blue;
        }
    </style>
</head>
<body>
<ul id="category-tree">

    <?php

    $host = 'localhost';
    $dbname = 'test2';
    $username = 'root';
    $password = '';

    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $pdo->query('SELECT categories_id, parent_id FROM categories');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $categoryTree = buildCategoryTree($categories);


        printTree($categoryTree);

    } catch (PDOException $e) {
        die("Error connection: " . $e->getMessage());
    }


    function buildCategoryTree(array $categories) {
        $tree = [];
        $stack = [];
    
        $categoryMap = [];

        foreach ($categories as $category) {
            $categoryMap[$category['parent_id']][] = $category;
        }
        
        $stack[] = ['parentId' => 0, 'tree' => &$tree];
    
        while (!empty($stack)) {
            $node = array_pop($stack);
            $parentId = $node['parentId'];
            $currentTree = &$node['tree'];
    
            if (isset($categoryMap[$parentId])) {
                foreach ($categoryMap[$parentId] as $category) {
                    $categoryId = $category['categories_id'];
                    if (isset($categoryMap[$categoryId])) {
                        $currentTree[$categoryId] = [];
                        $stack[] = ['parentId' => $categoryId, 'tree' => &$currentTree[$categoryId]];
                    } else {
                        $currentTree[$categoryId] = $categoryId;
                    }
                }
            }
        }
    
        return $tree;
    }


    function printTree($tree) {
        foreach ($tree as $categoryId => $subcategories) {
            echo '<li>';

            if (!is_array($subcategories)) {
                echo "$categoryId = $categoryId";
            } else {
                echo " $categoryId {array} = [". count($subcategories) ."]";
                echo '<span class="toggle">+</span>';
                echo '<ul class="nested">';
                printTree($subcategories);
                echo '</ul>';
            }

            echo '</li>';
        }
    }
    ?>
</ul>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category-tree').on('click', '.toggle', function() {
            var nestedList = $(this).siblings('ul.nested');
            if (nestedList.is(':visible')) {
                nestedList.hide();
                $(this).text('+');
            } else {
                nestedList.show();
                $(this).text('-');
            }
        });
    });
</script>
</body>
</html>
