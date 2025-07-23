<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use App\Model\Table\ContactEnquiriesTable;
use App\Model\Table\ProductsTable;
use App\Model\Table\OrdersTable;

/**
 * Admin Controller
 *
 * @property UsersTable $Users
 * @property ContactEnquiriesTable $ContactEnquiries
 * @property ProductsTable $Products
 * @property OrdersTable $Orders
 */
class AdminController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Users = $this->getTableLocator()->get('Users');
        $this->ContactEnquiries = $this->getTableLocator()->get('ContactEnquiries');
        $this->Products = $this->getTableLocator()->get('Products');
        $this->Orders = $this->getTableLocator()->get('Orders');
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

    public function dashboard()
    {
        $totalUsers = $this->Users->find()->count();
        $totalEnquiries = $this->ContactEnquiries->find()->count();
        $totalProducts = $this->Products->find()->count();
        $totalOrders = $this->Orders->find()->count();

        $today = date('Y-m-d 00:00:00');
        
        $todayOrders = $this->Orders->find()
            ->where(['Orders.created >=' => $today])
            ->count();

        $newOrders = $this->Orders->find()
            ->select(['Orders.order_id', 'Orders.total_amount', 'Orders.created', 'Users.email'])
            ->where(['Orders.created >=' => $today])
            ->contain(['Users' => ['fields' => ['email']]])
            ->order(['Orders.created' => 'DESC'])
            ->limit(5)
            ->all();

        $todayEnquiries = $this->ContactEnquiries->find()
            ->where(['date_sent >=' => $today])
            ->count();

        $newEnquiries = $this->ContactEnquiries->find()
            ->select(['id', 'first_name', 'last_name', 'email', 'message', 'date_sent'])
            ->where(['date_sent >=' => $today])
            ->order(['date_sent' => 'DESC'])
            ->limit(5)
            ->all();

        $this->set(compact('totalUsers', 'totalEnquiries', 'totalProducts', 'totalOrders', 
                          'todayOrders', 'todayEnquiries', 'newOrders', 'newEnquiries'));
        $this->set('title', 'Dashboard');
    }
}
