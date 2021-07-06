<?php

/**
 * Plugin Name: Plugin Kikiclub
 * Description: Rajoute les type de contenus nécessaires pour le site.
 * Version: 1.0
 * Author: Ludovic Doutre-Guay
 * Author URI: http://www.doutreguay.com
 */

//ajout de taxonomie
function themes_taxonomy()
{
    //Ateliers
    register_taxonomy(
        'difficultes',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'ateliers',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Difficultés', // display name
            'query_var' => true,
            'show_in_rest' => true,
            'rest_base'             => 'difficultes',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'rewrite' => array(
                'slug' => 'difficultes',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
    register_taxonomy(
        'niveaux',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        array( 'ateliers', 'robots' ),             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Niveaux scolaires', // display name
            'show_in_rest' => true,
            'rest_base'             => 'niveaux',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'niveaux',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
    register_taxonomy(
        'robots',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'ateliers',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Robots', // display name
            'show_in_rest' => true,
            'rest_base'             => 'robots_taxo',
            'rest_controller_class' => 'WP_REST_Terms_Controller',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'robots',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action('init', 'themes_taxonomy');

// Our custom post type function
function create_posttype()
{
    register_post_type(
        'ateliers',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('Ateliers'),
                'singular_name' => __('Atelier')
            ),
            'supports' => array('title', 'custom-fields',  'editor', 'excerpt', 'thumbnail'),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'ateliers'),
            'show_in_rest' => true
        )
    );
    register_post_type(
        'robots',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('Robots'),
                'singular_name' => __('robot')
            ),
            'supports' => array('title', 'custom-fields',  'editor', 'excerpt', 'thumbnail'),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'robots'),
            'show_in_rest' => true
        )
    );
}
// Hooking up our function to theme setup
add_action('init', 'create_posttype');
