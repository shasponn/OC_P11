<!--SCRIPT PHP CARROSEL POUR SINGLE-PHOTO.PHP-->

<?php

$current_photo_id = $photo_id;
$slug = 'photo';
$category = get_category_by_slug($slug);

$args = array(
    'post_type' => 'photo',
    'posts_per_page' => -1,
    'orderby' => 'date', 
    'order' => 'DESC', 
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    echo '<div id="carousel" class="carousel-container">';
    while ($query->have_posts()) {
        $query->the_post();
        $featured_image_url = get_the_post_thumbnail_url();

        if ($featured_image_url && get_the_ID() !== $current_photo_id) {
            echo '<a href="' . get_permalink() . '"><img class="carousel-image" src="' . $featured_image_url . '" alt="' . get_the_title() . '" data-photo-id="' . get_the_ID() . '"></a>';
        }
    }
    echo '</div>';
}

wp_reset_postdata();
?>