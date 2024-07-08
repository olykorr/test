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


    function buildCategoryTree(array $categories, $parentId = 0) {
        $tree = [];

        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $categoryId = $category['categories_id'];
                $subcategories = buildCategoryTree($categories, $categoryId);

                // Додаємо підкатегорії, якщо вони є
                if (!empty($subcategories)) {
                    $tree[$categoryId] = $subcategories;
                } else {
                    // Якщо немає підкатегорій, то виводимо просто ключ
                    $tree[$categoryId] = $categoryId;
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
                // Выводим Array id [count], если есть подкатегории
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
