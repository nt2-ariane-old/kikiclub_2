<html>

<head>

    <?php
    do_action('alphaecm_action_before_wp_head');
    wp_head();
    do_action('alphaecm_action_after_wp_head');
    ?>

</head>

<body>
    <header class="<?php echo esc_attr($header_classes); ?>" role="banner">
        <div class="header-content">
            <div class="header-banner">

                <div class="color-overlay"></div>
                <a href='/' class="logo-wrapper">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $custom_logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');

                    echo '<img src="' . esc_url($custom_logo_url) . '" alt="">';
                    ?>
                </a>
                <figure class="thumbnail">
                    <?php the_custom_header_markup(); ?>
                </figure>
                <div class="inner-banner">
                    <h1 id="banner-title"><?php bloginfo('name'); ?></h1>
                    <h2 id="banner-slogan"><?php bloginfo('description'); ?></h2>
                </div>
            </div>

        </div>
    </header>
    <nav id="topnav">
        <button id='bars-btn'>
            <i class="fas fa-bars"></i>
        </button>
        <?php wp_nav_menu(array('theme_location' => 'main-menu', 'container_class' => 'navbar')); ?>
    </nav>
    <main>
        <div class="container">