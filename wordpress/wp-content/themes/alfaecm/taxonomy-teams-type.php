<?php get_header(); ?>
<?php
// get the currently queried taxonomy term, for use later in the template file
$term = get_queried_object();

?>

<header class="archive-header">
    <h1 class="archive-title">
        <?php echo $term->name; ?>
        <?php //post_type_archive_title(); 
        ?>
    </h1>
</header><!-- .archive-header -->

<?php $allPostsWPQuery = new WP_Query(array('post_type' => 'membres', "teams-type" => $term->slug, 'post_status' => 'publish', 'posts_per_page' => -1)); ?>

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