<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CartItems Controller
 *
 * @property \App\Model\Table\CartItemsTable $CartItems
 */
class CartItemsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // Allow unauthenticated access to add action
        $this->Authentication->addUnauthenticatedActions(['add', 'index', 'view', 'edit', 'delete']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['add']); // Allow guest access
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $userId = $this->request->getAttribute('identity')?->getIdentifier();

        if (!$userId) {
            $this->Flash->error(__('You need to be logged in to view your cart.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $query = $this->CartItems->find()
            ->contain(['Products'])
            ->where(['CartItems.user_id' => $userId]);

        $cartItems = $this->paginate($query);

        $this->set(compact('cartItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Cart Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cartItem = $this->CartItems->get($id, contain: ['Products', 'Users']);
        $this->set(compact('cartItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cartItem = $this->CartItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Check if user is logged in
            $userId = $this->request->getAttribute('identity')?->getIdentifier();

            if (!empty($userId)) {
                // Logged in: Save to DB
                $data['user_id'] = $userId;

                // Check if product already exists in DB cart
                $existingItem = $this->CartItems->find()
                    ->where([
                        'product_id' => $data['product_id'],
                        'user_id' => $userId
                    ])
                    ->first();

                if ($existingItem) {
                    // Update quantity
                    $existingItem->product_quantity += $data['product_quantity'];
                    $cartItem = $existingItem;
                } else {
                    // Create new cart item
                    $cartItem = $this->CartItems->patchEntity($cartItem, $data);
                }

                // Save the cart item to DB
                if ($this->CartItems->save($cartItem)) {
                    // Get updated cart count
                    $cartCount = $this->CartItems->find()
                        ->select(['total_quantity' => 'SUM(product_quantity)'])
                        ->where(['user_id' => $userId])
                        ->first()
                        ->total_quantity ?? 0;

                    $this->Flash->success(__('Item added to cart.'), ['key' => 'add2CartFeedback']);

                    // Check if this is an AJAX request
                    if ($this->request->is('ajax')) {
                        $this->response = $this->response->withType('application/json')
                            ->withStringBody(json_encode([
                                'success' => true,
                                'message' => 'Item added to cart successfully!',
                                'cartCount' => (int)$cartCount
                            ]));
                        return $this->response;
                    }

                    return $this->redirect($this->referer());
                }

                // Log error for debugging
                $errors = $cartItem->getErrors();
                \Cake\Log\Log::error('Failed to save cart item: ' . json_encode($errors));

                $this->Flash->error(__('The cart item could not be saved. Please, try again.'), ['key' => 'add2CartFeedback']);

                // Check if this is an AJAX request
                if ($this->request->is('ajax')) {
                    $this->response = $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => false,
                            'message' => 'The cart item could not be saved. Please, try again.',
                            'errors' => $errors
                        ]));
                    return $this->response;
                }
            } else {
                // Check if this is an AJAX request
                if ($this->request->is('ajax')) {
                    $this->response = $this->response->withStatus(401)
                        ->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => false,
                            'message' => 'You need to be logged in to add items to your cart.'
                        ]));
                    return $this->response;
                }

                $this->Flash->error(__('Please log in to add items to your cart.'), ['key' => 'authFeedback']);
                return $this->redirect(['controller' => 'Auth', 'action' => 'login']);
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Cart Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cartItem = $this->CartItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cartItem = $this->CartItems->patchEntity($cartItem, $this->request->getData());
            if ($this->CartItems->save($cartItem)) {
                $this->Flash->success(__('The cart item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart item could not be saved. Please, try again.'));
        }
        $products = $this->CartItems->Products->find('list', limit: 200)->all();
        $users = $this->CartItems->Users->find('list', limit: 200)->all();
        $this->set(compact('cartItem', 'products', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cart Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cartItem = $this->CartItems->get($id);
        $userId = $this->request->getAttribute('identity')?->getIdentifier();

        if ($this->CartItems->delete($cartItem)) {
            // Get updated cart count
            $cartCount = $this->CartItems->find()
                ->select(['total_quantity' => 'SUM(product_quantity)'])
                ->where(['user_id' => $userId])
                ->first()
                ->total_quantity ?? 0;

            $this->Flash->success(__('The cart item has been deleted.'), ['key' => 'shoppingCartFeedback']);

            if ($this->request->is('ajax')) {
                $this->response = $this->response->withType('application/json')
                    ->withStringBody(json_encode([
                        'success' => true,
                        'message' => 'The cart item has been deleted.',
                        'cartCount' => (int)$cartCount
                    ]));
                return $this->response;
            }

            return $this->redirect($this->referer());
        } else {
            $this->Flash->error(__('The cart item could not be deleted. Please, try again.'), ['key' => 'shoppingCartFeedback']);

            if ($this->request->is('ajax')) {
                $this->response = $this->response->withType('application/json')
                    ->withStringBody(json_encode([
                        'success' => false,
                        'message' => 'The cart item could not be deleted. Please, try again.'
                    ]));
                return $this->response;
            }

            return $this->redirect($this->referer());
        }
    }

    /**
     * Decrease Quantity method
     *
     * @param string|null $id Cart Item id.
     * @return \Cake\Http\Response|null Redirects to referer.
     */
    public function decreaseQuantity($id = null)
    {
        $cartItem = $this->CartItems->get($id);
        $userId = $this->request->getAttribute('identity')?->getIdentifier();

        if ($cartItem->product_quantity > 1) {
            $cartItem->product_quantity--;
        } else {
            // Optionally delete the item if quantity becomes 0
            $this->CartItems->delete($cartItem);
        }

        if ($this->CartItems->save($cartItem) || $cartItem->isDeleted()) {
            // Get updated cart count
            $cartCount = $this->CartItems->find()
                ->select(['total_quantity' => 'SUM(product_quantity)'])
                ->where(['user_id' => $userId])
                ->first()
                ->total_quantity ?? 0;

            $this->Flash->success(__('Quantity updated.'), ['key' => 'cartQuantityFeedback']);

            if ($this->request->is('ajax')) {
                $this->response = $this->response->withType('application/json')
                    ->withStringBody(json_encode([
                        'success' => true,
                        'message' => 'Quantity updated.',
                        'cartCount' => (int)$cartCount
                    ]));
                return $this->response;
            }

            return $this->redirect($this->referer());
        } else {
            $this->Flash->error(__('Could not update quantity.'), ['key' => 'cartQuantityFeedback']);

            if ($this->request->is('ajax')) {
                $this->response = $this->response->withType('application/json')
                    ->withStringBody(json_encode([
                        'success' => false,
                        'message' => 'Could not update quantity.'
                    ]));
                return $this->response;
            }

            return $this->redirect($this->referer());
        }
    }

    /**
     * Increase Quantity method
     *
     * @param string|null $id Cart Item id.
     * @return \Cake\Http\Response|null Redirects to referer.
     */
    public function increaseQuantity($id = null)
    {
        $cartItem = $this->CartItems->get($id, ['contain' => ['Products']]);
        $userId = $this->request->getAttribute('identity')?->getIdentifier();

        if ($cartItem->product_quantity < $cartItem->product->stock_quantity) {
            $cartItem->product_quantity++;

            if ($this->CartItems->save($cartItem)) {
                // Get updated cart count
                $cartCount = $this->CartItems->find()
                    ->select(['total_quantity' => 'SUM(product_quantity)'])
                    ->where(['user_id' => $userId])
                    ->first()
                    ->total_quantity ?? 0;

                $this->Flash->success(__('Quantity updated.'), ['key' => 'cartQuantityFeedback']);

                if ($this->request->is('ajax')) {
                    $this->response = $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => true,
                            'message' => 'Quantity updated.',
                            'cartCount' => (int)$cartCount
                        ]));
                    return $this->response;
                }

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('Could not update quantity.'), ['key' => 'cartQuantityFeedback']);

                if ($this->request->is('ajax')) {
                    $this->response = $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => false,
                            'message' => 'Could not update quantity.'
                        ]));
                    return $this->response;
                }

                return $this->redirect($this->referer());
            }
        } else {
            $this->Flash->error(__('Quantity exceeds stock limit.'), ['key' => 'cartQuantityFeedback']);

            if ($this->request->is('ajax')) {
                $this->response = $this->response->withType('application/json')
                    ->withStringBody(json_encode([
                        'success' => false,
                        'message' => 'Quantity exceeds stock limit.'
                    ]));
                return $this->response;
            }

            return $this->redirect($this->referer());
        }
    }

    /**
     * Count method
     *
     * @return \Cake\Http\Response Returns JSON with cart count
     */
    public function count()
    {
        $this->request->allowMethod(['get']);

        $userId = $this->request->getAttribute('identity')?->getIdentifier();
        $cartCount = 0;

        if ($userId) {
            $cartCount = $this->CartItems->find()
                ->select(['total_quantity' => 'SUM(product_quantity)'])
                ->where(['user_id' => $userId])
                ->first()
                ->total_quantity ?? 0;
        }

        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode([
                'cartCount' => (int)$cartCount
            ]));
        return $this->response;
    }
}
