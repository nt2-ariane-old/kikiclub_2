<?php
//Ajouts des menus
function register_my_menus()
{
    register_nav_menus(
        array(
            'main-menu' => __('Principal'),
            'pieds_page' => __('Pieds de Page'),
        )
    );
}
add_action('init', 'register_my_menus');

function alphaecm_setup()
{
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width' => true,
    ));
    add_theme_support('custom-header');
    add_theme_support('align-wide');
    add_theme_support('post-thumbnails');
    add_image_size('member-thumbnail',  290, 689, array( 'left', 'top' ));
    add_image_size( 'adoq-thumbnail', 200, 200, array( 'left', 'top' ) );



    add_post_type_support('page', 'excerpt');
}
add_action('after_setup_theme', 'alphaecm_setup');

function alphaecm_the_custom_logo()
{

    if (function_exists('the_custom_logo')) {
        the_custom_logo();
    }
}

//Define Assets
define('ECM_ASSETS_URL', trailingslashit(get_template_directory_uri()) . 'assets/');
function alphaecm_style_et_scripts()
{
    //Jquery
    wp_enqueue_script('boot1', 'https://code.jquery.com/jquery-3.3.1.min.js', array('jquery'), '', true);
    wp_enqueue_script('boot2', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('jquery'), '', true);

    //Slick Slider
    wp_enqueue_style('slick-style', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', false);
    wp_enqueue_script('slick-script', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true);

    //Bootstrap
    wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
    wp_enqueue_script('boot3', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array('jquery'), '', true);

    //Font Awesome
    wp_enqueue_style('fontawesome', ECM_ASSETS_URL . 'css/fontawesome.min.css');
    wp_enqueue_script('fontawesome', ECM_ASSETS_URL . 'js/fontawesome.min.js', array(), '5.13.0', true);

    //Stylesheet
    wp_enqueue_style('style', ECM_ASSETS_URL . 'css/style.css');
    // wp_enqueue_style('style', get_stylesheet_uri());

    //Script
    wp_enqueue_script('script', ECM_ASSETS_URL . '/js/custom.js', array('jquery'), 1.1, true);
}
add_action('wp_enqueue_scripts', 'alphaecm_style_et_scripts');

function wpa_cpt_tags($query)
{
    if ($query->is_tag() && $query->is_main_query()) {
        $query->set('post_type', array('post', 'object'));
    }
}
add_action('pre_get_posts', 'wpa_cpt_tags');

//TAXO FILTER
function modify_dropdown_orderby($orderby, $taxonomy)
{

    return "ID";
}
add_filter('beautiful_filters_dropdown_orderby', 'modify_dropdown_orderby', 10, 2);
