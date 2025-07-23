<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $stock_quantity
 * @property string $price
 * @property string|null $vintage
 * @property string|null $alcohol_content
 * @property string $status
 * @property string $region
 * @property string $style
 * @property string $image
 * @property \Cake\I18n\DateTime|null $created_at
 * @property \Cake\I18n\DateTime|null $updated_at
 */
class Product extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'stock_quantity' => true,
        'price' => true,
        'vintage' => true, //the year the wine was harvested
        'alcohol_content' => true,
        'status' => true, //listed or unlisted
        'region' => true,
        'style' => true, //red, white, sparkling, etc
        'image' => true,
        'created_at' => true,
        'updated_at' => true,
    ];
}
