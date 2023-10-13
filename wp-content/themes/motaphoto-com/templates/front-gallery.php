<?php
$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 8,
    'paged' => 1,
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
    echo '<div class="container">';

    $photo_count = 0;

    while ($query->have_posts()) {
        $query->the_post();

        $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $photo_title = get_the_title();
        $photo_categories = get_the_terms(get_the_ID(), 'categorie');

        $reference = get_field('reference');
        $data_reference = $reference ? 'data-reference="' . $reference . '"' : '';

        echo '<div class="img-detail">';
        echo '<a href="' . get_permalink() . '">';
        echo '<div class="image-container photo-loaded" style="background-image: url(' . esc_url($featured_image_url) . ')" ' . $data_reference . '>';
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

        $photo_count++;

        if ($photo_count === 12) {
            break;
        }
    }

    echo '</div>';

    if ($query->found_posts > 12) {
        echo '<div class="btn-container">';
        echo '<button id="load-more-button">Charger plus</button>';
        echo '</div">';
    }
} else {
    echo 'Pas de photo en cours';
}

wp_reset_postdata();
