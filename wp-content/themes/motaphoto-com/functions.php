<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style('child-style', get_stylesheet_directory_uri(). '/style.css');
}

function custom_scripts() {
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0', true );
    wp_enqueue_script('single-requete', get_stylesheet_directory_uri() . '/js/front/single-requete.js', array('jquery'), '1.0', true );
    }
    
    add_action( 'wp_enqueue_scripts', 'custom_scripts' );


function front_more_photos() {
    $page = $_GET['page'];

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
    );

    if (isset($_GET['category_filter'])) {
        $selected_category = sanitize_text_field($_GET['category_filter']);
        if (!empty($selected_category)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $selected_category,
                ),
            );
        }
    }

    if (isset($_GET['format_filter'])) {
        $selected_format = sanitize_text_field($_GET['format_filter']);
        if (!empty($selected_format)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'format',
                'field' => 'slug',
                'terms' => $selected_format,
            );
        }
    }

    if (isset($_GET['sort_by'])) {
        $sort_order = sanitize_text_field($_GET['sort_by']);
        if ($sort_order === 'newest') {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ($sort_order === 'oldest') {
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $photo_title = get_the_title();
            $photo_categories = get_the_terms(get_the_ID(), 'categorie');
        
            $reference = get_field('reference');
            $data_reference = $reference ? 'data-reference="' . $reference . '"' : '';

            echo '<div class="img-detail">';
            echo '<a href="' . get_permalink() . '">';
            echo '<div class="image-container" style="background-image: url(' . esc_url($featured_image_url) . ')" ' . $data_reference . '>';
            echo '<div class="overlay">';
            echo '<div class="icon-container">';
            echo '<img src="' . esc_url('http://localhost/p11/wp-content/uploads/2023/07/Icon_eye.png') . '" alt="Icone" class="icon icon-center">';
            echo '<img src="' . esc_url('http://localhost/p11/wp-content/uploads/2023/07/Icon_fullscreen.png') . '" alt="Icone" class="icon icon-top-right thickbox">';
            echo '</div>';
            echo '<div class="photo-info spaced">';
            echo '<p class="photo-title">' . esc_html($photo_title) . '</p>';

            if ($photo_categories) {
                echo '<h4 class="photo-category">';
                foreach ($photo_categories as $category) {
                    echo esc_html($category->name) . ' ';
                }
                echo '</h4>';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
        }
        wp_reset_postdata();

    } else {
        echo 'Pas de photo en cours'; 
    }

    die(); 
}

add_action('wp_ajax_load_more_photos', 'front_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'front_more_photos');

//

function single_more_photos() {

    $paged = $_POST['paged'];
    $category_ids = json_decode(stripslashes($_POST['category_ids']));
    $current_photo_id = $_POST['current_photo_id'];

    $current_photo_exclude = array($current_photo_id);

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => -1,
        'post__not_in' => $current_photo_exclude,
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'term_id',
                'terms' => $category_ids,
                'operator' => 'IN',
            ),
        ),
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged,
        'post__not_in' => array($current_photo_id), 
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $photo_title = get_the_title();
            $photo_categories = get_the_terms(get_the_ID(), 'categorie');

            $reference = get_field('reference');
            $data_reference = $reference ? 'data-reference="' . $reference . '"' : '';

            echo '<div class="img-detail">';
            echo '<a href="' . get_permalink() . '">';
            echo '<div class="image-container" style="background-image: url(' . esc_url($featured_image_url) . ')" ' . $data_reference . '>';
            echo '<div class="overlay">';
            echo '<div class="icon-container">';
            echo '<img src="http://localhost/p11/wp-content/uploads/2023/07/Icon_eye.png" alt="Icone" class="icon icon-center">';
            echo '<img src="http://localhost/p11/wp-content/uploads/2023/07/Icon_fullscreen.png" alt="Icone" class="icon icon-top-right thickbox">';
            echo '</div>';
            echo '<div class="photo-info spaced">';
            echo '<p class="photo-title">' . $photo_title . '</p>';

            if ($photo_categories) {
                echo '<h4 class="photo-category">';
                foreach ($photo_categories as $category) {
                    echo $category->name . ' ';
                }
                echo '</h4>';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
        }

        wp_reset_postdata();

    } else {
        echo 'Pas de photo en cours';
    }

    die();
}

add_action('wp_ajax_single_load_more_photos', 'single_more_photos');
add_action('wp_ajax_nopriv_single_load_more_photos', 'single_more_photos');


?>



