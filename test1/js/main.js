$(document).ready(function() {

    const urlParams = new URLSearchParams(window.location.search);
    const initialCategory = urlParams.get('category') || null;
    const initialSortOrder = urlParams.get('sort') || 'price_asc';


    $('#sort-order').val(initialSortOrder);


    loadCategories();
    loadProductCounts();
    loadProducts(initialCategory, initialSortOrder);

    function loadCategories() {
        $.ajax({
            url: 'index.php?page=categories',
            method: 'GET',
            success: function(data) {
                $('#category-container').html(data);
                if (initialCategory) {
                    $(`#category-container .list-group-item[data-id="${initialCategory}"]`).addClass('active');
                }
            }
        });
    }

    function loadProductCounts() {
        $.ajax({
            url: 'index.php?page=product_counts',
            method: 'GET',
            success: function(data) {
                var counts = JSON.parse(data);
                counts.forEach(function(count) {
                    $('#count-' + count.category_id).text(count.count);
                });
            }
        });
    }

    function loadProducts(categoryId = null, sortOrder = 'price_asc') {
        $.ajax({
            url: 'index.php?page=products',
            method: 'GET',
            data: {
                category_id: categoryId,
                sort_order: sortOrder
            },
            success: function(data) {
                $('#product-list').html(data);
                updateURL(categoryId, sortOrder);
            }
        });
    }

    function updateURL(categoryId, sortOrder) {
        const url = new URL(window.location.href);
        url.searchParams.set('category', categoryId || '');
        url.searchParams.set('sort', sortOrder);
        window.history.pushState({}, '', url);
    }

    $('#category-container').on('click', '.list-group-item', function() {
        var categoryId = $(this).data('id');
        $('#category-container .list-group-item').removeClass('active');
        $(this).addClass('active');
        var sortOrder = $('#sort-order').val();
        loadProducts(categoryId, sortOrder);
    });

    $('#sort-order').on('change', function() {
        var categoryId = $('#category-container .list-group-item.active').data('id') || null;
        var sortOrder = $(this).val();
        loadProducts(categoryId, sortOrder);
    });

    window.showProductModal = function(productId) {
        $.ajax({
            url: 'index.php?page=product',
            method: 'GET',
            data: { id: productId },
            success: function(data) {
                var product = JSON.parse(data);
                $('#productModal .modal-title').text(product.name);
                $('#productModal .modal-body').html(`
                    <p>Price: $${product.price}</p>
                    <p>Date: ${product.created_at}</p>
                `);
                $('#productModal').modal('show');
            }
        });
    };
});
