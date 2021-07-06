<?php get_header(); ?>

<header class="archive-header">
    <h1 class="archive-title">
        Notre équipe
    </h1>
</header><!-- .archive-header -->
<div class="membres-direction">

    <h2>Directrice de l'équipe de recherche ALFA:ECM</h2>
    <?php $direction = new WP_Query(array(
        'post_type' => 'membres',
        'posts_per_page'         => '-1',
        'order'                  => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'teams-type',
                'field' => 'slug', //can be set to ID
                'terms' => 'direction' //if field is ID you can reference by cat/term number
            )
        )
    ));

    if ($direction->have_posts()) : ?>
        <div class="members-list">
            <?php while ($direction->have_posts()) : $direction->the_post(); ?>
                <?php
                get_template_part('member');
                ?>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    <?php endif; ?>

</div>
<div class="membres-coordos">
    <h2>Coordonnatrices de l'équipe de recherche ALFA: ECM</h2>
    <?php $coordo = new WP_Query(array(
        'post_type' => 'membres',
        'posts_per_page'         => '-1',
        'order'                  => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'teams-type',
                'field' => 'slug', //can be set to ID
                'terms' => 'coordo' //if field is ID you can reference by cat/term number
            )
        )
    ));

    if ($coordo->have_posts()) : ?>
        <div class="members-list">
            <?php while ($coordo->have_posts()) : $coordo->the_post(); ?>
                <?php
                get_template_part('member');
                ?>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    <?php endif; ?>
</div>
<div class="membres">
    <h2>Membres</h2>
</div>
<?php $allPostsWPQuery = new WP_Query(array(
    'post_type' => 'membres',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'teams-type',
            'field' => 'slug', //can be set to ID
            'terms' => array('coordo', 'direction', 'partenaires'), //if field is ID you can reference by cat/term number
            'operator' => 'NOT IN' /* DO THE MAGIC -  Get all post that no in the taxonomy terms */

        )
    )
)); ?>

<?php if ($allPostsWPQuery->have_posts()) : ?>
    <div class="members-list">
        <?php while ($allPostsWPQuery->have_posts()) : $allPostsWPQuery->the_post(); ?>
            <?php
            get_template_part('member');
            ?>

        <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p><?php _e('Désolé, aucun membre ne représente votre recherche'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>