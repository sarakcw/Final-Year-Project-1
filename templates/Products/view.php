<?= $this->Html->css('styles', ['block' => true]) ?>

<div class="product-details-container">
    <div class="product-details-grid">
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

            <?php if ($product->stock_quantity > 0): ?>
                <div class="add-to-cart-form">
                    <?= $this->Form->create(null, ['url' => ['controller' => 'CartItems', 'action' => 'add'], 'class' => 'add-to-cart']) ?>
                    <?= $this->Form->hidden('product_id', ['value' => $product->id]) ?>

                    <div class="quantity-controls">
                        <button type="button" class="quantity-btn" data-input-id="product_quantity_<?= $product->id ?>">-</button>
                        <?= $this->Form->number('product_quantity', [
                            'value' => 1,
                            'min' => 1,
                            'max' => $product->stock_quantity,
                            'class' => 'quantity-input',
                            'id' => 'product_quantity_' . $product->id
                        ]) ?>
                        <button type="button" class="quantity-btn" data-input-id="product_quantity_<?= $product->id ?>">+</button>
                    </div>

                    <?= $this->Form->button('Add to Cart', ['class' => 'add-to-cart-btn']) ?>
                    <?= $this->Form->end() ?>
                </div>
            <?php else: ?>
                <div class="out-of-stock-message">Out of Stock</div>
            <?php endif; ?>

            <?php if ($this->Identity->isLoggedIn() && $this->Identity->get('user_type') === 'Admin'): ?>
                <div class="admin-actions">
                    <?= $this->Form->create(null, ['url' => ['controller' => 'Products', 'action' => 'addStock', $product->id]]) ?>
                    <div class="add-stock-form">
                        <?= $this->Form->number('quantity', [
                            'min' => 1,
                            'class' => 'stock-quantity-input',
                            'placeholder' => 'Enter quantity'
                        ]) ?>
                        <?= $this->Form->button('Add Stock', ['class' => 'add-stock-btn']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .product-details-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .product-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
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

    .product-image-section:hover .product-image.blurred {
        filter: blur(5px);
        transform: scale(1.1);
    }

    .no-image {
        width: 100%;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f9f9;
        border-radius: 4px;
        color: #666;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
    }

    .product-info-section {
        padding: 20px;
    }

    .product-name {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 32px;
        color: #333;
        margin-bottom: 10px;
    }

    .product-price {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 28px;
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
        font-size: 16px;
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

    .admin-actions {
        margin-top: 20px;
    }

    .add-stock-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .stock-quantity-input {
        flex: 1;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
    }

    .add-stock-btn {
        padding: 8px 16px;
        background-color: #f9f9f9;
        color: #333;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
    }

    .add-stock-btn:hover {
        background-color: #fff;
        border-color: #b12704;
        color: #b12704;
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
        .product-details-grid {
            grid-template-columns: 1fr;
        }

        .product-details-container {
            margin: 20px auto;
        }
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
