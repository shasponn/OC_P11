<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <!--LIBS FANCYBOX-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <!--JQUERY-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div id="page" class="site">

        <header id="masthead" class="site_header">
            <nav id="site-navigation" class="main-navigation">

                <div class="site-logo">
                    <?php
                    if (function_exists('the_custom_logo')) {
                        the_custom_logo();
                    }
                    ?>
                </div>

                <div class="menu_container">
                    <div class="btnburgernmenu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <?php wp_nav_menu([
                        'theme_location' => 'header',
                        'container' => false,
                        'menu' => 'header'
                    ]) ?>
                </div>

            </nav><!-- #site-navigation -->

            <?php include_once "templates/menuburger.php"; ?>
            <?php include_once "templates/modal.php"; ?>
        </header><!-- #masthead -->
    </div><!-- #page -->