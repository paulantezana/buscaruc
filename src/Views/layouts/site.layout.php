<?php
$siteTitle = isset($parameter['siteTitle']) ? ($parameter['siteTitle'] . ' | ' . APP_NAME) : APP_NAME;
$siteDescription = isset($parameter['siteDescription']) ? $parameter['siteDescription'] : APP_DESCRIPTION;
$sitePoster = URL_PATH . (isset($parameter['sitePoster']) ? $parameter['sitePoster'] : '/assets/images/icon/144.png');
?>

<!DOCTYPE html>
<html lang="es" prefix="og: http://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $siteTitle ?></title>
    <meta name="description" content="<?= $siteDescription ?>">
    <link rel="shortcut icon" href="<?= URL_PATH ?>/assets/images/icon/144.png">

    <?php require_once(__DIR__ . '/manifest.partial.php') ?>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/sedna.css">
    <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/customBootstrap.css">
    <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/fontawesome.css">
    <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/nprogress.css">
    <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/toastr.min.css">
    <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= URL_PATH ?>/assets/css/public.css">

    <script src="<?= URL_PATH ?>/assets/script/helpers/sedna.js"></script>
    <script src="<?= URL_PATH ?>/assets/script/helpers/nprogress.js"></script>
    <script src="<?= URL_PATH ?>/assets/script/helpers/jquery.min.js"></script>
    <script src="<?= URL_PATH ?>/assets/script/helpers/bootstrap.bundle.min.js"></script>
    <script src="<?= URL_PATH ?>/assets/script/helpers/toastr.min.js"></script>
    <script src="<?= URL_PATH ?>/assets/script/helpers/conmon.js"></script>
</head>

<body>
    <div id="userSessionId" style="display: none"><?php echo (isset($_SESSION[SESS_KEY])) ? $_SESSION[SESS_KEY] : '0' ?></div>
    <div class="SiteLayout" id="SiteLayout">
        <div class="SiteLayout-header">
            <header class="SiteHeader">
                <div class="SiteHeader-left">
                    <div class="SiteBranding">
                        <a href="<?= URL_PATH ?>">
                            <img src="<?= URL_PATH ?>/assets/images/icon/144.png" alt="logo">
                        </a>
                    </div>
                    <div class="SiteWelcome">
                        Bienvenido a <?= APP_NAME ?>
                    </div>
                </div>
                <div class="SiteHeader-right">

                    <div id="SiteMenu-toggle"><i class="fas fa-bars"></i></div>
                    <nav class="SiteMenu-wrapper" id="SiteMenu-wrapper" itemscope itemtype="http://schema.org/SiteNavigationElement" role="navigation">
                        <div class="SiteMenu-content">
                            <div class="SiteMenu-header">
                                <div class="SiteBranding">
                                    <a href="<?= URL_PATH ?>">
                                        <img src="<?= URL_PATH ?>/assets/images/icon/144.png" alt="logo">
                                    </a>
                                </div>
                            </div>
                            <ul class="SiteMenu" id="SiteMenu">
                                <?php if (isset($_SESSION[SESS_KEY])) : ?>
                                    <li itemprop="url">
                                        <a itemprop="name" title="Mi perfil" href="<?php echo URL_PATH  . '/user/profile/' . $_SESSION[SESS_USER]['user_name'] ?>"><i class="fas fa-user mr-2"></i>Mi Perfil</a>
                                    </li>
                                    <?php if (isset($_SESSION[SESS_USER]) && $_SESSION[SESS_USER]['user_role_id'] == '2') : ?>
                                        <li itemprop="url"><a itemprop="name" title="Administrador" href="<?= URL_PATH . '/admin' ?>"><i class="fas fa-users-cog mr-2"></i>Administrador</a></li>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <li itemprop="url"><a itemprop="name" title="Precios" href="#">Precios</a></li>
                                <?php endif; ?>
                            </ul>
                            <div class="SiteMenu-footer">
                                <?php if (!isset($_SESSION[SESS_KEY])) : ?>
                                    <a itemprop="name" title="Ingresar" href="<?= URL_PATH ?>/page/login" class="toLogin btn btn-light">Ingresar</a>
                                    <a itemprop="name" title="Registrarse" href="<?= URL_PATH ?>/page/register" class="toRegister btn btn-primary">Registrarse</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </nav>

                </div>
            </header>
        </div>
        <div class="SiteLayout-main">
            <?php echo $content ?>
        </div>
        <div class="SiteLayout-footer">
            
        </div>
        <script src="<?= URL_PATH ?>/assets/script/siteLayout.js"></script>
    </div>
</body>

</html>