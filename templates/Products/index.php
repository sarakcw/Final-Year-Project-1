<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>


<div class="products index content">
    <h3 class="admin-headings">Current Top Products</h3>
    <div class="top-product-row">
        <div class="top-product-item">
            <?= $this->Html->image('sample2.jpeg', ['alt' => 'sample image', 'class' => 'top-product-img']) ?>
            <div class="top-product-info">
                <i class="bi bi-droplet me-3 fs-4"></i><span><strong>Champagne Drappier 1er Cru Brut NV</strong></span>
                <?= $this->Html->tag('hr','',['style' => 'width: 300px; border: 1px solid #ccc;']) ?>
                <i class="bi bi-basket me-3 fs-4"></i><span>1324 sold</span>
                <?= $this->Html->tag('hr','',['style' => 'width: 300px; border: 1px solid #ccc;']) ?>
                <i class="bi bi-box2 me-3 fs-4"></i><span>45 bottles in stock</span>
            </div>
        </div>
        <div class="top-product-item">
            <?= $this->Html->image('sample2.jpeg', ['alt' => 'sample image', 'class' => 'top-product-img']) ?>
            <div class="top-product-info">
                <i class="bi bi-droplet me-3 fs-4"></i><span><strong>[name of wine]</strong></span>
                <?= $this->Html->tag('hr','',['style' => 'width: 300px; border: 1px solid #ccc;']) ?>
                <i class="bi bi-basket me-3 fs-4"></i><span>[no. sold]</span>
                <?= $this->Html->tag('hr','',['style' => 'width: 300px; border: 1px solid #ccc;']) ?>
                <i class="bi bi-box2 me-3 fs-4"></i><span>[current stock]</span>
            </div>
        </div>
    </div>
    <?= $this->Html->tag('hr','',['style' => 'width: 80%; border: 1px solid #ccc; margin: 0 auto;']) ?>
    <h3 class="admin-headings pt-3">Products List</h3>
    <!--    render the feedback message for any successful crud functions-->
    <div class="alert alert-dismissible fade show" role="alert">
        <?= $this->Flash->render('productFeedback');?>
    </div>
    <div class="dropdown-filter">
        <div class="filter-row">
            <div class="list-add-new">
                <?= $this->Html->link(
                    '<i class="bi bi-plus-lg"></i>Add New Product',
                    ['action' => 'add'],
                    ['class'=> "add-button", 'escape' => false],
                ) ?>
            </div>
            <p class="fw-bold filter-col">Filters:</p>
            <div class="filter-col">
                <p class="filter-label">Stock Quantity:</p>
                <?= $this->Form->control('stock_quantity', [
                    'id' => 'stock-filter',
                    'type' => 'select',
                    'label' => false,
                    'options' => ['' => 'All', '1' => 'Low Stock', '2' => 'Out of Stock'],
                    'class' => 'stock-filter-dropdown',
                    'value' => isset($stockFilter) ? $stockFilter : ''
                ]) ?>
            </div>
            <div class="filter-col">
                <p class="filter-label">Status:</p>
                <?= $this->Form->control('status', [
                    'id' => 'status-filter',
                    'type' => 'select',
                    'label' => false,
                    'options' => ['' => 'All', '1' => 'Listed', '2' => 'Unlisted'],
                    'class' => 'status-filter-dropdown',
                    'value' => isset($statusFilter) ? $statusFilter : ''
                ]) ?>
            </div>
            <div class="filter-col">
                <p class="filter-label">Style:</p>
                <?= $this->Form->control('style', [
                    'id' => 'style-filter',
                    'type' => 'select',
                    'label' => false,
                    'options' => ['' => 'All',
                        'Red'=> 'Red',
                        'White' => 'White',
                        'Rose' => 'Rose',
                        'Sparkling' => 'Sparkling',
                        'Fortified' => 'Fortified',
                        'Dessert' => 'Dessert'],
                    'class' => 'style-filter-dropdown',
                    'value' => isset($styleFilter) ? $styleFilter : ''
                ]) ?>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="ProductsTable" class="display responsive nowrap">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('stock_quantity') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('vintage') ?></th>
                    <th><?= $this->Paginator->sort('alcohol_content') ?></th>
                    <th><?= $this->Paginator->sort('region') ?></th>
                    <th><?= $this->Paginator->sort('style') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions" style="color: var(--text-label-color); font-weight: 500"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr class="products-row" data-stock="<?= h($product->stock_quantity) ?>" data-status="<?= h($product->status) ?>" data-style="<?= h($product->style) ?>">

                    <td><?= $this->Html->link(h($product->name), ['action' => 'view', $product->id], ['class'=> 'list-name']) ?></td>

                    <td class="<?= $product->stock_quantity === 0 ? 'out-of-stock' : ($product->stock_quantity < 10 ? 'low-stock' : '') ?>"
                        data-order="<?= h($product->stock_quantity) ?>">
                        <?= $product->stock_quantity === 0 ? 'Out of Stock' : $this->Number->format($product->stock_quantity) ?>
                    </td>

                    <td><?= $this->Number->format($product->price, ['places' => 2, 'before' => '$']) ?></td>
                    <td><?= h($product->vintage) ?></td>
                    <td><?= $product->alcohol_content === null ? '' : $this->Number->format($product->alcohol_content, ['after'=>'%']) ?></td>

                    <td><?= h($product->region) ?></td>
                    <td><?= h($product->style) ?></td>
                    <?php if(h($product->status) === 'Listed'):?>
                        <td class="table-status"><?= h($product->status) ?></td>
                    <?php else: ?>
                        <td><?= h($product->status) ?></td>
                    <?php endif;?>
                    <td class="actions">
                        <?php if($product->status ==='Listed'):
                        echo $this->Html->link('<i class="bi bi-eye"></i>', ['action' => 'changeStatus', $product->id], ['class' => 'btn btn-status-listed btn-large',
                            'title'=>'Change Status',
                            'escape' => false]);
                        ?>
                        <?php elseif($product->status ==='Unlisted'):
                        echo $this->Html->link('<i class="bi bi-eye-slash"></i>', ['action' => 'changeStatus', $product->id], ['class' => 'btn btn-status-unlisted btn-large',
                            'title'=>'Change Status',
                            'escape' => false]);
                        endif;
                        ?>
                        <?= $this->Html->link('<i class="bi bi-pencil"></i>', ['action' => 'edit', $product->id], ['class' => 'btn btn-edit btn-large', 'title' => 'Edit', 'escape'=>false] ) ?>
                        <?= $this->Form->postLink(
                            __('<i class="bi bi-trash3"></i>'),
                            ['action' => 'delete', $product->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete {0}?', $product->name),
                                'class' => 'btn btn-delete btn-large',
                                'title' => 'Delete',
                                'escape' => false
                            ]
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

        //use datatables
        $('#ProductsTable').DataTable(
            {responsive: true,
                ordering: true,
                stateSave: true,
                drawCallback: function() {
                    // Restore scroll position after operations
                    var scrollPos = $(window).data('scrollPos') || 0;
                    $('html, body').stop().animate({scrollTop: scrollPos}, 100);

                },
                initComplete: function() {
                    // Apply filters once DataTable is initialized
                    applyFilters();
                },

            }

        );

        //javascript filter

        function applyFilters() {
            previousScrollPosition = $(window).scrollTop();

            let stockFilter = $('#stock-filter').val();
            let statusFilter = $('#status-filter').val();
            let styleFilter = $('#style-filter').val();


            $('.products-row').each(function () {
                let stockQuantity = parseInt($(this).data('stock'),10) //get stock from data
                let status = $(this).data('status')?.toString().trim(); //get status from data
                let style = $(this).data('style')?.toString().trim(); //get style from records

                let matchStock = (stockFilter === "" ||
                    (stockFilter === "1" && stockQuantity <= 10) || (stockFilter === "2" && stockQuantity === 0));

                let matchStatus = (statusFilter === "" ||
                    (statusFilter === "1" && status === "Listed") || (statusFilter === "2" && status === "Unlisted"));

                let matchStyle = (styleFilter === "" ||
                    styleFilter === style);

                $(this).toggle(matchStock && matchStatus && matchStyle);


            });

        }

        $('#stock-filter, #status-filter, #style-filter').on('input change', function () {
            applyFilters();
        });

        // Apply filters on page load
        applyFilters();

        // Prevent automatic scrolling when page reloads
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    });

</script>



