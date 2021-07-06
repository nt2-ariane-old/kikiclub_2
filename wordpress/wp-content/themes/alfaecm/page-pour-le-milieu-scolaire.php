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

<section class="recherche recherche-theoriques">
    <header>
        <h3><a href="<?php echo get_post_type_archive_link('theoriques'); ?>">Contenus théoriques</a></h3>
    </header>
    <section class="items recherche-theoriques-items">
        <?php $modules_query = new WP_Query(array(
            'post_type' => 'theoriques',
            'posts_per_page'         => '3',
            'order'                  => 'DESC',
            'orderby'                => 'ID',
        ));
        if ($modules_query->have_posts()) : ?>
            <?php while ($modules_query->have_posts()) : $modules_query->the_post(); ?>
                <article>
                    <a class="thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
                    <div class="recherche-titre-resume">
                        <a href="<?php the_permalink(); ?>">
                            <h4><?php the_title(); ?></h4>
                        </a>
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile;
            wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>
    <footer>
        <a href="<?php echo get_post_type_archive_link('theoriques'); ?>">Voir tous les contenus théoriques</a>
    </footer>
</section>


<section class="recherche recherche-publications">
    <header>
        <h3><a href="<?php echo get_post_type_archive_link('publications-ms'); ?>">Liste des publications</a></h3>
    </header>
    <section class="recherche-publications-items">
        <?php $allPostsWPQuery = new WP_Query(array(
            'post_type' => 'publications-ms',
            'order'                  => 'ASC',
            'post_status' => 'publish',
            'posts_per_page' => 5
        )); ?>

        <?php if ($allPostsWPQuery->have_posts()) : ?>
            <div class="publications-list">
                <?php while ($allPostsWPQuery->have_posts()) : $allPostsWPQuery->the_post(); ?>
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
    </section>
    <footer>
        <a href="<?php echo get_post_type_archive_link('publications0ms'); ?>">Voir tous les publications</a>
    </footer>
</section>

<section class="recherche recherche-actualites">
    <?php
    $category_id = get_category_by_slug('scolaire-actualites');
    $category_link = get_category_link($category_id);
    ?>
    <header>
        <h3><a href="<?php echo $category_link; ?>">Actualités</a></h3>
    </header>
    <section class="items recherche-actualites-items">

        <?php
        $args = array(
            'post_type' => 'post',
            'order'                  => 'DESC',
            'orderby'                => 'ID',
            'posts_per_page'         => '3',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug', //can be set to ID
                    'terms' => 'scolaire-actualites' //if field is ID you can reference by cat/term number
                )
            )
        );

        $modules_query = new WP_Query($args);
        if ($modules_query->have_posts()) : ?>
            <?php while ($modules_query->have_posts()) : $modules_query->the_post(); ?>
                <article>
                    <a class="thumbnail"  href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
                    <div class="recherche-titre-resume">
                        <a href="<?php the_permalink(); ?>">
                            <h4><?php the_title(); ?></h4>
                        </a>
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile;
            wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>
    <footer>
        <a href="<?php echo $category_link; ?>">Voir tous les actualités</a>

    </footer>
</section>

<section class="recherche recherche-activites">
    
    <header>
        <h3><a href="<?php echo get_post_type_archive_link('activites'); ?>">Activités</a></h3>
    </header>
    <section class="items recherche-activites-items">
        <?php $modules_query = new WP_Query(array(
            'post_type' => 'activites',
            'posts_per_page'         => '3',
            'order'                  => 'DESC',
            'orderby'                => 'ID',
        ));
        if ($modules_query->have_posts()) : ?>
            <?php while ($modules_query->have_posts()) : $modules_query->the_post(); ?>
                <article>
                    <a class="thumbnail"  href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
                    <div class="recherche-titre-resume">
                        <a href="<?php the_permalink(); ?>">
                            <h4><?php the_title(); ?></h4>
                        </a>
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile;
            wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>
    <footer>
        <a href="<?php echo get_post_type_archive_link('activites'); ?>">Voir toutes les activités</a>
    </footer>
</section>

<?php get_footer(); ?>