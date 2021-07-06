<?php get_header(); ?>
<section class="home-actualites">
    <header>
        <h2><i class="far fa-calendar-alt"></i> Actualités d’Alfa: ECM</h2>
    </header>
    <section class="actualites-banner">

        <?php $evenements_query = new WP_Query(array(
            'post_type' => 'post', 'posts_per_page' => '5',
        ));
        if ($evenements_query->have_posts()) : ?>
            <?php while ($evenements_query->have_posts()) : $evenements_query->the_post(); ?>
                <article>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('full'); ?>
                        <div class="color-overlay">
                        </div>
                        <div class="home-titre-resume">
                            <h3><?php the_title(); ?></h3>
                            <?php the_excerpt(); ?>
                        </div>
                    </a>
                </article>
            <?php endwhile;
            wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>
</section>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class='post'>
            <h1><?php the_title(); ?></h1>
            <p><?php the_content(__('(En lire plus...)')); ?></p>
        </div>

<?php endwhile;
endif; ?>


<section class="home home-propos">


    <?php
    $args = array(
        'post_type' => 'page',
        'post__in' => array(64)
    );
    $modules_query = new WP_Query($args);
    if ($modules_query->have_posts()) : ?>
        <?php while ($modules_query->have_posts()) : $modules_query->the_post(); ?>
            <header>
                <h2><i class="fas fa-info-circle"></i> À propos d’Alfa: ECM</h2>
            </header>
            <section class="home-propos-resume">
                <?php the_content(); ?>
            </section>

        <?php endwhile;
        wp_reset_postdata(); ?>
    <?php endif; ?>
</section>



<?php get_footer(); ?>