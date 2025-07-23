<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CartItem> $cartItems
 * @var float $totalAmount
 */
?>
<div class="orders checkout content">
    <!-- Header Section -->
    <div class="header-image">
        <img src="https://images.unsplash.com/photo-1519671282429-b44660ead0a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1380&h=200&q=80" alt="Checkout Header">
    </div>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bolder">Checkout</h1>
            <p class="text-muted">Complete your purchase</p>
        </div>

        <!-- Cart Summary Cards -->
        <div class="cart-summary-cards mb-5">
            <div class="summary-card">
                <i class="bi bi-cart"></i>
                <h3>Total Items</h3>
                <p><?= count($cartItems) ?></p>
            </div>
            <div class="summary-card">
                <i class="bi bi-currency-dollar"></i>
                <h3>Total Amount</h3>
                <p><?= $this->Number->currency($totalAmount) ?></p>
            </div>
        </div>

        <!-- Cart Items Table -->
        <div class="cart-items-section mb-5">
            <h3 class="mb-4">Order Summary</h3>
            <div class="table-responsive">
                <table class="cart-items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td>
                                <span class="product-name"><?= h($item->product->name) ?></span>
                            </td>
                            <td>
                                <span class="product-price"><?= $this->Number->currency($item->product->price) ?></span>
                            </td>
                            <td>
                                <span class="product-quantity"><?= $this->Number->format($item->product_quantity) ?></span>
                            </td>
                            <td>
                                <span class="product-subtotal"><?= $this->Number->currency($item->product->price * $item->product_quantity) ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                            <td><strong class="total-amount"><?= $this->Number->currency($totalAmount) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Shipping Information Form -->
        <div class="shipping-form-section">
            <h3 class="mb-4">Shipping Information</h3>
            <?= $this->Form->create(null, ['class' => 'shipping-form']) ?>
            <div class="form-group mb-4">
                <?= $this->Form->control('shipping_address', [
                    'label' => 'Shipping Address',
                    'class' => 'form-control',
                    'required' => true,
                    'type' => 'textarea',
                    'rows' => 3,
                    'placeholder' => 'Enter your shipping address',
                    'value' => $userAddress ?? ''
                ]) ?>
            </div>
            <div class="text-center">
                <?= $this->Form->button(
                    'Place Order',
                    ['class' => 'btn btn-primary btn-lg']
                ) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?= $this->Html->css('admin-table.css') ?>

<style>
    /* ==========================================================================
       Header Image
       ========================================================================== */
    .header-image {
        width: 100%;
        max-width: 1380px;
        margin: 0 auto 20px auto;
    }

    .header-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* ==========================================================================
       Cart Summary Cards
       ========================================================================== */
    .cart-summary-cards {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        flex: 1;
        max-width: 300px;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-5px);
    }

    .summary-card i {
        font-size: 2rem;
        color: var(--secondary-products-color);
        margin-bottom: 10px;
    }

    .summary-card h3 {
        font-size: 1rem;
        color: var(--product-text-color);
        margin-bottom: 5px;
    }

    .summary-card p {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--primary-products-color);
        margin: 0;
    }

    /* ==========================================================================
       Cart Items Table
       ========================================================================== */
    .cart-items-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .cart-items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-items-table th {
        background-color: #f8f9fa;
        padding: 12px;
        text-align: left;
        font-weight: 500;
        color: var(--text-label-color);
    }

    .cart-items-table td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
    }

    .product-name {
        font-weight: 500;
        color: var(--primary-products-color);
    }

    .product-quantity {
        color: var(--product-text-color);
    }

    .product-price {
        color: var(--secondary-products-color);
    }

    .product-subtotal {
        font-weight: bold;
        color: var(--primary-products-color);
    }

    .total-amount {
        color: var(--primary-products-color);
        font-size: 1.2rem;
    }

    /* ==========================================================================
       Shipping Form
       ========================================================================== */
    .shipping-form-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .shipping-form {
        max-width: 600px;
        margin: 0 auto;
    }

    .form-control {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 10px;
        width: 100%;
    }

    .form-control:focus {
        border-color: var(--secondary-products-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--secondary-products-color-rgb), 0.25);
    }

    .btn-primary {
        background-color: var(--secondary-products-color);
        border: none;
        padding: 12px 24px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--primary-products-color);
        transform: translateY(-2px);
    }

    /* ==========================================================================
       Responsive Design
       ========================================================================== */
    @media (max-width: 768px) {
        .cart-summary-cards {
            flex-direction: column;
            align-items: center;
        }

        .summary-card {
            width: 100%;
            max-width: none;
            margin-bottom: 15px;
        }

        .cart-items-table {
            display: block;
            overflow-x: auto;
        }

        .shipping-form {
            padding: 0 15px;
        }
    }
</style> 