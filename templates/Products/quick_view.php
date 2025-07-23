<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="quick-view-grid">
    <div class="quick-view-image">
        <?php if (isset($product->image) && $product->image): ?>
            <?= $this->Html->image($product->image, ['alt' => h($product->name)]) ?>
        <?php else: ?>
            <?= $this->Html->image('sample.jpg', ['alt' => h($product->name), 'class' => 'blurred']) ?>
            <div class="no-image-overlay">No image available</div>
        <?php endif; ?>
    </div>
    <div class="quick-view-details">
        <h2><?= h($product->name) ?></h2>
        <div class="price">$<?= number_format($product->price, 2) ?></div>
        <div class="product-meta">
            <?php if ($product->vintage): ?>
                <div class="meta-item">
                    <span class="label">Vintage:</span>
                    <span class="value"><?= h($product->vintage) ?></span>
                </div>
            <?php endif; ?>
            <div class="meta-item">
                <span class="label">Alcohol Content:</span>
                <span class="value"><?= h($product->alcohol_content) ? h($product->alcohol_content) . '%' : 'N/A' ?></span>
            </div>
            <div class="meta-item">
                <span class="label">Region:</span>
                <span class="value"><?= h($product->region) ?></span>
            </div>
            <div class="meta-item">
                <span class="label">Style:</span>
                <span class="value"><?= h($product->style) ?></span>
            </div>
            <div class="meta-item">
                <span class="label">Stock:</span>
                <span class="value"><?= h($product->stock_quantity) ?> available</span>
            </div>
        </div>
        <?= $this->Form->create(null, [
            'url' => ['controller' => 'CartItems', 'action' => 'add'],
            'id' => 'quick-view-add-to-cart-form-' . $product->id,
            'class' => 'add-to-cart'
        ]) ?>
        <?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken')]) ?>
        <?= $this->Form->hidden('product_id', ['value' => $product->id]) ?>
        <div class="quantity-control">
            <label for="product_quantity-<?= $product->id ?>">Quantity:</label>
            <div class="quantity-input">
                <button type="button" class="quantity-btn" data-input-id="product_quantity-<?= $product->id ?>">-</button>
                <?= $this->Form->number('product_quantity', [
                    'id' => 'product_quantity-' . $product->id,
                    'min' => 1,
                    'max' => $product->stock_quantity,
                    'value' => 1,
                    'class' => 'quantity-field'
                ]) ?>
                <button type="button" class="quantity-btn" data-input-id="product_quantity-<?= $product->id ?>">+</button>
            </div>
        </div>
        <button type="submit" class="add-to-cart-btn" <?= $product->stock_quantity == 0 ? 'disabled' : '' ?>>
            <?= $product->stock_quantity == 0 ? 'Out of Stock' : 'Add to Cart' ?>
        </button>
        <?= $this->Form->end() ?>
    </div>
</div>

<style>
    .quick-view-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .quick-view-image {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quick-view-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .quick-view-details h2 {
        font-family: 'Lora', serif;
        font-size: 24px;
        margin-bottom: 15px;
        color: #333;
    }

    .price {
        font-size: 20px;
        font-weight: bold;
        color: #b12704;
        margin-bottom: 20px;
    }

    .product-meta {
        margin-bottom: 30px;
    }

    .meta-item {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .meta-item .label {
        font-weight: bold;
        width: 80px;
        color: #666;
    }

    .meta-item .value {
        color: #333;
    }

    .quantity-control {
        margin-bottom: 20px;
    }

    .quantity-control label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #666;
    }

    .quantity-input {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-btn {
        width: 30px;
        height: 30px;
        border: 1px solid #ddd;
        background: #f9f9f9;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .quantity-btn:hover {
        background: #fff;
        border-color: #b12704;
        color: #b12704;
    }

    .quantity-field {
        width: 60px;
        height: 30px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        -moz-appearance: textfield;
    }

    .quantity-field::-webkit-outer-spin-button,
    .quantity-field::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .add-to-cart-btn {
        width: 100%;
        padding: 12px 24px;
        background-color: #b12704;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .add-to-cart-btn:hover:not(:disabled) {
        background-color: #9a1f00;
    }

    .add-to-cart-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .quick-view-grid {
            grid-template-columns: 1fr;
        }
    }

    .quick-view-image img.blurred {
        filter: blur(5px);
        transform: scale(1.1);
        transition: filter 0.3s ease, transform 0.3s ease;
    }

    .quick-view-image:hover img.blurred {
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
