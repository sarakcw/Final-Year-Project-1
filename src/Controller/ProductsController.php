<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // Allow unauthenticated access to customer-facing actions
        $this->Authentication->addUnauthenticatedActions([
            'page',
            'view',
            'autocomplete',
            'search',
            'loadMore',
            'applyFilter',
            'removeFilter',
            'clearAllFilters',
            'cartForm'
        ]);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Customer-facing actions use default layout and are accessible to all
        $customerActions = [
            'page',
            'view',
            'autocomplete',
            'search',
            'loadMore',
            'applyFilter',
            'removeFilter',
            'clearAllFilters',
            'cartForm'
        ];

        $action = strtolower($this->request->getParam('action'));
        if (in_array($action, array_map('strtolower', $customerActions))) {
            $this->viewBuilder()->setLayout('default');
            \Cake\Log\Log::debug("Allowing action: $action");
            return;
        }

        // Admin-only actions
        $user = $this->Authentication->getIdentity();
        if (!$user || $user->user_type !== 'Admin') {
            \Cake\Log\Log::debug("Blocking action: $action, user: " . ($user ? $user->user_type : 'guest'));
            $this->response = $this->response->withStatus(403)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Unauthorized access']));
            return $this->response;
        }

        $this->viewBuilder()->setLayout('admin');
    }

    public function index()
    {
        $query = $this->Products->find();
        $products = $this->paginate($query);
        $this->set('stockFilter', $this->request->getQuery('stock_filter'));
        $this->set('statusFilter', $this->request->getQuery('status'));
        $this->set('styleFilter', $this->request->getQuery('style'));

        $this->set(compact('products'));
    }

    public function view($id = null)
    {
        $product = $this->Products->get($id, contain: []);
        $this->set(compact('product'));
    }

    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Remove image from data to prevent patchEntity() from processing it
            $image = $data['image'] ?? null;
            unset($data['image']);

            $product = $this->Products->patchEntity($product, $data);

            // Handle file upload
            if ($image && $image->getClientFilename() !== '') {
                if ($image->getError() === UPLOAD_ERR_OK) {
                    $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", $image->getClientFilename());
                    $uploadDir = WWW_ROOT . 'img' . DS . 'products' . DS;

                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0775, true);
                    }

                    $targetPath = $uploadDir . $filename;
                    $image->moveTo($targetPath);

                    $product->image = 'products/' . $filename;
                } else {
                    $this->Flash->error(__('Image could not be uploaded. Please, try again.'), ['key' => 'productAddFeedback']);
                    return $this->redirect($this->referer());
                }
            }

            if ($this->Products->save($product)) {
                $this->Flash->success(__('{0} has been saved.', $product->name), ['key' => 'viewProductsFeedback']);
                return $this->redirect(['action' => 'view', $product->id]);
            }
            $this->Flash->error(__('This product could not be saved. Please, try again.', $product->name), ['key' => 'productAddFeedback']);
            return $this->redirect($this->referer());

        }
        $this->set(compact('product'));
    }

    public function edit($id = null)
    {
        $product = $this->Products->get($id, contain: []);
        $existingImage = $product->image;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Remove image from data to prevent patchEntity() from processing it
            $image = $data['image'] ?? null;
            unset($data['image']);

            $product = $this->Products->patchEntity($product, $data);

            // Handle file upload
            if ($image && $image->getClientFilename() !== '') {
                if ($image->getError() === UPLOAD_ERR_OK) {
                    $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", $image->getClientFilename());
                    $uploadDir = WWW_ROOT . 'img' . DS . 'products' . DS;

                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0775, true);
                    }

                    $targetPath = $uploadDir . $filename;
                    $image->moveTo($targetPath);

                    $product->image = 'products/' . $filename;
                } else {
                    $this->Flash->error(__('Image could not be uploaded. Please, try again.'), ['key' => 'productAddFeedback']);
                    return $this->redirect($this->referer());
                }
            } else {
                $product->image = $existingImage;
            }

            if ($this->Products->save($product)) {
                $this->Flash->success(__('{0} has been modified.', $product->name), ['key' => 'viewProductsFeedback']);
                return $this->redirect(['action' => 'view', $product->id]);
            }
            $this->Flash->error(__('{0} could not be modified. Please, try again.', $product->name), ['key' => 'productEditFeedback']);
        }
        $this->set(compact('product'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);

        if ($this->Products->delete($product)) {
            $this->Flash->success(__('{0} has been deleted.', $product->name), ['key' => 'productFeedback']);
        } else {
            $this->Flash->error(__('{0} could not be deleted. Please, try again.', $product->name), ['key' => 'productFeedback']);
        }

        return $this->redirect(['action' => 'index']);
    }

    public function cancel($id = null)
    {
        $product = $this->Products->get($id);
        $this->Flash->warning(__('Editing of {0} has been cancelled.', $product->name), ['key' => 'productFeedback']);
        return $this->redirect(['action' => 'index']);
    }

    public function changeStatus($id = null)
    {
        $product = $this->Products->get($id);
        $product->status = ($product->status === 'Listed') ? 'Unlisted' : 'Listed';

        if ($this->Products->save($product)) {
            $this->Flash->success(__('The status of {0} has been changed.', $product->name), ['key' => 'viewProductsFeedback']);
            return $this->redirect($this->referer());
        }

        $this->Flash->error(__('The status of {0} could not be changed. Please, try again.', $product->name), ['key' => 'viewProductsFeedback']);
        return $this->redirect($this->referer());
    }

    private function applySorting($query)
    {
        $sort = $this->request->getQuery('sort');
        if ($sort === 'price_low_high') {
            $query->order(['price' => 'ASC']);
        } elseif ($sort === 'price_high_low') {
            $query->order(['price' => 'DESC']);
        } elseif ($sort === 'created_at_asc') {
            $query->order(['created_at' => 'ASC']);
        } elseif ($sort === 'created_at_desc') {
            $query->order(['created_at' => 'DESC']);
        } elseif ($sort === 'name_asc') {
            $query->order(['name' => 'ASC']);
        } elseif ($sort === 'name_desc') {
            $query->order(['name' => 'DESC']);
        }
        return $query;
    }

    private function applyFilters($query)
    {
        // Handle multiple filter values
        if ($this->request->getQuery('style')) {
            $styles = is_array($this->request->getQuery('style')) ? $this->request->getQuery('style') : [$this->request->getQuery('style')];
            $query->where(['style IN' => $styles]);
        }
        if ($this->request->getQuery('price')) {
            $priceRanges = is_array($this->request->getQuery('price')) ? $this->request->getQuery('price') : [$this->request->getQuery('price')];
            $priceConditions = [];
            foreach ($priceRanges as $priceRange) {
                if ($priceRange === '0_50') {
                    $priceConditions[] = ['price >=' => 0, 'price <=' => 50];
                } elseif ($priceRange === '50_100') {
                    $priceConditions[] = ['price >' => 50, 'price <=' => 100];
                } elseif ($priceRange === '100_plus') {
                    $priceConditions[] = ['price >' => 100];
                }
            }
            if ($priceConditions) {
                $query->where(['OR' => $priceConditions]);
            }
        }
        if ($this->request->getQuery('region')) {
            $regions = is_array($this->request->getQuery('region')) ? $this->request->getQuery('region') : [$this->request->getQuery('region')];
            $query->where(['region IN' => $regions]);
        }
        if ($this->request->getQuery('vintage')) {
            $vintages = is_array($this->request->getQuery('vintage')) ? $this->request->getQuery('vintage') : [$this->request->getQuery('vintage')];
            $query->where(['vintage IN' => $vintages]);
        }
        return $query;
    }

    public function page()
    {
        $cartItems = $this->request->getSession()->read('Cart.items');
        $query = $this->Products->find()
            ->select(['id', 'name', 'price', 'image', 'style', 'region', 'vintage', 'alcohol_content', 'stock_quantity', 'status', 'created_at'])
            ->where(['status' => 'Listed']);

        // Apply filters and sorting
        $query = $this->applyFilters($query);
        $query = $this->applySorting($query);

        // Fetch all possible filter options
        $allStyles = $this->Products->find()
            ->select(['style'])
            ->distinct(['style'])
            ->where(['style IS NOT NULL', 'status' => 'Listed'])
            ->order(['style' => 'ASC'])
            ->all()
            ->toArray();
        $allRegions = $this->Products->find()
            ->select(['region'])
            ->distinct(['region'])
            ->where(['region IS NOT NULL', 'status' => 'Listed'])
            ->order(['region' => 'ASC'])
            ->all()
            ->toArray();
        $allVintages = $this->Products->find()
            ->select(['vintage'])
            ->distinct(['vintage'])
            ->where(['vintage IS NOT NULL', 'status' => 'Listed'])
            ->order(['vintage' => 'DESC'])
            ->all()
            ->toArray();
        $allPrices = [
            ['value' => '0_50', 'label' => '$0 - $50'],
            ['value' => '50_100', 'label' => '$50 - $100'],
            ['value' => '100_plus', 'label' => '$100+']
        ];

        // Fetch available filter options based on filtered products
        // Create a new query with the same conditions as $query
        $availableQuery = $this->Products->find()
            ->select(['style', 'region', 'vintage', 'price'])
            ->where(['status' => 'Listed']);

        // Apply the same filter conditions
        if ($this->request->getQuery('style')) {
            $styles = is_array($this->request->getQuery('style')) ? $this->request->getQuery('style') : [$this->request->getQuery('style')];
            $availableQuery->where(['style IN' => $styles]);
        }
        if ($this->request->getQuery('price')) {
            $priceRanges = is_array($this->request->getQuery('price')) ? $this->request->getQuery('price') : [$this->request->getQuery('price')];
            $priceConditions = [];
            foreach ($priceRanges as $priceRange) {
                if ($priceRange === '0_50') {
                    $priceConditions[] = ['price >=' => 0, 'price <=' => 50];
                } elseif ($priceRange === '50_100') {
                    $priceConditions[] = ['price >' => 50, 'price <=' => 100];
                } elseif ($priceRange === '100_plus') {
                    $priceConditions[] = ['price >' => 100];
                }
            }
            if ($priceConditions) {
                $availableQuery->where(['OR' => $priceConditions]);
            }
        }
        if ($this->request->getQuery('region')) {
            $regions = is_array($this->request->getQuery('region')) ? $this->request->getQuery('region') : [$this->request->getQuery('region')];
            $availableQuery->where(['region IN' => $regions]);
        }
        if ($this->request->getQuery('vintage')) {
            $vintages = is_array($this->request->getQuery('vintage')) ? $this->request->getQuery('vintage') : [$this->request->getQuery('vintage')];
            $availableQuery->where(['vintage IN' => $vintages]);
        }

        // Fetch available styles, regions, and vintages
        $availableStyles = $availableQuery
            ->select(['style'])
            ->distinct(['style'])
            ->where(['style IS NOT NULL'])
            ->all()
            ->extract('style')
            ->toArray();
        $availableRegions = $availableQuery
            ->select(['region'])
            ->distinct(['region'])
            ->where(['region IS NOT NULL'])
            ->all()
            ->extract('region')
            ->toArray();
        $availableVintages = $availableQuery
            ->select(['vintage'])
            ->distinct(['vintage'])
            ->where(['vintage IS NOT NULL'])
            ->all()
            ->extract('vintage')
            ->toArray();

        // Fetch available price ranges
        $availablePrices = [];
        // Create separate queries for each price range to check availability
        $price0_50Query = $this->Products->find()
            ->where(['status' => 'Listed', 'price >=' => 0, 'price <=' => 50]);
        if ($this->request->getQuery('style')) {
            $price0_50Query->where(['style IN' => $styles]);
        }
        if ($this->request->getQuery('region')) {
            $price0_50Query->where(['region IN' => $regions]);
        }
        if ($this->request->getQuery('vintage')) {
            $price0_50Query->where(['vintage IN' => $vintages]);
        }
        if ($price0_50Query->count() > 0) {
            $availablePrices[] = '0_50';
        }

        $price50_100Query = $this->Products->find()
            ->where(['status' => 'Listed', 'price >' => 50, 'price <=' => 100]);
        if ($this->request->getQuery('style')) {
            $price50_100Query->where(['style IN' => $styles]);
        }
        if ($this->request->getQuery('region')) {
            $price50_100Query->where(['region IN' => $regions]);
        }
        if ($this->request->getQuery('vintage')) {
            $price50_100Query->where(['vintage IN' => $vintages]);
        }
        if ($price50_100Query->count() > 0) {
            $availablePrices[] = '50_100';
        }

        $price100PlusQuery = $this->Products->find()
            ->where(['status' => 'Listed', 'price >' => 100]);
        if ($this->request->getQuery('style')) {
            $price100PlusQuery->where(['style IN' => $styles]);
        }
        if ($this->request->getQuery('region')) {
            $price100PlusQuery->where(['region IN' => $regions]);
        }
        if ($this->request->getQuery('vintage')) {
            $price100PlusQuery->where(['vintage IN' => $vintages]);
        }
        if ($price100PlusQuery->count() > 0) {
            $availablePrices[] = '100_plus';
        }

        // Get all products without pagination
        $products = $query->all();
        $totalCount = count($products);

        $this->set(compact(
            'products',
            'allStyles',
            'allRegions',
            'allVintages',
            'allPrices',
            'availableStyles',
            'availableRegions',
            'availableVintages',
            'availablePrices',
            'cartItems',
            'totalCount'
        ));
    }

    public function applyFilter($filterType = null, $filterValue = null)
    {
        $queryParams = $this->request->getQueryParams();
        switch (strtolower($filterType)) {
            case 'price':
                if (!isset($queryParams['price'])) {
                    $queryParams['price'] = [];
                }
                if (!is_array($queryParams['price'])) {
                    $queryParams['price'] = [$queryParams['price']];
                }
                if (in_array($filterValue, $queryParams['price'])) {
                    $queryParams['price'] = array_diff($queryParams['price'], [$filterValue]);
                } else {
                    $queryParams['price'][] = $filterValue;
                }
                if (empty($queryParams['price'])) {
                    unset($queryParams['price']);
                }
                break;
            case 'variety':
                if (!isset($queryParams['style'])) {
                    $queryParams['style'] = [];
                }
                if (!is_array($queryParams['style'])) {
                    $queryParams['style'] = [$queryParams['style']];
                }
                if (in_array($filterValue, $queryParams['style'])) {
                    $queryParams['style'] = array_diff($queryParams['style'], [$filterValue]);
                } else {
                    $queryParams['style'][] = $filterValue;
                }
                if (empty($queryParams['style'])) {
                    unset($queryParams['style']);
                }
                break;
            case 'region':
                if (!isset($queryParams['region'])) {
                    $queryParams['region'] = [];
                }
                if (!is_array($queryParams['region'])) {
                    $queryParams['region'] = [$queryParams['region']];
                }
                if (in_array($filterValue, $queryParams['region'])) {
                    $queryParams['region'] = array_diff($queryParams['region'], [$filterValue]);
                } else {
                    $queryParams['region'][] = $filterValue;
                }
                if (empty($queryParams['region'])) {
                    unset($queryParams['region']);
                }
                break;
            case 'vintage':
                if (!isset($queryParams['vintage'])) {
                    $queryParams['vintage'] = [];
                }
                if (!is_array($queryParams['vintage'])) {
                    $queryParams['vintage'] = [$queryParams['vintage']];
                }
                if (in_array($filterValue, $queryParams['vintage'])) {
                    $queryParams['vintage'] = array_diff($queryParams['vintage'], [$filterValue]);
                } else {
                    $queryParams['vintage'][] = $filterValue;
                }
                if (empty($queryParams['vintage'])) {
                    unset($queryParams['vintage']);
                }
                break;
            default:
                return $this->redirect(['action' => 'page', '?' => $queryParams]);
        }
        return $this->redirect(['action' => 'page', '?' => $queryParams]);
    }

    public function removeFilter($filterType = null)
    {
        $queryParams = $this->request->getQueryParams();
        switch (strtolower($filterType)) {
            case 'price':
                unset($queryParams['price']);
                break;
            case 'variety':
                unset($queryParams['style']);
                break;
            case 'region':
                unset($queryParams['region']);
                break;
            case 'vintage':
                unset($queryParams['vintage']);
                break;
            default:
                return $this->redirect(['action' => 'page', '?' => $queryParams]);
        }
        return $this->redirect(['action' => 'page', '?' => $queryParams]);
    }

    public function clearAllFilters()
    {
        $queryParams = $this->request->getQueryParams();
        $sort = $queryParams['sort'] ?? null;
        $queryParams = $sort ? ['sort' => $sort] : [];
        return $this->redirect(['action' => 'page', '?' => $queryParams]);
    }

    /**
     * Get quick view element for a product
     *
     * @return void
     */
    public function getQuickView()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $productId = $this->request->getQuery('product_id');
        if (!$productId) {
            $this->response = $this->response->withStatus(400);
            $this->response = $this->response->withStringBody('Product ID is required');
            return;
        }

        $product = $this->Products->get($productId, [
            'contain' => ['Categories']
        ]);

        $this->response = $this->response->withType('html');
        $this->response = $this->response->withStringBody($this->render('/element/Products/quick_view', [
            'product' => $product
        ])->getBody());
    }

    public function autocomplete()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;
        $query = $this->request->getQuery('query', '');
        $suggestions = [];

        if (!empty($query)) {
            $suggestions = $this->Products->find()
                ->select(['name'])
                ->where([
                    'name LIKE' => '%' . $query . '%',
                    'status' => 'Listed'
                ])
                ->limit(5)
                ->all()
                ->extract('name')
                ->toArray();
        }

        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode(['suggestions' => $suggestions]));
        return $this->response;
    }

    public function search()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;
        $query = trim($this->request->getQuery('query', ''));
        $products = [];

        \Cake\Log\Log::debug("Search: query='$query'");

        if (strlen($query) >= 2) {
            try {
                $products = $this->Products->find()
                    ->select(['id', 'name', 'price', 'image', 'status'])
                    ->where([
                        'name LIKE' => '%' . $query . '%',
                        'status' => 'Listed'
                    ])
                    ->limit(10)
                    ->all()
                    ->map(function ($product) {
                        \Cake\Log\Log::debug("Search product: id={$product->id}, name={$product->name}, status={$product->status}");
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => $product->price,
                            'image' => $product->image ?: null
                        ];
                    })
                    ->toArray();
            } catch (\Exception $e) {
                \Cake\Log\Log::error("Search error: " . $e->getMessage());
                $this->response = $this->response->withStatus(500)
                    ->withType('application/json')
                    ->withStringBody(json_encode(['error' => 'Search failed']));
                return $this->response;
            }
        }

        \Cake\Log\Log::debug("Search query: '$query', found " . count($products) . " products");
        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode(['products' => $products]));
        return $this->response;
    }

    public function cartForm()
    {
        $this->request->allowMethod(['get']);
        $productId = $this->request->getQuery('product_id');

        if (!$productId || !is_numeric($productId)) {
            return $this->response->withStatus(400)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Invalid product ID']));
        }

        $product = $this->Products->find()
            ->select(['id', 'status'])
            ->where(['id' => $productId, 'status' => 'Listed'])
            ->first();

        if (!$product) {
            return $this->response->withStatus(404)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Product not found or not listed']));
        }

        $this->set('product_id', (int)$productId);
        $this->viewBuilder()->setLayout('ajax');
        $this->render('cart_form');
    }

    public function getCsrfToken()
    {
        $this->request->allowMethod(['get']);
        return $this->response->withType('application/json')
            ->withStringBody(json_encode([
                'token' => $this->request->getAttribute('csrfToken')
            ]));
    }
}
