<?php get_header() ?>
<div class="hero-header fade-in">
    <img src="<?php echo get_random_photo_url(); ?>" alt="Hero header du site de Nathalie Mota" class="hero-image">
    <div class="hero-overlay">
        <h2>Photographe Event</h2>
    </div>
</div>



<!-- Filtres de catégorie et de format -->
<div class="filter-controls fade-in">
    <div class="filtertax">
        <select class="select2" id="photo-category-filter">
            <option value="">CATÉGORIES</option>
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'categorie',
                'hide_empty' => false,
            ));
            foreach ($categories as $category) {
                echo "<option value='{$category->term_id}'>{$category->name}</option>";
            }
            ?>
        </select>

        <select class="select2" id="photo-format-filter">
            <option value="">FORMATS</option>
            <?php
            $formats = get_terms(array(
                'taxonomy' => 'format',
                'hide_empty' => false,
            ));
            foreach ($formats as $format) {
                echo "<option value='{$format->term_id}'>{$format->name}</option>";
            }
            ?>
        </select>
    </div>


    <!-- Tri du plus ancien au plus récent -->
    <select class="select2" id="photo-sort">
        <option value="">Trier par</option>
        <option value="date_desc">Plus récent</option>
        <option value="date_asc">Plus ancien</option>
    </select>
</div>

<section class="affichage_photo-fp" id="photo-container">
    <?php
    $affichagefront = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => 1,
    ));

    if ($affichagefront->have_posts()) {
        while ($affichagefront->have_posts()) {
            $affichagefront->the_post();
            get_template_part('/templates_part/photo_block');
        }
    }
    ?>
</section>
<div class="button_area">
    <button id="load-more-photos">Charger plus</button>
</div>
<?php get_footer() ?>