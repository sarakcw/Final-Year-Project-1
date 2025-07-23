<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * CartItems helper
 */
class CartItemsHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Get the cart count for the current user
     *
     * @param int|null $userId The user ID
     * @return int The cart count
     */
    public function getCartCount($userId = null)
    {
        if (!$userId) {
            return 0;
        }

        $cartItemsTable = $this->getView()->getRequest()->getSession()->read('cartItemsTable');
        if (!$cartItemsTable) {
            return 0;
        }

        $cartItems = $cartItemsTable->find()
            ->where(['user_id' => $userId]);

        $cartCount = 0;
        foreach ($cartItems as $item) {
            $cartCount += $item->product_quantity;
        }

        return $cartCount;
    }

    /**
     * Display the cart count badge
     *
     * @param int|null $userId The user ID
     * @param array $options Additional options
     * @return string The HTML for the cart count badge
     */
    public function displayCartCount($userId = null, array $options = [])
    {
        $count = $this->getCartCount($userId);
        $class = isset($options['class']) ? $options['class'] : 'cart-count';
        
        if ($count > 0) {
            return '<span class="' . $class . '">' . $count . '</span>';
        }
        
        return '';
    }
} 