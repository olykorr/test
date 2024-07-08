<ul class="list-group" id="product-list">
    <?php foreach ($products as $product): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= $product['name'] ?></h5>
                <p class="card-text">Price: $<?= $product['price'] ?></p>
                <p class="card-text">Date: <?= $product['created_at'] ?></p>
                <button class="btn btn-primary" onclick="showProductModal(<?= $product['id'] ?>)">Buy</button>
            </div>
        </div>
    <?php endforeach; ?>

</ul>
