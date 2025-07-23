<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */
?>
<div class="orders index content">
    <!-- Header Section -->
    <div class="header-image">
        <img src="https://images.unsplash.com/photo-1519671282429-b44660ead0a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1380&h=200&q=80" alt="Orders Header">
    </div>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bolder">My Orders</h1>
            <p class="text-muted">View and manage your order history</p>
        </div>

        <!-- Order Summary Cards -->
        <div class="order-summary-cards mb-5">
            <div class="summary-card">
                <i class="bi bi-box-seam"></i>
                <h3>Total Orders</h3>
                <p><?= count($orders) ?></p>
            </div>
            <div class="summary-card">
                <i class="bi bi-currency-dollar"></i>
                <h3>Total Spent</h3>
                <p><?= $this->Number->currency(array_sum(array_map(function($order) { return $order->total_amount; }, $orders->toList()))) ?></p>
            </div>
            <div class="summary-card">
                <i class="bi bi-clock-history"></i>
                <h3>Recent Order</h3>
                <p><?= $orders->isEmpty() ? 'No orders yet' : h($orders->first()->created->format('Y-m-d')) ?></p>
            </div>
        </div>

        <div class="table-responsive">
            <table id="OrdersTable" class="display responsive nowrap">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('order_id') ?></th>
                        <th><?= $this->Paginator->sort('total_amount') ?></th>
                        <th><?= $this->Paginator->sort('shipping_address') ?></th>
                        <th><?= $this->Paginator->sort('created') ?></th>
                        <th class="actions" style="color: var(--text-label-color); font-weight: 500"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>
                            <span class="order-id">#<?= $this->Number->format($order->order_id) ?></span>
                        </td>
                        <td>
                            <span class="order-amount"><?= $this->Number->currency($order->total_amount) ?></span>
                        </td>
                        <td>
                            <span class="order-address"><?= h($order->shipping_address) ?></span>
                        </td>
                        <td>
                            <span class="order-date"><?= h($order->created->format('Y-m-d H:i')) ?></span>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(
                                '<i class="bi bi-eye"></i> View Details',
                                ['action' => 'view', $order->order_id],
                                ['class' => 'btn btn-view btn-large', 'title' => 'View', 'escape' => false]
                            ) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#OrdersTable').DataTable({
            responsive: true,
            order: [[3, 'desc']], // Sort by created date descending by default
            language: {
                search: "Search orders:",
                lengthMenu: "Show _MENU_ orders per page",
                info: "Showing _START_ to _END_ of _TOTAL_ orders",
                emptyTable: "No orders found"
            }
        });
    });
</script>

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
       Table Enhancements
       ========================================================================== */
    .table-responsive {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
    }

    #OrdersTable {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    #OrdersTable thead th {
        background-color: #f8f9fa;
        color: var(--product-text-color);
        font-weight: 600;
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #dee2e6;
    }

    #OrdersTable tbody tr {
        transition: background-color 0.2s ease;
    }

    #OrdersTable tbody tr:hover {
        background-color: #f8f9fa;
    }

    #OrdersTable tbody td {
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .order-id {
        font-weight: bold;
        color: var(--primary-products-color);
    }

    .order-amount {
        font-weight: bold;
        color: var(--secondary-products-color);
    }

    .order-address {
        color: var(--product-text-color);
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .order-date {
        color: #666;
        font-size: 0.9rem;
    }

    .btn-view {
        background-color: var(--secondary-products-color);
        color: white !important;
        padding: 8px 15px;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-view:hover {
        background-color: var(--primary-products-color);
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* ==========================================================================
       DataTables Customization
       ========================================================================== */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 20px;
    }

    .dataTables_wrapper .dataTables_length select {
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }

    .dataTables_wrapper .dataTables_filter input {
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        margin-left: 10px;
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

        .table-responsive {
            padding: 10px;
        }

        #OrdersTable thead th,
        #OrdersTable tbody td {
            padding: 10px;
        }

        .btn-view {
            padding: 6px 12px;
            font-size: 0.9rem;
        }
    }
</style>
