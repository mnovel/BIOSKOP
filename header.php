<?php
include "koneksi.php";

if (empty($_SESSION['login']['status']) || $_SESSION['login']['role'] != 1) {
    setcookie('alert', 'error|Silahkan login dulu', time() + 3, '/');
    header('Location: ' . BASE_URL);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= MENU_TITLE ?> &rsaquo; GA.Tix</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/chocolat/dist/css/chocolat.css">

    <?php
    if (preg_match('/jam tayang/i', MENU_TITLE)) {
    ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/bootstrap-daterangepicker/daterangepicker.css">
    <?php
    }
    ?>
    <?php
    if (preg_match('/studio/i', MENU_TITLE)) {
    ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/datatables/datatables.min.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <?php
    }
    ?>
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/css/components.css">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                        <div class="search-result">
                            <div class="search-header">
                                Histories
                            </div>
                            <div class="search-item">
                                <a href="#">How to hack NASA using CSS</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-item">
                                <a href="#">Kodinger.com</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-item">
                                <a href="#">#Stisla</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-header">
                                Result
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30" src="<?= BASE_URL ?>template/assets/img/products/product-3-50.png" alt="product">
                                    oPhone S9 Limited Edition
                                </a>
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30" src="<?= BASE_URL ?>template/assets/img/products/product-2-50.png" alt="product">
                                    Drone X2 New Gen-7
                                </a>
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30" src="<?= BASE_URL ?>template/assets/img/products/product-1-50.png" alt="product">
                                    Headphone Blitz
                                </a>
                            </div>
                            <div class="search-header">
                                Projects
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <div class="search-icon bg-danger text-white mr-3">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    Stisla Admin Template
                                </a>
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <div class="search-icon bg-primary text-white mr-3">
                                        <i class="fas fa-laptop"></i>
                                    </div>
                                    Create a new Homepage Design
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-message">
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?= BASE_URL ?>template/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= ucwords($_SESSION['login']['username']) ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= BASE_URL ?>proses/logout" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">GA.Tix</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">St</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Menu</li>
                        <li class="<?= preg_match('/dashboard/i', MENU_TITLE) ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= BASE_URL ?>admin/dashboard">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="dropdown <?= preg_match('/film/i', MENU_TITLE) ? 'active' : '' ?>">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                                <i class="fas fa-video"></i>
                                <span>Film</span></a>
                            <ul class="dropdown-menu">
                                <li class="<?= preg_match('/tambah/i', MENU_TITLE) ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= BASE_URL ?>admin/tambah-film">Tambah</a>
                                </li>
                                <li class="<?= preg_match('/list/i', MENU_TITLE) ? 'active' : '' ?>">
                                    <a class="nav-link" href="<?= BASE_URL ?>admin/list-film">List</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?= preg_match('/jam tayang/i', MENU_TITLE) ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= BASE_URL ?>admin/jam-tayang">
                                <i class="fas fa-calendar-check"></i>
                                <span>Jam Tayang</span>
                            </a>
                        </li>
                        <li class="<?= preg_match('/studio/i', MENU_TITLE) ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= BASE_URL ?>admin/studio">
                                <i class="fas fa-couch"></i>
                                <span>Studio</span>
                            </a>
                        </li>
                    </ul>

                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini d-none">
                        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                            <i class="fas fa-rocket"></i> Documentation
                        </a>
                    </div>
                </aside>
            </div>

            <!-- Main Content -->