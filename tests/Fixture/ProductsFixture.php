<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'stock_quantity' => 1,
                'price' => 1.5,
                'vintage' => 'Lorem ipsum dolor sit amet',
                'alcohol_content' => 1.5,
                'status' => 'Lorem ipsum dolor ',
                'region' => 'Lorem ipsum dolor sit amet',
                'style' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2025-04-07 15:39:43',
                'updated_at' => '2025-04-07 15:39:43',
            ],
        ];
        parent::init();
    }
}
