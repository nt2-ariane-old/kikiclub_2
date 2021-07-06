<?php get_header(); ?>
<div class="main single">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <div class="membre-page">
                <header>

                    <?php
                    the_post_thumbnail()
                    ?>
                    <div class="membre-infos">
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <div class="postes">
                            <?php
                            $postes = get_post_custom()["Poste"];
                            for ($i = 0; $i < sizeof($postes); $i++) {
                            ?>
                                <h2><?php echo $postes[$i]; ?></h2>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="affiliations">
                            <?php
                            $affiliations = get_post_custom()["Affiliation"];
                            for ($i = 0; $i < sizeof($affiliations); $i++) {
                            ?>
                                <h3><?php echo $affiliations[$i]; ?></h3>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="courriels">
                            <?php
                            $courriels = get_post_custom()["Courriel"];
                            for ($i = 0; $i < sizeof($courriels); $i++) {
                            ?>
                                <a href="<?php echo "mailto:" . $courriels[$i]; ?>">
                                    <h4><?php echo $courriels[$i] ?></h4>
                                </a>
                            <?php
                            }
                            ?>
                        </div>



                    </div>
                </header>

                <div class="membre-content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
<?php get_footer(); ?>