<?php
    $siteTitle = isset($parameter['siteTitle']) ? (APP_NAME . ' - ' .  $parameter['siteTitle']) : APP_NAME;
    $siteDescription = isset($parameter['siteDescription']) ? $parameter['siteDescription'] : APP_DESCRIPTION;
    $sitePoster = URL_PATH . (isset($parameter['sitePoster']) ? $parameter['sitePoster'] : '/assets/images/icon/144.png');
?>

<!DOCTYPE html>
<html lang="es" prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= APP_NAME ?></title>
        <meta name="description" content="<?= APP_DESCRIPTION ?>">
        <link rel="shortcut icon" href="<?= URL_PATH ?>/assets/images/icon/144.png">

        <?php require_once(__DIR__ . '/manifest.partial.php') ?>

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/sedna.css">
        <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/customBootstrap.css">
        <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/fontawesome.css">
        <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/nprogress.css">
        <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/toastr.min.css">
        <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/select2.min.css">
        <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/style.css">
        <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/admin.css">

        <script src="<?= URL_PATH ?>/assets/script/helpers/sedna.js"></script>
        <script src="<?= URL_PATH ?>/assets/script/helpers/pristine.min.js"></script>
        <script src="<?= URL_PATH ?>/assets/script/helpers/nprogress.js"></script>
        <script src="<?= URL_PATH ?>/assets/script/helpers/jquery.min.js"></script>
        <script src="<?= URL_PATH ?>/assets/script/helpers/jquery.PrintArea.js"></script>
        <script src="<?= URL_PATH ?>/assets/script/helpers/bootstrap.bundle.min.js"></script>
        <script src="<?= URL_PATH ?>/assets/script/helpers/toastr.min.js"></script>
        <script src="<?= URL_PATH ?>/assets/script/helpers/conmon.js"></script>
    </head>
    <body>
        <div class="AdminLayout AdminLayoutL2" id="AdminLayout">
            <div class="AdminLayout-header">
                <header class="navbar navbar-expand-sm AdminHeader">
                    <div id="AdminSidebar-toggle" class="AdminHeader-action">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="ml-auto d-flex align-items-center">
                        <div>
                        </div>
                        <div class="nav-item dropdown">
                            <a class="nav-link" href="#" id="UserDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-right: 0">
                                <img src="<?= URL_PATH . '/assets/images/icon/144.png' ?>" alt="avatar" width="32px">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="UserDropdown">
                                <a class="dropdown-item" href="<?= URL_PATH  . '/user/update/' . $_SESSION[SESS_KEY] ?>"><i class="fas fa-user-edit mr-2"></i>Mi Perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= URL_PATH ?>"><i class="fas fa-cog mr-2"></i>Home</a>
                                <a class="dropdown-item" href="<?= URL_PATH . '/page/logout' ?>"><i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            <div class="AdminLayout-main">
                <?php echo $content ?>
            </div>
            <aside class="AdminLayout-sidebar AdminSidebar-wrapper" id="AdminSidebar">
                <div class="AdminSidebar-content">
                    <div class="AdminSidebar-brand">
                        <a href="<?= URL_PATH ?>/admin">
                            <img src="<?= URL_PATH . '/assets/images/icon/144.png' ?>" alt="logo" width="48px" class="mr-2">
                            <span class="AdminSidebar-brandName"><?= APP_NAME ?><span><?= APP_DESCRIPTION ?></span></span>
                        </a>
                    </div>
                    <div class="AdminSidebar-header">

                    </div>
                    <ul class="AdminSidebar-menu">
                        <li class="AdminSidebar-title">General</li>

                        <?php if (menuIsAuthorized('home')) : ?>
                            <li>
                                <a href="<?= URL_PATH ?>/admin"><i class="fas fa-tachometer-alt AsideMenu-icon"></i><span>Inicio</span> </a>
                            </li>
                        <?php endif; ?>
                        <?php if (menuIsAuthorized('home')) : ?>
                            <li>
                                <a href="<?= URL_PATH ?>/admin/census"><i class="fas fa-barcode AsideMenu-icon"></i><span>Padron RUC</span> </a>
                            </li>
                        <?php endif; ?>
                        <?php if (menuIsAuthorized('usuario')) : ?>
                            <li>
                                <a href="<?= URL_PATH ?>/admin/user"><i class="fas fa-user AsideMenu-icon"></i><span>Usuarios</span></a>
                            </li>
                        <?php endif; ?>
                        <?php if (menuIsAuthorized('rol')) : ?>
                            <li>
                                <a href="<?= URL_PATH ?>/admin/appAuthorization"><i class="fas fa-user-tag AsideMenu-icon"></i><span>Roles</span></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </aside>
            <script src="<?= URL_PATH ?>/assets/script/adminLayout.js"></script>
        </div>
    </body>
</html>
