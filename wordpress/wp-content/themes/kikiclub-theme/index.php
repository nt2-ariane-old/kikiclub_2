<?php get_header(); ?>

<div style="text-align:center;">
    <?php posts_nav_link(' · ', 'Page précédente', 'Page suivante'); ?>
</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class='post'>
            <h1><?php the_title(); ?></h1>
            <p><?php the_content(__('(En lire plus...)')); ?></p>
        </div>

    <?php endwhile;
else :
    ?>

    <p><?php _e('Désolé, aucun ' . $wp_query->query["category_name"] . ' ne représente votre recherche'); ?></p>
<?php endif; ?>
<div style="text-align:center;">
    <?php posts_nav_link(' · ', 'Page précédente', 'Page suivante'); ?>
</div>

<?php get_footer(); ?>