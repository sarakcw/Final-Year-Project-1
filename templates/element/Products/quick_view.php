<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>

<!-- Quick View Modal Content -->
<div class="quick-view-content">
    <div class="product-image-section">
        <?php if (isset($product->image) && $product->image): ?>
            <?= $this->Html->image($product->image, ['alt' => h($product->name), 'class' => 'product-image']) ?>
        <?php else: ?>
            <?= $this->Html->image('sample.jpg', ['alt' => h($product->name), 'class' => 'product-image blurred']) ?>
            <div class="no-image-overlay">No image available</div>
        <?php endif; ?>
    </div>

    <div class="product-info-section">
        <h1 class="product-name"><?= h($product->name) ?></h1>
        <div class="product-price">$<?= number_format($product->price, 2) ?></div>

        <div class="product-meta">
            <div class="meta-item">
                <span class="meta-label">Vintage:</span>
                <span class="meta-value"><?= h($product->vintage) ?: 'N/A' ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Alcohol Content:</span>
                <span class="meta-value"><?= h($product->alcohol_content) ? h($product->alcohol_content) . '%' : 'N/A' ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Region:</span>
                <span class="meta-value"><?= h($product->region) ?: 'N/A' ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Style:</span>
                <span class="meta-value"><?= h($product->style) ?: 'N/A' ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Stock:</span>
                <span class="meta-value"><?= h($product->stock_quantity) ?> available</span>
            </div>
        </div>

        <div class="product-description">
            <?= h($product->description) ?>
        </div>

        <?php if ($product->stock_quantity > 0): ?>
            <div class="add-to-cart-form">
                <?= $this->Form->create(null, [
                    'url' => ['controller' => 'CartItems', 'action' => 'add'],
                    'id' => 'add-to-cart-form-' . $product->id
                ]) ?>
                <?= $this->Form->hidden('product_id', ['value' => $product->id]) ?>
                <?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken')]) ?>

                <div class="quantity-controls">
                    <button type="button" class="quantity-btn" onclick="decreaseQuantity(<?= $product->id ?>)">-</button>
                    <?= $this->Form->number('product_quantity', [
                        'value' => 1,
                        'min' => 1,
                        'max' => $product->stock_quantity,
                        'class' => 'quantity-input',
                        'id' => 'product_quantity-' . $product->id
                    ]) ?>
                    <button type="button" class="quantity-btn" onclick="increaseQuantity(<?= $product->id ?>)">+</button>
                </div>

                <?= $this->Form->button('Add to Cart', ['class' => 'add-to-cart-btn']) ?>
                <?= $this->Form->end() ?>
            </div>
        <?php else: ?>
            <div class="out-of-stock-message">Out of Stock</div>
        <?php endif; ?>
    </div>
</div>

<style>
    .quick-view-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .product-image-section {
        position: relative;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 4px;
    }

    .product-image.blurred {
        filter: blur(5px);
        transform: scale(1.1);
        transition: filter 0.3s ease, transform 0.3s ease;
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

    .product-info-section {
        padding: 20px;
    }

    .product-name {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 42px;
        color: #333;
        margin-bottom: 15px;
    }

    .product-price {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 38px;
        color: #2c3e50;
        margin-bottom: 30px;
    }

    .product-meta {
        margin-bottom: 30px;
    }

    .meta-item {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .meta-label {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        color: #666;
        width: 120px;
        font-size: 14px;
    }

    .meta-value {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        color: #333;
        font-size: 14px;
    }

    .product-description {
        margin-bottom: 30px;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        color: #666;
        line-height: 1.6;
    }

    .add-to-cart-form {
        margin-bottom: 20px;
    }

    .add-to-cart-btn {
        width: 100%;
        padding: 12px 20px;
        background-color: #f9f9f9;
        color: #333;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
    }

    .add-to-cart-btn:hover {
        background-color: #fff;
        border-color: #b12704;
        color: #b12704;
    }

    .out-of-stock-message {
        padding: 12px 20px;
        background-color: #f9f9f9;
        color: #666;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: center;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        width: 100%;
    }

    .quantity-btn {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 40px;
        height: 40px;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
    }

    .quantity-btn:hover {
        background-color: #fff;
        border-color: #b12704;
        color: #b12704;
    }

    .quantity-input {
        width: 60px;
        height: 40px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 0 10px;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 16px;
    }

    .quantity-input::-webkit-inner-spin-button,
    .quantity-input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    @media (max-width: 768px) {
        .quick-view-content {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function decreaseQuantity(productId) {
        const input = document.getElementById('product_quantity-' + productId);
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }

    function increaseQuantity(productId) {
        const input = document.getElementById('product_quantity-' + productId);
        const max = parseInt(input.getAttribute('max'));
        const currentValue = parseInt(input.value);
        if (currentValue < max) {
            input.value = currentValue + 1;
        }
    }
</script>
