<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CartItem $cartItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cart Item'), ['action' => 'edit', $cartItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cart Item'), ['action' => 'delete', $cartItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cartItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cart Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cart Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cartItems view content">
            <h3><?= h($cartItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $cartItem->hasValue('product') ? $this->Html->link($cartItem->product->name, ['controller' => 'Products', 'action' => 'view', $cartItem->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $cartItem->hasValue('user') ? $this->Html->link($cartItem->user->email, ['controller' => 'Users', 'action' => 'view', $cartItem->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cartItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Quantity') ?></th>
                    <td><?= $cartItem->product_quantity === null ? '' : $this->Number->format($cartItem->product_quantity) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>