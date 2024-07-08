<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h2>Categories</h2>
            <div id="category-container">

            </div>
        </div>
        <div class="col-md-9">
            <h2>Products</h2>
            <div>
                <select id="sort-order" class="form-control">
                    <option value="price_asc">Sort by Price (Low to High)</option>
                    <option value="price_desc">Sort by Price (High to Low)</option>
                    <option value="name_asc">Sort by Name (A-Z)</option>
                    <option value="name_desc">Sort by Name (Z-A)</option>
                    <option value="date_newest">Sort by Date (Newest)</option>
                    <option value="date_oldest">Sort by Date (Oldest)</option>
                </select>
            </div>
            <ul class="list-group" id="product-list">

            </ul>
        </div>
    </div>
</div>


<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<link rel="stylesheet" href="css/styles.css">
</body>
</html>
