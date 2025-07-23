<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */
?>
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bolder">All Orders</h1>
    </div>

    <div class="table-responsive">
        <table id="OrdersTable" class="display responsive nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('order_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('total_amount') ?></th>
                    <th><?= $this->Paginator->sort('shipping_address') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions" style="color: var(--text-label-color); font-weight: 500"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $this->Number->format($order->order_id) ?></td>
                    <td><?= h($order->user->email) ?></td>
                    <td><?= $this->Number->currency($order->total_amount) ?></td>
                    <td><?= h($order->shipping_address) ?></td>
                    <td><?= h($order->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(
                            '<i class="bi bi-eye"></i>',
                            ['action' => 'adminView', $order->order_id],
                            ['class' => 'btn btn-view btn-large', 'title' => 'View', 'escape' => false]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
            order: [[4, 'desc']] // Sort by created date descending by default
        });
    });
</script> 