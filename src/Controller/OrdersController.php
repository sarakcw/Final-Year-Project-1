<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        // Allow unauthenticated access to add action
        $this->Authentication->addUnauthenticatedActions(['view', 'index', 'checkout']);
    }

    /**
     * Before filter method
     *
     * @param \Cake\Event\EventInterface $event Event object
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        if ($this->request->getParam('action') !== 'adminIndex') {
            return;
        }

        $user = $this->Authentication->getIdentity();

        if ($user && $user->user_type === 'Admin') {
            $this->viewBuilder()->setLayout('admin');
        }

        if ($user->user_type !== 'Admin') {
            $this->response = $this->response->withStringBody(
                '<script>alert("You do not have permission to access this page."); window.location.href = "/";</script>'
            );
            return $this->response;
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Orders->find()
            ->contain(['Users', 'OrderProducts.Products'])
            ->where(['user_id' => $this->Authentication->getIdentity()->getIdentifier()])
            ->order(['Orders.created' => 'DESC']);
        $orders = $this->paginate($query);

        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'OrderProducts.Products'],
        ]);

        $this->set(compact('order'));
    }

    /**
     * Checkout method - Creates an order from the current cart
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function checkout()
    {
        if ($this->request->is('get')) {
            $cartItems = $this->fetchTable('CartItems')->find()
                ->where(['user_id' => $this->Authentication->getIdentity()->getIdentifier()])
                ->contain(['Products'])
                ->all();

            if ($cartItems->isEmpty()) {
                $this->Flash->error(__('Your cart is empty.'));
                return $this->redirect(['controller' => 'CartItems', 'action' => 'index']);
            }

            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item->product->price * $item->product_quantity;
            }

            // Get user's address if exists
            $user = $this->fetchTable('Users')->get($this->Authentication->getIdentity()->getIdentifier());
            $userAddress = $user->address ?? '';

            $this->set(compact('cartItems', 'totalAmount', 'userAddress'));
        }

        if ($this->request->is('post')) {
            $cartItems = $this->fetchTable('CartItems')->find()
                ->where(['user_id' => $this->Authentication->getIdentity()->getIdentifier()])
                ->contain(['Products'])
                ->all();

            if ($cartItems->isEmpty()) {
                $this->Flash->error(__('Your cart is empty.'));
                return $this->redirect(['controller' => 'CartItems', 'action' => 'index']);
            }

            // Validate stock quantities before processing the order
            foreach ($cartItems as $item) {
                if ($item->product_quantity > $item->product->stock_quantity) {
                    $this->Flash->error(__('Not enough stock available for {0}. Available: {1}, Requested: {2}', 
                        $item->product->name, 
                        $item->product->stock_quantity, 
                        $item->product_quantity
                    ));
                    return $this->redirect(['controller' => 'CartItems', 'action' => 'index']);
                }
            }

            $data = $this->request->getData();
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item->product->price * $item->product_quantity;
            }

            $order = $this->Orders->newEmptyEntity();
            $order = $this->Orders->patchEntity($order, [
                'user_id' => $this->Authentication->getIdentity()->getIdentifier(),
                'total_amount' => $totalAmount,
                'shipping_address' => $data['shipping_address'],
            ]);

            if ($this->Orders->save($order)) {
                // Create order products
                $orderProducts = $this->fetchTable('OrderProducts');
                foreach ($cartItems as $item) {
                    $orderProduct = $orderProducts->newEntity([
                        'order_id' => $order->order_id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->product_quantity,
                        'price' => $item->product->price,
                    ]);
                    $orderProducts->save($orderProduct);

                    // Update product stock quantity
                    $product = $this->fetchTable('Products')->get($item->product_id);
                    $product->stock_quantity -= $item->product_quantity;
                    $this->fetchTable('Products')->save($product);
                }

                // Clear cart
                $this->fetchTable('CartItems')->deleteAll([
                    'user_id' => $this->Authentication->getIdentity()->getIdentifier()
                ]);

                $this->Flash->success(__('The order has been placed successfully.'));
                return $this->redirect(['action' => 'view', $order->order_id]);
            }
            $this->Flash->error(__('The order could not be placed. Please, try again.'));
        }
    }

    public function adminIndex()
    {
        $this->viewBuilder()->setLayout('admin');

        $query = $this->Orders->find()
            ->contain(['Users', 'OrderProducts.Products'])
            ->order(['Orders.created' => 'DESC']);
        $orders = $this->paginate($query);

        $this->set(compact('orders'));
    }

    public function adminView($id = null)
    {
        $this->viewBuilder()->setLayout('admin');

        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'OrderProducts.Products'],
        ]);

        $this->set(compact('order'));
    }
}
