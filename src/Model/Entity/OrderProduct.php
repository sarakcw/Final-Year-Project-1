<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderProduct Entity
 *
 * @property int $order_id
 * @property int $product_id
 * @property int $quantity
 * @property float $price
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Product $product
 */
class OrderProduct extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'order_id' => true,
        'product_id' => true,
        'quantity' => true,
        'price' => true,
        'order' => true,
        'product' => true,
    ];
} 