<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Dashboard - Divine Vines</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= $this->Url->assetUrl('favicon.ico') ?>" />
    <!-- Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400&family=Comfortaa:wght@300&display=swap" rel="stylesheet" />

    <!-- Core theme CSS (includes Bootstrap)-->
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->css(['admin.css','admin-table.css']) ?>



</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <div class="sidebar-header">
                <h3>Admin Dashboard</h3>
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <?= $this->Html->link(
                        '<i class="fas fa-home"></i> Homepage',
                        '/',
                        ['escape' => false]
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        '<i class="fas fa-tachometer-alt"></i> Dashboard',
                        '/admin',
                        ['escape' => false]
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        '<i class="bi bi-box-seam-fill"></i> Manage Products',
                        '/products',
                        ['escape' => false]
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        '<i class="fas fa-users"></i> Manage Customer Accounts',
                        '/users',
                        ['escape' => false]
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        '<i class="fas fa-envelope"></i> Customer Enquiries',
                        '/contact-enquiries',
                        ['escape' => false]
                    ) ?>
                </li>
                <li>
                    <?= $this->Html->link(
                        '<i class="fas fa-shopping-cart"></i> Orders',
                        '/orders/admin-index',
                        ['escape' => false]
                    ) ?>
                </li>
                <li class="sidebar-footer">
                    <?= $this->Html->link(
                        '<i class="fas fa-sign-out-alt"></i> Logout',
                        $this->Url->build('/auth/logout', ['fullBase' => true]),
                        ['escape' => false]
                    ) ?>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <h1><?= $this->fetch('title') ?></h1>
            </div>
            <div class="admin-content">
                <?= $this->fetch('content') ?>
            </div>
        </main>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <?= $this->Html->script('admin.js') ?>
</body>
</html>
