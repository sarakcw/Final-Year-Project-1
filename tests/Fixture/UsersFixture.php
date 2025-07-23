<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'email' => 'Lorem ipsum dolor sit amet',
                'phone' => '350ac067-746c-442e-8963-065ac35109bd',
                'password' => 'Lorem ipsum dolor sit amet',
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'user_type' => 'Lorem ipsum dolor sit amet',
                'nonce' => 'Lorem ipsum dolor sit amet',
                'nonce_expiry' => '2025-03-22 15:31:08',
                'created' => '2025-03-22 15:31:08',
                'modified' => '2025-03-22 15:31:08',
            ],
        ];
        parent::init();
    }
}
