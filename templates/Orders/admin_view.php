<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<div class="orders admin-view content">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bolder">Order Details</h1>
            <p class="text-muted">Order #<?= h($order->order_id) ?></p>
        </div>

        <!-- Order Summary Cards -->
        <div class="order-summary-cards mb-5">
            <div class="summary-card">
                <i class="bi bi-currency-dollar"></i>
                <h3>Total Amount</h3>
                <p><?= $this->Number->currency($order->total_amount) ?></p>
            </div>
            <div class="summary-card">
                <i class="bi bi-person"></i>
                <h3>Customer</h3>
                <p><?= h($order->user->email) ?></p>
            </div>
            <div class="summary-card">
                <i class="bi bi-geo-alt"></i>
                <h3>Shipping Address</h3>
                <p><?= h($order->shipping_address) ?></p>
            </div>
            <div class="summary-card">
                <i class="bi bi-calendar"></i>
                <h3>Order Date</h3>
                <p><?= h($order->created->format('Y-m-d H:i')) ?></p>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="order-items-section">
            <h3 class="mb-4">Order Items</h3>
            <div class="table-responsive">
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order->order_products as $orderProduct): ?>
                        <tr>
                            <td>
                                <span class="product-name"><?= h($orderProduct->product->name) ?></span>
                            </td>
                            <td>
                                <span class="product-quantity"><?= h($orderProduct->quantity) ?></span>
                            </td>
                            <td>
                                <span class="product-price"><?= $this->Number->currency($orderProduct->price) ?></span>
                            </td>
                            <td>
                                <span class="product-subtotal"><?= $this->Number->currency($orderProduct->price * $orderProduct->quantity) ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-5">
            <?= $this->Html->link(
                '<i class="bi bi-arrow-left"></i> Back to Orders',
                ['action' => 'adminIndex'],
                ['class' => 'btn btn-back', 'escape' => false]
            ) ?>
        </div>
    </div>
</div>

<?= $this->Html->css('admin-table.css') ?>

<style>
    /* ==========================================================================
       Order Summary Cards
       ========================================================================== */
    .order-summary-cards {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        flex: 1;
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
       Order Items Table
       ========================================================================== */
    .order-items-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .order-items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-items-table th {
        background-color: #f8f9fa;
        padding: 12px;
        text-align: left;
        font-weight: 500;
        color: var(--text-label-color);
    }

    .order-items-table td {
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

    /* ==========================================================================
       Back Button
       ========================================================================== */
    .btn-back {
        background-color: var(--secondary-products-color);
        color: white !important;
        padding: 10px 20px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background-color: var(--primary-products-color);
        transform: translateY(-2px);
    }

    /* ==========================================================================
       Responsive Design
       ========================================================================== */
    @media (max-width: 768px) {
        .order-summary-cards {
            flex-direction: column;
        }

        .summary-card {
            margin-bottom: 15px;
        }

        .order-items-table {
            display: block;
            overflow-x: auto;
        }
    }
</style> 