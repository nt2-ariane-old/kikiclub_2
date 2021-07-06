<?php
$query = $wp_query->query;
$category_name == $query["teams-type"];
if ($query["teams-type"] === "partenaires") {
    $class = "partenaire";
} else {
    $class = "member";
}
?>

<div class="<?= $class ?>">
    <?php
    if (has_post_thumbnail()) {
        $title = trim(get_the_title());

    ?>
        <div class="tile-member-picture">
            <a href="<?php the_permalink() ?>">

                <?php
                if (strpos(strtolower($title), 'adoq') !== false) {
                    the_post_thumbnail(array('class' => 'adoq'));
                } else {
                    the_post_thumbnail();
                }
                ?>
            </a>
        </div>
    <?php
    }
    ?>

    <div class="tile-member-content">

        <a href="<?php the_permalink() ?>">
            <h3><?php the_title(); ?></h3>
        </a>
        <div class="postes">
            <?php
            $postes = get_post_custom()["Poste"];
            for ($i = 0; $i < sizeof($postes); $i++) {
            ?>
                <h4><?php echo $postes[$i]; ?></h4>
            <?php
            }
            ?>
        </div>
        <div class="affiliations">
            <?php
            $affiliations = get_post_custom()["Affiliation"];
            for ($i = 0; $i < sizeof($affiliations); $i++) {
            ?>
                <h4><?php echo $affiliations[$i]; ?></h4>
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
                    <?php echo $courriels[$i] ?>
                </a>
            <?php
            }
            ?>
        </div>
        <a class="plus" href="<?php the_permalink() ?>">
            En savoir plus
        </a>
    </div>

</div>