</div>
</main>

<footer id="footer">
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'pieds_page',
            'menu_class'     => 'footer',
            'depth'          => 1,
        )
    );
    ?>
</footer>
<?php
wp_footer()
?>
</body>

</html>