<?= $this->Html->css('styles', ['block' => true]) ?>
<!-- Header Section -->
<header class="page-header"></header>

<div class="products-container">
    <!-- Header Image Section -->
    <div class="header-image">
        <img src="https://images.unsplash.com/photo-1519671282429-b44660ead0a7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1380&h=200&q=80" alt="Wine Shop Header">
    </div>

    <!-- Sticky Filter Container -->
    <div class="sticky-filter-container">
        <!-- Combined Header Section -->
        <div class="header-controls">
            <div class="filter-toggle">
                <button id="toggle-filters">
                    <span class="filter-icon"></span>
                    <span id="toggle-text">Hide filters</span>
                </button>
                <p><?= count($products) ?> Results</p>
            </div>
            <div class="sort">
                <span class="sort-label">Sort:</span>
                <select onchange="location = this.value;">
                    <option value="<?= $this->Url->build(['?' => array_merge($this->request->getQuery(), ['sort' => null])]) ?>" <?= !$this->request->getQuery('sort') ? 'selected' : '' ?>>Default</option>
                    <option value="<?= $this->Url->build(['?' => array_merge($this->request->getQuery(), ['sort' => 'price_low_high'])]) ?>" <?= $this->request->getQuery('sort') === 'price_low_high' ? 'selected' : '' ?>>Price: Low to High</option>
                    <option value="<?= $this->Url->build(['?' => array_merge($this->request->getQuery(), ['sort' => 'price_high_low'])]) ?>" <?= $this->request->getQuery('sort') === 'price_high_low' ? 'selected' : '' ?>>Price: High to Low</option>
                    <option value="<?= $this->Url->build(['?' => array_merge($this->request->getQuery(), ['sort' => 'created_at_asc'])]) ?>" <?= $this->request->getQuery('sort') === 'created_at_asc' ? 'selected' : '' ?>>Old to New</option>
                    <option value="<?= $this->Url->build(['?' => array_merge($this->request->getQuery(), ['sort' => 'created_at_desc'])]) ?>" <?= $this->request->getQuery('sort') === 'created_at_desc' ? 'selected' : '' ?>>New to Old</option>
                    <option value="<?= $this->Url->build(['?' => array_merge($this->request->getQuery(), ['sort' => 'name_asc'])]) ?>" <?= $this->request->getQuery('sort') === 'name_asc' ? 'selected' : '' ?>>A-Z</option>
                    <option value="<?= $this->Url->build(['?' => array_merge($this->request->getQuery(), ['sort' => 'name_desc'])]) ?>" <?= $this->request->getQuery('sort') === 'name_desc' ? 'selected' : '' ?>>Z-A</option>
                </select>
            </div>
        </div>

        <!-- Selected Filters -->
        <div class="selected-filters">
            <div id="filter-bubbles"></div>
            <button id="clear-all" style="display: none;" onclick="location.href='<?= $this->Url->build(['action' => 'clearAllFilters']) ?>'">Clear All</button>
        </div>
    </div>

    <!-- Combined Sidebar and Main Content -->
    <div class="content-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <!-- Price Filter -->
            <div class="filter-group">
                <div class="filter-title" onclick="toggleDropdown('price-options')">
                    <h3>Price</h3>
                    <span class="arrow"></span>
                </div>
                <div id="price-options" class="filter-options">
                    <?php foreach ($allPrices as $price): ?>
                        <label class="option <?= in_array($price['value'], $availablePrices) ? '' : 'unavailable' ?>">
                            <input type="checkbox" name="Price" value="<?= h($price['value']) ?>" onchange="applyFilter('Price', this)" <?= in_array($price['value'], $this->request->getQuery('price', [])) ? 'checked' : '' ?>> <?= h($price['label']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Variety Filter -->
            <div class="filter-group">
                <div class="filter-title" onclick="toggleDropdown('variety-options')">
                    <h3>Variety</h3>
                    <span class="arrow"></span>
                </div>
                <div id="variety-options" class="filter-options">
                    <?php foreach ($allStyles as $style): ?>
                        <label class="option <?= in_array($style->style, $availableStyles) ? '' : 'unavailable' ?>">
                            <input type="checkbox" name="Variety" value="<?= h($style->style) ?>" onchange="applyFilter('Variety', this)" <?= in_array($style->style, $this->request->getQuery('style', [])) ? 'checked' : '' ?>> <?= h($style->style) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Region Filter -->
            <div class="filter-group">
                <div class="filter-title" onclick="toggleDropdown('region-options')">
                    <h3>Region</h3>
                    <span class="arrow"></span>
                </div>
                <div id="region-options" class="filter-options">
                    <?php foreach ($allRegions as $region): ?>
                        <label class="option <?= in_array($region->region, $availableRegions) ? '' : 'unavailable' ?>">
                            <input type="checkbox" name="Region" value="<?= h($region->region) ?>" onchange="applyFilter('Region', this)" <?= in_array($region->region, $this->request->getQuery('region', [])) ? 'checked' : '' ?>> <?= h($region->region) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Vintage Filter -->
            <div class="filter-group">
                <div class="filter-title" onclick="toggleDropdown('vintage-options')">
                    <h3>Vintage</h3>
                    <span class="arrow"></span>
                </div>
                <div id="vintage-options" class="filter-options">
                    <?php foreach ($allVintages as $vintage): ?>
                        <label class="option <?= in_array($vintage->vintage, $availableVintages) ? '' : 'unavailable' ?>">
                            <input type="checkbox" name="Vintage" value="<?= h($vintage->vintage) ?>" onchange="applyFilter('Vintage', this)" <?= in_array($vintage->vintage, $this->request->getQuery('vintage', [])) ? 'checked' : '' ?>> <?= h($vintage->vintage) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <?php if ($this->Identity->isLoggedIn()): ?>
                <div class="alert alert-dismissible fade show" role="alert">
                    <?= $this->Flash->render('add2CartFeedback');?>
                </div>
            <?php endif; ?>
            <!-- Product Grid -->
            <div class="product-grid" id="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card" data-product-id="<?= h($product->id) ?>">
                        <div class="image-container">
                            <?php if (!empty($product->image)): ?>
                                <?= $this->Html->link(
                                    $this->Html->image($product->image, ['alt' => h($product->name)]),
                                    ['action' => 'view', $product->id],
                                    ['escape' => false, 'class' => 'product-image-link']
                                ) ?>
                            <?php else: ?>
                                <?= $this->Html->link(
                                    $this->Html->image('sample.jpg', ['alt' => h($product->name), 'class' => 'product-image blurred']),
                                    ['action' => 'view', $product->id],
                                    ['escape' => false, 'class' => 'product-image-link']
                                ) ?>
                                <div class="no-image-overlay">No image available</div>
                            <?php endif; ?>
                            <?php if ($product->stock_quantity == 0): ?>
                                <div class="out-of-stock-label">Out of Stock</div>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name"><?= h($product->name) ?></h3>
                            <div class="product-price">$<?= number_format($product->price, 2) ?></div>
                            <div class="quick-view-container">
                                <button class="quick-view-btn" onclick="openQuickView(<?= h($product->id) ?>)">Quick View</button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick View Modal -->
                    <div id="quick-view-modal-<?= h($product->id) ?>" class="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="quick-view-modal-label-<?= h($product->id) ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="quick-view-modal-label-<?= h($product->id) ?>">
                                        <?= h($product->name) ?>
                                    </h5>
                                    <button type="button" class="close" onclick="closeQuickView(<?= h($product->id) ?>)" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?= $this->element('Products/quick_view', ['product' => $product]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Product Counter -->
            <div class="product-footer">
                <div class="product-counter" id="product-counter">
                    You're viewing <?= count($products) ?> of <?= $totalCount ?> products
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body, p, a, span, div, .navbar, .nav-link, .navbar-brand {
        font-family: 'Comfortaa', sans-serif !important;
        font-weight: 300 !important;
    }

    /* Exclude navigation links from global font size */
    .navbar-nav .nav-link {
        font-size: 16px !important;
        font-family: 'Comfortaa', sans-serif !important;
        font-weight: 300 !important;
    }

    body {
        min-height: 100vh;
        overflow-y: auto;
        padding-top: 60px; /* Add padding to account for fixed navbar */
    }

    .products-container {
        max-width: 1380px;
        margin: 0 auto;
        padding: 30px 30px;
        position: relative;
    }

    .header-image {
        width: 100%;
        max-width: 1380px;
        margin: 0 auto 20px auto;
    }

    .header-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .sticky-filter-container {
        position: sticky;
        top: 60px; /* Changed from 60px to 120px to account for navbar height */
        z-index: 1;
        background-color: rgba(255, 255, 255, 0.9);
        width: 100%;
        max-width: 1380px;
        padding: 10px 0;
    }

    .header-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin-bottom: 10px;
        height: 40px;
    }

    .filter-toggle {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-toggle p {
        margin: 0;
        font-size: 14px;
    }

    .filter-toggle button {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 8px 12px;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        color: #333;
        cursor: pointer;
        transition: border-color 0.2s ease, background-color 0.2s ease, color 0.2s ease;
    }

    .filter-toggle button:hover {
        border-color: #b12704;
        background-color: #fff;
        color: #b12704;
    }

    .filter-icon {
        width: 14px;
        height: 14px;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="%23333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="6" r="2"/><line x1="0" y1="6" x2="3" y2="6"/><line x1="7" y1="6" x2="24" y2="6"/><circle cx="5" cy="14" r="2"/><line x1="0" y1="14" x2="3" y2="14"/><line x1="7" y1="14" x2="24" y2="14"/></svg>');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    .filter-toggle button:hover .filter-icon {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="%23b12704" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="6" r="2"/><line x1="0" y1="6" x2="3" y2="6"/><line x1="7" y1="6" x2="24" y2="6"/><circle cx="5" cy="14" r="2"/><line x1="0" y1="14" x2="3" y2="14"/><line x1="7" y1="14" x2="24" y2="14"/></svg>');
    }

    .sort {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sort-label {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        color: #333;
    }

    .sort select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 8px 30px 8px 12px;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        color: #333;
        cursor: pointer;
        transition: border-color 0.2s ease, background-color 0.2s ease;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="%23333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    .sort select:hover {
        border-color: #b12704;
        background-color: #fff;
    }

    .sort select:focus {
        outline: none;
        border-color: #b12704;
        box-shadow: 0 0 0 2px rgba(177, 39, 4, 0.1);
    }

    .selected-filters {
        width: 100%;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    #filter-bubbles {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-bubble {
        display: inline-flex;
        align-items: center;
        background: #e0e0e0;
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 14px;
        gap: 5px;
    }

    .remove-filter {
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
        padding: 0 2px;
        transition: color 0.2s ease;
    }

    .remove-filter:hover {
        color: #b12704;
    }

    #clear-all {
        background: transparent;
        border: 1px solid #b12704;
        color: #b12704;
        padding: 5px 10px;
        border-radius: 20px;
        cursor: pointer;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    #clear-all:hover {
        background: #b12704;
        color: white;
    }

    .content-wrapper {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        width: 100%;
        min-height: 100vh;
    }

    .sidebar {
        flex: 0 0 20%;
        padding-right: 20px;
        background: rgba(255, 255, 255, 0.9);
        border-right: 1px solid #eee;
        position: sticky;
        top: 110px;
        z-index: 1;
        align-self: flex-start;
        min-height: 300px;
    }

    .sidebar h3 {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 15px;
        margin: 0;
        color: #333;
    }

    .filter-group {
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .filter-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        padding: 10px 12px;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 15px;
        color: #333;
        transition: color 0.2s ease;
    }

    .filter-title:hover {
        color: #b12704;
    }

    .arrow {
        width: 12px;
        height: 12px;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="%23666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        transition: transform 0.3s ease;
    }

    .filter-title:hover .arrow {
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="%23b12704" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
    }

    .filter-title.open .arrow {
        transform: rotate(180deg);
    }

    .filter-options {
        display: none;
        background: #fff;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 4px 4px;
        margin-top: -1px;
        padding: 8px 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .option {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        cursor: pointer;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        color: #333;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .option:hover {
        background: #f9f9f9;
        color: #b12704;
    }

    .option input[type="checkbox"] {
        margin-right: 8px;
        accent-color: #b12704;
        cursor: pointer;
    }

    .option.unavailable {
        color: #999;
        opacity: 0.6;
    }

    .option.unavailable:hover {
        background: #f9f9f9;
        color: #b12704;
        opacity: 1;
    }

    .option.unavailable input[type="checkbox"] {
        accent-color: #999;
    }

    .option.unavailable input[type="checkbox"]:checked {
        accent-color: #b12704;
    }

    .main-content {
        flex: 0 0 80%;
        transition: flex 0.3s ease;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, 250px);
        gap: 15px;
    }

    .product-card {
        flex: 0 0 250px;
        width: 250px;
        text-align: center;
        position: relative;
        transition: all 0.2s ease;
        border: 2px solid transparent;
        overflow: visible;
    }

    .product-card .image-container {
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 10px;
        width: 100%;
        height: 300px;
        position: relative;
    }

    .product-card img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card:hover {
        border: 2px solid rgba(0, 0, 0, 0.05);
    }

    .out-of-stock-label {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 0, 0, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 12px;
    }

    .product-info {
        padding: 10px;
        background: white;
        text-align: center;
        position: relative;
    }

    .product-name {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        margin: 10px 0;
    }

    .product-price {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 16px;
    }

    .quick-view-container {
        position: absolute;
        top: -40px;
        left: 0;
        right: 0;
        opacity: 0;
        transition: opacity 0.2s ease;
        padding: 0 10px;
        z-index: 2;
    }

    .product-card:hover .quick-view-container {
        opacity: 1;
    }

    .quick-view-btn {
        width: 100%;
        padding: 10px 20px;
        background-color: #f9f9f9;
        color: #333;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .quick-view-btn:hover {
        background-color: #fff;
        border-color: #b12704;
        color: #b12704;
    }

    .no-image {
        width: 100%;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f9f9;
        border-radius: 4px;
        color: #666;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
    }

    .product-image-link {
        display: block;
        width: 100%;
        height: 100%;
        overflow: hidden;
        border-radius: 4px;
    }

    .product-image-link img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-image-link:hover img {
        transform: scale(1.05);
    }

    .product-footer {
        text-align: center;
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .product-counter {
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        color: #333;
    }

    .product-image.blurred {
        filter: blur(5px);
        transform: scale(1.1);
        transition: filter 0.3s ease, transform 0.3s ease;
    }

    .product-card:hover .product-image.blurred {
        filter: blur(5px);
        transform: scale(1.1);
    }

    .no-image-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        font-family: 'Comfortaa', sans-serif;
        font-weight: 300;
        font-size: 14px;
        z-index: 1;
    }

    .quick-view-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog {
        margin: 1.75rem auto;
        max-width: 800px;
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        border-radius: 0.3rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .close {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        opacity: 0.5;
        background: none;
        border: 0;
        padding: 0;
        cursor: pointer;
    }

    .close:hover {
        opacity: 0.75;
    }

</style>

<?= $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js', ['block' => true]) ?>
<script>
    let activeFilters = {
        Price: [],
        Variety: [],
        Region: [],
        Vintage: []
    };
    let filtersVisible = true;
    const csrfToken = <?= json_encode($this->request->getAttribute('csrfToken')) ?>;

    function toggleDropdown(id) {
        const options = document.getElementById(id);
        const filterTitle = options.previousElementSibling;
        const isVisible = options.style.display === 'block';
        options.style.display = isVisible ? 'none' : 'block';
        if (isVisible) {
            filterTitle.classList.remove('open');
        } else {
            filterTitle.classList.add('open');
        }
    }

    function toggleFilters() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleText = document.getElementById('toggle-text');
        filtersVisible = !filtersVisible;
        if (filtersVisible) {
            sidebar.style.display = 'block';
            mainContent.style.flex = '0 0 80%';
            toggleText.textContent = 'Hide filters';
        } else {
            sidebar.style.display = 'none';
            mainContent.style.flex = '0 0 100%';
            toggleText.textContent = 'Filters';
        }
        updateSidebarPosition();
    }

    function applyFilter(filterName, checkbox) {
        const value = checkbox.value;
        const isChecked = checkbox.checked;

        if (isChecked) {
            if (!activeFilters[filterName].includes(value)) {
                activeFilters[filterName].push(value);
            }
        } else {
            activeFilters[filterName] = activeFilters[filterName].filter(v => v !== value);
        }

        let queryParams = {};
        for (const [name, values] of Object.entries(activeFilters)) {
            if (values.length > 0) {
                switch (name.toLowerCase()) {
                    case 'price':
                        queryParams['price'] = values;
                        break;
                    case 'variety':
                        queryParams['style'] = values;
                        break;
                    case 'region':
                        queryParams['region'] = values;
                        break;
                    case 'vintage':
                        queryParams['vintage'] = values;
                        break;
                }
            }
        }

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('sort')) {
            queryParams['sort'] = urlParams.get('sort');
        }

        const queryString = new URLSearchParams();
        for (const [key, value] of Object.entries(queryParams)) {
            if (Array.isArray(value)) {
                value.forEach(val => queryString.append(key + '[]', val));
            } else {
                queryString.append(key, value);
            }
        }

        location.href = '/products/page' + (queryString.toString() ? '?' + queryString.toString() : '');
    }

    function removeFilter(filterName, filterValue) {
        activeFilters[filterName] = activeFilters[filterName].filter(v => v !== filterValue);

        let queryParams = {};
        for (const [name, values] of Object.entries(activeFilters)) {
            if (values.length > 0) {
                switch (name.toLowerCase()) {
                    case 'price':
                        queryParams['price'] = values;
                        break;
                    case 'variety':
                        queryParams['style'] = values;
                        break;
                    case 'region':
                        queryParams['region'] = values;
                        break;
                    case 'vintage':
                        queryParams['vintage'] = values;
                        break;
                }
            }
        }

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('sort')) {
            queryParams['sort'] = urlParams.get('sort');
        }

        const queryString = new URLSearchParams();
        for (const [key, value] of Object.entries(queryParams)) {
            if (Array.isArray(value)) {
                value.forEach(val => queryString.append(key + '[]', val));
            } else {
                queryString.append(key, value);
            }
        }

        location.href = '/products/page' + (queryString.toString() ? '?' + queryString.toString() : '');
    }

    function updateFilterBubbles() {
        const filterBubbles = document.getElementById('filter-bubbles');
        const clearAllButton = document.getElementById('clear-all');
        filterBubbles.innerHTML = '';
        let hasFilters = false;

        for (const [filterName, values] of Object.entries(activeFilters)) {
            values.forEach(value => {
                let displayValue = value;
                if (filterName === 'Price') {
                    displayValue = value === '0_50' ? '$0 - $50' : value === '50_100' ? '$50 - $100' : value === '100_plus' ? '$100+' : value;
                }
                const bubble = document.createElement('div');
                bubble.className = 'filter-bubble';
                bubble.innerHTML = `${filterName}: ${displayValue} <span class="remove-filter" onclick="removeFilter('${filterName}', '${value}')">×</span>`;
                filterBubbles.appendChild(bubble);
                hasFilters = true;
            });
        }

        clearAllButton.style.display = hasFilters ? 'inline-block' : 'none';
        updateSidebarPosition();
    }

    function updateSidebarPosition() {
        const stickyFilterContainer = document.querySelector('.sticky-filter-container');
        const sidebar = document.getElementById('sidebar');
        const navbarHeight = 60;
        if (stickyFilterContainer && sidebar) {
            const stickyHeight = stickyFilterContainer.offsetHeight;
            const newTop = navbarHeight + stickyHeight;
            sidebar.style.top = `${newTop}px`;
        }
    }

    function updateProductCounter() {
        console.log('Updating counter: displayed=', displayedProducts, 'total=', totalProducts);
        const counter = document.getElementById('product-counter');
        if (counter) {
            counter.textContent = `You're viewing ${displayedProducts} of ${totalProducts} products`;
        } else {
            console.error('Product counter not found');
        }
    }

    function openQuickView(productId) {
        const modal = document.getElementById(`quick-view-modal-${productId}`);
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';

            // No need to initialize form event listeners for the modal
            // The form will submit normally
        }
    }

    function closeQuickView(productId) {
        const modal = document.getElementById(`quick-view-modal-${productId}`);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('quick-view-modal')) {
            const productId = event.target.id.split('-').pop();
            closeQuickView(productId);
        }
    }

    // Function to initialize add to cart forms
    function initializeAddToCartForms() {
        // No need to add event listeners for form submission
        // The forms will submit normally
    }

    // Initialize add to cart forms when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        activeFilters = {
            Price: [],
            Variety: [],
            Region: [],
            Vintage: []
        };

        <?php
        $queryParams = $this->request->getQueryParams();
        if (isset($queryParams['price'])) {
            $prices = is_array($queryParams['price']) ? $queryParams['price'] : [$queryParams['price']];
            foreach ($prices as $price) {
                $displayPrice = $price === '0_50' ? '$0 - $50' : ($price === '50_100' ? '$50 - $100' : ($price === '100_plus' ? '$100+' : h($price)));
                echo "activeFilters['Price'].push('$price');";
            }
        }
        if (isset($queryParams['style'])) {
            $styles = is_array($queryParams['style']) ? $queryParams['style'] : [$queryParams['style']];
            foreach ($styles as $style) {
                echo "activeFilters['Variety'].push('" . h($style) . "');";
            }
        }
        if (isset($queryParams['region'])) {
            $regions = is_array($queryParams['region']) ? $queryParams['region'] : [$queryParams['region']];
            foreach ($regions as $region) {
                echo "activeFilters['Region'].push('" . h($region) . "');";
            }
        }
        if (isset($queryParams['vintage'])) {
            $vintages = is_array($queryParams['vintage']) ? $queryParams['vintage'] : [$queryParams['vintage']];
            foreach ($vintages as $vintage) {
                echo "activeFilters['Vintage'].push('" . h($vintage) . "');";
            }
        }
        ?>

        updateFilterBubbles();
        document.getElementById('toggle-filters').addEventListener('click', toggleFilters);
        updateSidebarPosition();
        window.addEventListener('resize', updateSidebarPosition);
        initializeAddToCartForms();
    });
</script>

