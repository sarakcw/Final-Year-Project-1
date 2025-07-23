<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CartItem> $cartItems
 */
?>
<div class="cart-container cartItems index content">
    <?= $this->Html->tag('button', '<i class="bi bi-arrow-left"></i>  Back to Shopping',
        ['type' => 'button',
            'onclick' => 'window.history.back();',
            'class' => 'btn back-btn text-start w-auto']) ?>
    <div class="cart-page-title"><?= __('Your Shopping Cart') ?></div>
    <div class="alert alert-dismissible fade show" role="alert">
        <?= $this->Flash->render('shoppingCartFeedback');?>
    </div>
    <div class="table-responsive">
        <table class="cart-table w-100">
            <thead>
                <tr style="margin-bottom: 10px; font-family: 'Comfortaa', sans-serif; font-size: 20px; color: #333333">
                    <th>Products</th>
                    <th></th>
                    <th>Quantity</th>
                    <th>Item Total</th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <!-- Styled separator row -->
            <tr style="height: 0.5px; background-color: #b12704;">
                <td colspan="5" style="padding: 0;"></td>
            </tr>

            <tbody >
                <?php
                $totalAmount = 0;
                foreach ($cartItems as $cartItem):
                    $subtotal = $cartItem->product->price * $cartItem->product_quantity;
                    $totalAmount += $subtotal;
                ?>
                <tr>
                    <td><?= $cartItem->hasValue('product') ?
                            $this->Html->link(
                                $this->Html->image('/img/' . $cartItem->product->image, [
                                    'alt' => $cartItem->product->name, 'style' => 'max-width: 150px; max-height: 150px;']),
                                ['controller' => 'Products', 'action' => 'page', $cartItem->product->id],
                                ['escape' => false]
                            )
                            : '' ?>
                    </td>
                    <td>
                        <?= $cartItem->hasValue('product') ?
                            $this->Html->link(
                                $cartItem->product->name,
                                ['controller' => 'Products', 'action' => 'page', $cartItem->product->id],
                                ['class' => 'cart-item-name']
                            )
                            : '' ?>
                    </td>
                    <td>
                        <div class="adjust-quantity">
                            <?= $this->Html->link('-', ['action' => 'decreaseQuantity', $cartItem->id], ['class' => 'btn btn-large',
                                'title'=>'Decrease Quantity',
                                'escape' => false,
                                'disabled' => $cartItem->product_quantity <= 1 ? true : false,
                                'onclick' => $cartItem->product_quantity <= 1 ? 'return false;' : null
                                ]); ?>
                            <?= $cartItem->product_quantity === null ? '' : $this->Number->format($cartItem->product_quantity) ?>
                            <?= $this->Html->link('+',['controller' => 'CartItems',
                                'action' => 'increaseQuantity', $cartItem->id],
                                ['class' => 'btn btn-large',
                                'escape' => false,

                            ]) ?>
                        </div>
                    </td>

                    <td><?= $this->Number->currency($cartItem->product_quantity * $cartItem->product->price) ?></td>

                    <td class="actions">
                        <?= $this->Form->postLink(
                            __('Remove'),
                            ['action' => 'delete', $cartItem->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to remove {0} from cart?', $cartItem->product->name),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tr style="height: 0.5px; background-color:#b12704;">
                <td colspan="5" style="padding: 0;"></td>
            </tr>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong><?= __('Total Amount:') ?></strong></td>
                    <td><strong><?= $this->Number->currency($totalAmount) ?></strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <?php if (!$cartItems->isEmpty()): ?>
        <div class="text-end mt-4" style="color: #b12704">
            <?= $this->Html->link(
                __('Checkout'),
                ['controller' => 'Orders', 'action' => 'checkout'],
                ['class' => 'btn checkout-btn btn-lg']
            ) ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .cart-container {
        max-width: 1380px;
        margin: 0 auto;
        margin-top: 50px;
        padding-top: 30px;
        padding-bottom: 30px;
        padding-left: 5px;
        padding-right: 5px;

    }
    .cart-table{
        border-collapse: separate;
        border-spacing: 0 30px; /* adds vertical spacing between rows */
        width: 100%;
        font-family: 'Comfortaa', sans-serif;
    }
    .cart-page-title{
        font-size: 30px;
        font-weight: bold;
        font-family: 'Lora', serif;
        padding-top: 8px;
    }
    a.cart-item-name{
        text-decoration: none; !important;
        color: #333;
        font-weight: 700;
    }

    .adjust-quantity{
        border: solid 1px #333333;
        background: transparent;
        border-radius: 3px;
        display: inline-flex;
        align-items: center;
    }

    a.checkout-btn{
        font-family: 'Comfortaa', sans-serif;
        color: #b12704;
        border: solid 1px #ddd;
        background: #f9f9f9;
    }
    a.checkout-btn:hover{
        border: solid 1px #b12704;
        background: #f9f9f9;
    }

</style>
