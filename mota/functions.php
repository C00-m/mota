<?php

add_theme_support('post-thumbnails');



function mota_enqueue_styles()
{

    wp_enqueue_style('main-style', get_stylesheet_uri());


    wp_enqueue_script('lightbox-script', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), null, true);
    wp_enqueue_script('hero-script', get_template_directory_uri() . '/js/hero.js', array('jquery'), null, true);
    wp_enqueue_script('custom_script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);
    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
    wp_enqueue_style('select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');



    wp_localize_script('hero-script', 'wp_vars', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
    wp_localize_script('filters', 'wp_vars', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
    wp_localize_script('custom_script', 'wp_vars', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'mota_enqueue_styles');

function custom_theme_setup()
{

    register_nav_menus(array(
        'primary' => __('Header-menu'),
        'footer-menu' => __('Footer-Menu')
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');



// Fonction pour gérer la requête AJAX pour une image aléatoire
function get_random_photo_url()
{
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'rand',
    );

    $random_photo = new WP_Query($args);

    if ($random_photo->have_posts()) {
        $random_photo->the_post();
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        wp_reset_postdata();

        return $image_url;
    }

    return '';
}


/* Chargement AJAX pour plus de photos */
function enqueue_load_more_script()
{
    if (is_front_page()) {
        wp_enqueue_script(
            'load-more',
            get_stylesheet_directory_uri() . '/js/load-more.js',
            array('jquery'),
            null,
            true
        );

        wp_localize_script('load-more', 'ajax_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');


function create_photo_post_type()
{
    register_post_type(
        'photo',
        array(
            'labels' => array(
                'name' => __('Photo'),
                'singular_name' => __('Photo')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'photo'),
            'supports' => array('title', 'editor', 'thumbnail')
        )
    );
}
add_action('init', 'create_photo_post_type');

// Fonction AJAX pour charger plus de photos
function load_photos()
{
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $category = isset($_GET['category']) ? intval($_GET['category']) : '';
    $format = isset($_GET['format']) ? intval($_GET['format']) : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
    );

    // Applique le filtre par catégorie 
    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'term_id',
                'terms' => $category,
            ),
        );
    }

    // Applique le filtre par format 
    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'term_id',
            'terms' => $format,
        );
    }

    // Appliquer le tri par date
    if ($sort === 'date_asc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } else {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }

    $query = new WP_Query($args);
    $html = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ob_start();
            get_template_part('/templates_part/photo_block');
            $html .= ob_get_clean();
        }
    } else {
        $html = "Aucune photo trouvée.";
    }

    // Vérifie s'il y a encore des pages à charger
    $has_more = $query->max_num_pages > $page;

    wp_reset_postdata();

    echo json_encode(array('html' => $html, 'has_more' => $has_more));
    wp_die();
}
add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');
