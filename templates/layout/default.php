<?php
use Cake\ORM\TableRegistry;

if ($this->Identity->isLoggedIn()) {
    $loggedIn = true;
    $userId = $this->Identity->getId();
    // Load the CartItems model
    $cartItemsTable = TableRegistry::getTableLocator()->get('CartItems');
    // Query the total quantity of items in the cart for the user
    $cartCount = $cartItemsTable->find()
        ->select(['total_quantity' => 'SUM(product_quantity)'])
        ->where(['user_id' => $userId])
        ->first()
        ->total_quantity ?? 0;
} else {
    $loggedIn = false;
    $cartCount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Divine Vines - Australian Wide Delivery</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $this->Url->assetUrl('favicon.ico') ?>" />
    <!-- Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css', ['block' => true]) ?>

    <!-- Font Awesome for custom hamburger icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&family=Comfortaa:wght@300&display=swap" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->css('default.css') ?>
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
</head>

<body>
<?php
$isHomePage = (
    $this->request->getParam('controller') === 'Pages' &&
    $this->request->getParam('action') === 'display' &&
    !empty($this->request->getParam('pass')) &&
    $this->request->getParam('pass')[0] === 'home'
);
$navbarClass = $isHomePage ? 'navbar navbar-expand-lg navbar-dark' : 'navbar navbar-expand-lg navbar-dark scrolled';
?>

<!-- Pop-up window -->
<?php if (isset($showAgePopup) && $showAgePopup): ?>
    <div class="popup-overlay">
        <div class="popup-container">
            <div class="popup-header"></div>
            <div class="popup-logo">Divine Vines</div>
            <div class="popup-content">
                <h3>Are you over 18 years old?</h3>
                <p>Please verify your age to enter this site.</p>
                <div class="popup-buttons">
                    <?php
                    $this->Form->setTemplates(['button' => '<button{{attrs}}>{{text}}</button>']);
                    echo $this->Form->create(null, ['url' => '/']);
                    echo $this->Form->button('I am over 18', ['type' => 'submit', 'name' => 'age_confirmed', 'value' => 'yes', 'class' => 'btn-over-18']);
                    echo $this->Form->button('I am under 18', ['type' => 'submit', 'name' => 'age_confirmed', 'value' => 'no', 'class' => 'btn-under-18']);
                    echo $this->Form->end();
                    ?>
                </div>
                <div class="terms-notice">
                    By proceeding, you are agreeing to our terms of use and privacy policy.
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($ageRestricted) && $ageRestricted): ?>
    <div class="popup-overlay">
        <div class="popup-container">
            <div class="popup-header"></div>
            <div class="popup-logo">Divine Vines</div>
            <div class="popup-content">
                <div class="restricted-message">
                    Sorry, you must be over 18 to enter this site.
                </div>
                <div class="popup-buttons">
                    <button onclick="window.location.href='https://www.google.com'" class="btn-under-18">Leave</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Search Sidebar -->
<div class="search-sidebar" id="search-sidebar">
    <div class="search-sidebar-header">
        <h3>Search Products</h3>
        <button class="search-sidebar-close" id="search-sidebar-close">×</button>
    </div>
    <div class="search-input-container">
        <input type="text" id="search-input" placeholder="Search products..." aria-label="Search">
    </div>
    <div class="search-suggestions" id="search-suggestions"></div>
    <div class="search-results" id="search-results"></div>
</div>

