<?php
/**
 * Product card element
 *
 * @var \App\Model\Entity\Product $product
 */
?>

<div class="product-card">
    <div class="product-image">
        <?php if ($product->image): ?>
            <?= $this->Html->image($product->image, ['alt' => h($product->name), 'class' => 'img-fluid']) ?>
        <?php else: ?>
            <div class="no-image-placeholder">
                <i class="fas fa-image"></i>
                <p>No image available</p>
            </div>
        <?php endif; ?>

        <div class="product-actions">
            <button type="button" class="btn btn-sm btn-outline-light quick-view-btn" data-quick-view="<?= $product->id ?>">
                <i class="fas fa-eye"></i> Quick View
            </button>
            <?= $this->Html->link(
                '<i class="fas fa-info-circle"></i> Details',
                ['controller' => 'Products', 'action' => 'view', $product->id],
                ['class' => 'btn btn-sm btn-outline-light', 'escape' => false]
            ) ?>
        </div>
    </div>

    <div class="product-info">
        <h3 class="product-name"><?= h($product->name) ?></h3>
        <p class="product-price"><?= $this->Number->currency($product->price) ?></p>

        <div class="product-meta">
            <?php if ($product->vintage): ?>
                <span class="meta-item"><i class="fas fa-calendar"></i> <?= h($product->vintage) ?></span>
            <?php endif; ?>

            <?php if ($product->region): ?>
                <span class="meta-item"><i class="fas fa-map-marker-alt"></i> <?= h($product->region) ?></span>
            <?php endif; ?>
        </div>

        <?php if ($product->stock_quantity <= 0): ?>
            <div class="out-of-stock-badge">Out of Stock</div>
        <?php endif; ?>
    </div>
</div>

<?= $this->element('Products/quick_view', ['product' => $product]) ?>

<style>
    .product-card {
        position: relative;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        position: relative;
        padding-top: 75%; /* 4:3 aspect ratio */
        overflow: hidden;
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .no-image-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        color: #6c757d;
    }

    .no-image-placeholder i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .product-actions {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        display: flex;
        justify-content: space-between;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .product-card:hover .product-actions {
        opacity: 1;
    }

    .product-info {
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 0.75rem;
    }

    .product-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: auto;
    }

    .meta-item {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .meta-item i {
        font-size: 0.8rem;
    }

    .out-of-stock-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background-color: rgba(220, 53, 69, 0.9);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .product-actions {
            opacity: 1;
        }
    }
</style>
