<ul class="list-group" id="category-list">
    <?php foreach ($categories as $category): ?>
        <a href="#" class="list-group-item list-group-item-action" data-id="<?= $category['id'] ?>">
            <?= $category['name'] ?> <span class="badge badge-primary badge-pill" id="count-<?= $category['id'] ?>"></span>
        </a>
    <?php endforeach; ?>


</ul>