<!-- Navbar -->
<nav class="<?= $navbarClass ?>">
    <div class="container px-5">
        <div class="navbar-top">
            <button class="menu-toggle d-lg-none" aria-label="Toggle navigation">
                <svg class="hamburger-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 6H21V8H3V6ZM3 11H21V13H3V11ZM3 16H21V18H3V16Z" fill="#666666" style="fill: #666666 !important;"/>
                </svg>
                <span class="close-icon" style="color: #666666 !important;">×</span>
            </button>
            <a class="navbar-brand" href="#!">Divine Vines</a>
            <div class="navbar-icons-mobile d-lg-none">
                <a href="#!" class="nav-icon" id="search-toggle-mobile" aria-label="Search">
                    <span class="bi bi-search"></span>
                </a>
                <a href="<?= $this->Url->build('/cart-items/') ?>" class="nav-icon" aria-label="Shopping Cart">
                    <span class="bi bi-cart"></span>
                    <span class="cart-count"><?= $cartCount ?></span>
                </a>
            </div>
        </div>
        <div class="navbar-bottom">
            <div class="navbar-search">
                <a href="#!" class="nav-icon" id="search-toggle" aria-label="Search">
                    <span class="bi bi-search"></span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><?= $this->Html->link('Home', ['controller' => 'Pages', 'action' => 'display', 'home'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item"><?= $this->Html->link('Contact', ['controller' => 'ContactEnquiries', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                    <li class="nav-item"><?= $this->Html->link('Product', ['controller' => 'Products', 'action' => 'page'], ['class' => 'nav-link']) ?></li>
                </ul>
            </div>
            <div class="navbar-icons d-none d-lg-flex">
                <div class="dropdown">
                    <a href="#!" class="nav-icon dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User Profile">
                        <span class="bi bi-person"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <?php if ($loggedIn): ?>
                            <?php if ($this->Identity->get('user_type') === 'Admin'): ?>
                                <?= $this->Html->link('Admin Dashboard', ['controller' => 'Admin', 'action' => 'index'], ['class' => 'nav-link']) ?>
                            <?php endif; ?>
                            <?= $this->Html->link('My Orders', ['controller' => 'Orders', 'action' => 'index'], ['class' => 'nav-link']) ?>
                            <?= $this->Html->link('Logout', ['controller' => 'Auth', 'action' => 'logout'], ['class' => 'nav-link']) ?>
                        <?php else: ?>
                            <?= $this->Html->link('Login', ['controller' => 'Auth', 'action' => 'login'], ['class' => 'nav-link']) ?>
                            <?= $this->Html->link('Create Account', ['controller' => 'Auth', 'action' => 'register'], ['class' => 'nav-link']) ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <a href="<?= $this->Url->build('/cart-items/') ?>" class="nav-icon" aria-label="Shopping Cart">
                    <span class="bi bi-cart"></span>
                    <span class="cart-count"><?= $cartCount ?></span>
                </a>
            </div>
        </div>
        <div class="mobile-menu" id="mobileNavbarContent" style="display: none;">
            <ul class="navbar-nav">
                <li class="nav-item"><?= $this->Html->link('Home', ['controller' => 'Pages', 'action' => 'display', 'home'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link('About', ['controller' => 'Pages', 'action' => 'display', 'about'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link('Contact', ['controller' => 'ContactEnquiries', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
                <li class="nav-item"><?= $this->Html->link('Products', ['controller' => 'Products', 'action' => 'page'], ['class' => 'nav-link']) ?></li>
            </ul>
            <div class="navbar-login">
                <?php if ($loggedIn): ?>
                    <?php if ($this->Identity->get('user_type') === 'Admin'): ?>
                        <?= $this->Html->link(
                            '<span class="bi bi-speedometer2"></span> Admin Dashboard',
                            ['controller' => 'Admin', 'action' => 'index'],
                            ['class' => 'nav-icon-login', 'escape' => false]
                        ) ?>
                    <?php endif; ?>
                    <?= $this->Html->link(
                        '<span class="bi bi-box"></span> My Orders',
                        ['controller' => 'Orders', 'action' => 'index'],
                        ['class' => 'nav-icon-login', 'escape' => false]
                    ) ?>
                    <?= $this->Html->link(
                        '<span class="bi bi-person-x"></span> Logout',
                        ['controller' => 'Auth', 'action' => 'logout'],
                        ['class' => 'nav-icon-login', 'escape' => false]
                    ) ?>
                <?php else: ?>
                    <?= $this->Html->link(
                        '<span class="bi bi-person"></span> Login',
                        ['controller' => 'Auth', 'action' => 'login'],
                        ['class' => 'nav-icon-login', 'escape' => false]
                    ) ?>
                    <?= $this->Html->link(
                        '<span class="bi bi-person-plus"></span> Create Account',
                        ['controller' => 'Auth', 'action' => 'register'],
                        ['class' => 'nav-icon-login', 'escape' => false]
                    ) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<?= $this->fetch('content') ?>

<!-- Footer -->
<footer class="py-5 bg-dark text-white">
    <div class="container px-5">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="text-uppercase mb-4">Divine Vines</h5>
                <p class="small">Discover the finest selection of wines from around the world. Passionate about quality, flavor, and the art of winemaking.</p>
                <div class="social-icons mt-3">
                    <a href="#!" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                    <a href="#!" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#!" class="text-white"><i class="bi bi-twitter"></i></a>
                </div>
            </div>
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="text-uppercase mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#!" class="text-white-50">Home</a></li>
                    <li class="mb-2"><a href="#!" class="text-white-50">About Us</a></li>
                    <li class="mb-2"><a href="#!" class="text-white-50">Our Wines</a></li>
                    <li class="mb-2"><a href="#!" class="text-white-50">Services</a></li>
                    <li><a href="#!" class="text-white-50">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5 class="text-uppercase mb-4">Newsletter</h5>
                <p class="small mb-3">Stay updated with our latest selections and exclusive offers.</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Enter your email" aria-label="Email subscription">
                    <button class="btn btn-outline-light" type="button">Subscribe</button>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            <p class="m-0 small">© <?= date('Y') ?> Divine Vines. All Rights Reserved.</p>
            <div class="mt-2">
                <a href="#!" class="text-white-50 me-3 small">Privacy Policy</a>
                <a href="#!" class="text-white-50 me-3 small">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Core theme JS -->
<?= $this->Html->script('scripts.js') ?>
<?= $this->Html->script('cart.js') ?>
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
<script>
    const IS_HOME = <?= $isHomePage ? 'true' : 'false' ?>;
</script>
</body>
</html>
