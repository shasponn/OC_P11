<?php
$current_page_id = get_the_ID();

$current_page_categories = get_the_terms($current_page_id, 'categorie');
$current_category_ids = array();

if (!empty($current_page_categories)) {
    foreach ($current_page_categories as $category) {
        $current_category_ids[] = $category->term_id;
    }
}

$current_page_exclude = array($current_page_id);
$current_page_exclude[] = $current_page_id;

$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 2,
    'post__not_in' => $current_page_exclude,
    'tax_query' => array(
        array(
            'taxonomy' => 'categorie',
            'field' => 'term_id',
            'terms' => $current_category_ids,
            'operator' => 'IN',
        ),
    ),
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => 1,
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    echo '<div class="container">';

    while ($query->have_posts()) {
        $query->the_post();

        $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $photo_title = get_the_title();
        $photo_categories = get_the_terms(get_the_ID(), 'categorie');
        $reference = get_field('reference');
        $data_reference = $reference ? 'data-reference="' . $reference . '"' : '';

        echo '<div class="img-detail">';
        echo '<a href="' . get_permalink() . '">';
        echo '<div class="image-container" style="background-image: url(' . $featured_image_url . ')" ' . $data_reference . '>';
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

    echo '</div>';

    echo '<div class="btn-container">';
    echo '<button id="voir-plus" data-paged="1" data-ajaxurl="' . admin_url('admin-ajax.php') . '" data-category-ids="' . json_encode($current_category_ids) . '">Toutes les photos</button>';
    echo '</div>';
} else {
    echo 'Pas de photo en cours';
}

wp_reset_postdata();
