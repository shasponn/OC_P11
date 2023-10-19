<?php

get_header(); ?>

<main id="primary" class="site-main">
    <div class="template-photo">

        <?php
        // Récupérer l'ID de la publication en cours
        $photo_id = get_the_ID();
        // Récupérer l'URL de la photo mise en avant
        $featured_image_url = get_the_post_thumbnail_url($photo_id, 'full');
        // Récupérer le titre de la photo
        $photo_title = get_the_title($photo_id);
        // ACF CHAMPS
        $reference = get_field('reference');
        $type = get_field('type');
        $annee = get_field('annee');
        // CPT UI CHAMPS
        $categories = get_the_terms($photo_id, 'categorie');
        $formats = get_the_terms($photo_id, 'format');
        ?>

        <section class="main-photo">
            <div class="detail-photo">
                <h1><?php echo $photo_title; ?></h1>
                <h2>Référence:<?php echo $reference; ?></h2>
                <?php
                echo '<div class="taxonomy-terms">';
                foreach ($categories as $categorie) {
                    echo '<h2>Catégorie:</h2>';
                    echo '<h2 class="term">' . $categorie->name . '</h2>';
                }
                echo '</div>';
                echo '<div class="taxonomy-terms">';
                foreach ($formats as $format) {
                    echo '<h2>Format:</h2>';
                    echo '<h2 class="term">' . $format->name . '</h2>';
                }
                echo '</div>'; ?>
                <h2>Type:<?php echo $type; ?></h2>
                <h2>Année:<?php echo $annee; ?></h2>
                <div class="trait"></div>
            </div>

            <div id="photo-id" class="img-single">
                <div class="img-detail">
                    <div class="image-container" style="background-image: url('<?php echo $featured_image_url; ?>');" data-reference="<?php echo $reference; ?>" alt="<?php echo $photo_title; ?>">
                        <div class="overlay">
                            <div class="icon-container">
                                <img src="http://localhost/p11/wp-content/uploads/2023/07/Icon_fullscreen.png" alt="Icone" class="icon icon-top-right thickbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--.main-photo-->

        <section class="form-contact">
            <div class="form-group">
                <p>Cette photo vous intérésse ?</p>

                <button class="contactbtn" data-photo-reference="<?php echo $reference; ?>">Contact</button>
                <?php get_template_part('/templates/modal'); ?>
            </div>

            <div id="carousel">
                <div class="carousel-container">
                    <?php
                    include('templates/single/single-carrosel.php');
                    ?>
                </div>
                <div class="group-btn-carrousel">
                    <button class="carousel-arrow prev" onclick="navigateCarousel('prev')">←</button>
                    <button class="carousel-arrow next" onclick="navigateCarousel('next')">→</button>
                </div>
            </div>
        </section><!--.gallery-->

        <section class="gallery">
            <h3>VOUS AIMEREZ AUSSI </h3>
            <div class="gallery-container">
                <?php
                include('templates/single/single-gallery.php');
                ?>
            </div>
        </section><!--.gallerie-->

    </div><!--.single-photo-->
</main><!--#main-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const MoreButton = document.getElementById('voir-plus');
        const galleryContainer = document.querySelector('.gallery-container .container');
        const currentPhotoId = '<?php echo get_the_ID(); ?>';

        // Apppel de la fonction Single
        if (MoreButton) {
            MoreButton.addEventListener('click', function() {
                SingleloadMorePhotos(MoreButton, '<?php echo wp_create_nonce('single_load_more_photos'); ?>', galleryContainer, currentPhotoId);
            });
        }
    });

    // CARROSEL 
    var currentPhotoId = <?php echo json_encode($current_photo_id); ?>;
</script>


<?php
get_footer();
?>