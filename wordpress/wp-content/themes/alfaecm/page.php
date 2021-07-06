<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class='post'>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <p><?php the_content(__('(more...)')); ?></p>
        </div>

    <?php endwhile;
else : ?>
    <p><?php _e('Désolé, aucun article ne représente votre recherche'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>