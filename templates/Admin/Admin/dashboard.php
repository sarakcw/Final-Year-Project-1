<div class="admin-dashboard">
    <div class="dashboard-widgets">
        <div class="widget">
            <h3>Users</h3>
            <p>Total Users: <?= $totalUsers ?></p>
            <?= $this->Html->link('View Users', '/users', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="widget">
            <h3>Customer Enquiries</h3>
            <p>Total Enquiries: <?= $totalEnquiries ?></p>
            <?php if ($todayEnquiries > 0): ?>
                <p class="new-items">Today: <?= $todayEnquiries ?></p>
            <?php endif; ?>
            <?= $this->Html->link('View Enquiries', '/contact-enquiries', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="widget">
            <h3>Products</h3>
            <p>Total Products: <?= $totalProducts ?></p>
            <?= $this->Html->link('Manage Products', '/products', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="widget">
            <h3>Orders</h3>
            <p>Total Orders: <?= $totalOrders ?></p>
            <?php if ($todayOrders > 0): ?>
                <p class="new-items">Today: <?= $todayOrders ?></p>
            <?php endif; ?>
            <?= $this->Html->link('View Orders', '/orders/admin-index', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <div class="recent-activities">
        <div class="recent-section">
            <h3>Today's Orders</h3>
            <?php if (count($newOrders) > 0): ?>
                <div class="recent-list">
                    <?php foreach ($newOrders as $order): ?>
                        <div class="recent-item">
                            <div class="recent-item-info">
                                <span class="recent-item-title">Order #<?= $order->order_id ?></span>
                                <span class="recent-item-meta">by <?= h($order->user->email) ?></span>
                                <span class="recent-item-meta"><?= $this->Number->currency($order->total_amount) ?></span>
                                <span class="recent-item-time"><?= $order->created->nice() ?></span>
                            </div>
                            <?= $this->Html->link('View',
                                ['prefix' => false, 'controller' => 'Orders', 'action' => 'adminView', $order->order_id],
                                ['class' => 'btn btn-sm btn-outline-primary'])
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-items">No orders today</p>
            <?php endif; ?>
        </div>

        <div class="recent-section">
            <h3>Today's Enquiries</h3>
            <?php if (count($newEnquiries) > 0): ?>
                <div class="recent-list">
                    <?php foreach ($newEnquiries as $enquiry): ?>
                        <div class="recent-item">
                            <div class="recent-item-info">
                                <span class="recent-item-title"><?= h($enquiry->first_name) ?> <?= h($enquiry->last_name) ?></span>
                                <span class="recent-item-meta">from <?= h($enquiry->email) ?></span>
                                <span class="recent-item-message"><?= $this->Text->truncate(h($enquiry->message), 50, ['ellipsis' => '...']) ?></span>
                                <span class="recent-item-time"><?= $enquiry->date_sent->nice() ?></span>
                            </div>
                            <?= $this->Html->link('View',
                                ['prefix' => false, 'controller' => 'ContactEnquiries', 'action' => 'view', $enquiry->id],
                                ['class' => 'btn btn-sm btn-outline-primary'])
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-items">No enquiries today</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.recent-activities {
    margin-top: 2rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    padding: 1rem;
}

.recent-section {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.recent-section h3 {
    margin-bottom: 1rem;
    color: var(--primary-color);
    font-size: 1.2rem;
}

.recent-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.recent-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem;
    border: 1px solid #eee;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.recent-item:hover {
    background-color: #f8f9fa;
}

.recent-item-info {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.recent-item-title {
    font-weight: bold;
    color: var(--primary-color);
}

.recent-item-meta {
    font-size: 0.9rem;
    color: #666;
}

.recent-item-time {
    font-size: 0.8rem;
    color: #999;
}

.recent-item-message {
    font-size: 0.9rem;
    color: #666;
    display: block;
    margin-top: 0.3rem;
}

.no-items {
    color: #666;
    font-style: italic;
    text-align: center;
    padding: 1rem;
}

.new-items {
    color: #2c3e50;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
    background: transparent;
}

.btn-outline-primary:hover {
    color: white;
    background-color: var(--primary-color);
}
</style>
