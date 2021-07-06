<?php

/**
 * Template Name: theorique
 *
 * @package WordPress
 * @subpackage YOUR THEME NAME
 * @since MyTheme 2.0
 */
get_header();

$slug = get_queried_object()->slug;
$post_type = $wp_query->query["post_type"];
$category_name == $wp_query->query["category_name"];
$label = '';

if ($post_type == "publications" || $post_type == "publications-ms") {
    $label = "Publications";
} else if ($post_type == "theoriques") {
    $label = "Contenus Théoriques";
} else if ($category_name == 'scolaire-actualites' || $category_name == 'recherche-actualites') {
    $label = "Actualités";
} else if ($post_type == "activites") {
    $label = "Activités";
} else {
    $label = get_queried_object()->label;
}
?>
<h1 class="page-title"><?php echo $label; ?></h1>
<?php
if ($post_type == 'activites') {

?>
    <div class="row activities">
        
    <?php
} else {
    ?>
        <div class="row">
        <?php
        echo $post_type;
    }
        ?>

        <div class='col-md-12'>


            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php
                    if ($label == 'Activités') {
                    ?>
                        <div class='post activity'>
                        <?php
                    } else {
                        ?>
                            <div class='post'>
                            <?php
                        }
                            ?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="thumbnail" href="<?php the_permalink() ?>">
                                            <?php 
                                            the_post_thumbnail()
                                            ?>
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="<?php the_permalink() ?>">
                                            <h1><?php the_title(); ?></h1>
                                        </a>
                                        <?php echo the_excerpt(); ?>
                                        <a href="<?php the_permalink() ?>">En lire plus </a>
                                    </div>

                                </div>
                            </div>


                            </div>

                        <?php endwhile;
                else : ?>
                        <p><?php _e('Désolé, aucun article ne représente votre recherche'); ?></p>
                    <?php endif; ?>
                    <?php
                    wp_reset_query();

                    ?>
                        </div>

        </div>






        <?php get_footer(); ?>