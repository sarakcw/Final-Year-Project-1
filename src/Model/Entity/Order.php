<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $order_id
 * @property int $user_id
 * @property float $total_amount
 * @property string $shipping_address
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\OrderProduct[] $order_products
 */
class Order extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'order_id' => true,
        'user_id' => true,
        'total_amount' => true,
        'shipping_address' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'order_products' => true,
    ];
}
