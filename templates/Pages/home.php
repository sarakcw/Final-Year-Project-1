<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&family=Comfortaa:wght@300&display=swap" rel="stylesheet">

    <!-- Other meta tags, stylesheets, and scripts -->
    <link rel="stylesheet" href="styles.css">
    <?= $this->Html->css('landing.css') ?>
</head>

<header class="py-7">
    <div class="container px-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-6">
                <div class="text-center my-5">
                    <h1 class="display-5 text-white mb-2">FINE WINES, JUST A CLICK AWAY</h1>
                    <p class="lead text-white-50 mb-4">ELEVATE YOUR COLLECTION TODAY</p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a class="btn btn-lg px-4 me-sm-3" href="#features">Shop Now</a>
                        <a class="btn btn-lg px-4" href="#!">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Product Gallery Section -->
<section class="product-gallery">
    <div class="container">
        <h2 class="gallery-title">LATEST ARRIVALS</h2>
        <div class="view-all">
            <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'page']) ?>" class="btn">View All</a>
        </div>

        <div class="gallery-wrapper">
            <button class="arrow-nav left">←</button>
            <!-- Gallery Container -->
            <div class="gallery-container">
                <div class="gallery">
                    <!-- Product Items -->
                    <?php if (isset($products) && !empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <div class="image-container">
                                    <?php if ($product->image): ?>
                                        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $product->id]) ?>" class="product-image-link">
                                            <?= $this->Html->image($product->image, ['alt' => $product->name, 'class' => 'product-image']) ?>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $product->id]) ?>" class="product-image-link">
                                            <?= $this->Html->image('sample.jpg', ['alt' => $product->name, 'class' => 'product-image blurred']) ?>
                                            <div class="no-image-overlay">No image available</div>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($product->stock_quantity == 0): ?>
                                        <div class="out-of-stock-label">Out of Stock</div>
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name"><?= h($product->name) ?></h3>
                                    <div class="product-price">$<?= number_format($product->price, 2) ?></div>
                                    <div class="quick-view-container">
                                        <button class="quick-view-btn" onclick="openQuickView(<?= $product->id ?>)">Quick View</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick View Modal -->
                            <div id="quick-view-modal-<?= $product->id ?>" class="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="quick-view-modal-label-<?= $product->id ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="quick-view-modal-label-<?= $product->id ?>">
                                                <?= h($product->name) ?>
                                            </h5>
                                            <button type="button" class="close" onclick="closeQuickView(<?= $product->id ?>)" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?= $this->element('Products/quick_view', ['product' => $product]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No latest products available.</p>
                    <?php endif; ?>
                </div>
            </div>
            <button class="arrow-nav right">→</button>
        </div>
    </div>
</section>

<?= $this->Html->script('gallery-scroll.js') ?>

<style>
    .product-card {
        flex: 0 0 250px;
        width: 250px;
        text-align: center;
        position: relative;
        transition: all 0.2s ease;
        border: 2px solid transparent;
        overflow: visible;
    }

    .product-card .image-container {
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 10px;
        width: 100%;
        height: 300px;
        position: relative;
    }

    .product-card img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card:hover {
        border: 2px solid rgba(0, 0, 0, 0.05);
    }

    .out-of-stock-label {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 0, 0, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 12px;
    }

    .product-info {
        padding: 10px;
        background: white;
        text-align: center;
        position: relative;
    }

    .product-name {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        margin: 10px 0;
    }

    .product-price {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 16px;
    }

    .quick-view-container {
        position: absolute;
        top: -40px;
        left: 0;
        right: 0;
        opacity: 0;
        transition: opacity 0.2s ease;
        padding: 0 10px;
        z-index: 2;
    }

    .product-card:hover .quick-view-container {
        opacity: 1;
    }

    .quick-view-btn {
        width: 100%;
        padding: 10px 20px;
        background-color: #f9f9f9;
        color: #333;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .quick-view-btn:hover {
        background-color: #fff;
        border-color: #b12704;
        color: #b12704;
    }

    .no-image {
        width: 100%;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f9f9;
        border-radius: 4px;
        color: #666;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
    }

    .product-image-link {
        display: block;
        width: 100%;
        height: 100%;
        overflow: hidden;
        border-radius: 4px;
    }

    .product-image-link img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-image-link:hover img {
        transform: scale(1.05);
    }

    .quick-view-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog {
        margin: 1.75rem auto;
        max-width: 800px;
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        border-radius: 0.3rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .close {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        opacity: 0.5;
        background: none;
        border: 0;
        padding: 0;
        cursor: pointer;
    }

    .close:hover {
        .product-card:hover .product-image.blurred {
            filter: blur(5px);
            transform: scale(1.1);
        }

        .no-image-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            font-family: 'Comfortaa', sans-serif;
            font-weight: 300;
            font-size: 14px;
            z-index: 1;
        }
</style>

<script>
    function openQuickView(productId) {
        const modal = document.getElementById(`quick-view-modal-${productId}`);
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeQuickView(productId) {
        const modal = document.getElementById(`quick-view-modal-${productId}`);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('quick-view-modal')) {
            event.target.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }
</script>
</html>
