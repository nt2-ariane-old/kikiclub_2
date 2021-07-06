<?php get_header(); ?>

<header class="archive-header">
    <h1 class="archive-title">
        Publications
    </h1>
</header><!-- .archive-header -->

<?php if (have_posts()) : ?>
    <div class="publications-list">
        <?php while (have_posts()) : the_post(); ?>
            <div class="publication">
                <div class="tile-publication-content">
                    <h3><?php the_title(); ?></h3>
                </div>

            </div>

        <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p><?php _e('Désolé, aucun membre ne représente votre recherche'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>