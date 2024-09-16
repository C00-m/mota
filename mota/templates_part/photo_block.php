<div class="photo-block">
    <a href="<?php the_permalink(); ?>">
        <div class="photo-container">
            <?php the_post_thumbnail('full'); ?>
            <div class="photo-overlay">
                <div class="photo-eye">
                    <img src="<?php echo  get_stylesheet_directory_uri() . '/images/eye.png'; ?>">
                </div>
                <div class="photo-info">
                    <h3 class="title_hov"><?php the_title(); ?></h3>
                    <p class="categorie_hov"><?php echo get_the_terms(get_the_ID(), 'categorie')[0]->name; ?></p>
                    <span class="reference" style="display: none;"><?php echo get_post_meta(get_the_ID(), 'reference', true); ?></span>
                </div>
                <div class="photo-open">
                    <img class="photEye" src="<?php echo  get_stylesheet_directory_uri() . '/images/Icon_fullscreen.png'; ?>">
                </div>
            </div>
        </div>
    </a>
</div>