<?php wp_footer(); ?>
<footer>
    <?php get_template_part('templates_part/lightbox'); ?>
    <?php get_template_part('templates_part/modale'); ?>
    <nav class="footer-menu">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'footer-menu',
            'menu_class' => 'footer-menu'
        ));
        ?>
        <p>TOUS DROITS RÉSERVÉS</p>
    </nav>
</footer>
</body>

</html>