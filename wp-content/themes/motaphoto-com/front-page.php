<?php get_header(); ?>

<main id="primary" class="site-main">

    <section class="banner">
        <div class="banner-content">
            <h1>Photographe Event</h1>
        </div>
        <div class="banner-image"></div>
    </section><!--.banner-->

    <div class="filter-form">
        <form method="get">

            <div class="form_group">
                <div class="group_selects">
                    <div class="form_group_select">
                        <label class="custom-select">
                            <select name="sample category_filter" id="category-filter">
                                <option value="">Toutes les catégories</option>
                                <option value="reception">Réception</option>
                                <option value="television">Télévision</option>
                                <option value="concert">Concert</option>
                                <option value="mariage">Mariage</option>
                            </select>
                        </label>

                        <label class="custom-select">
                            <select name="sample format_filter" id="format-filter">
                                <option value="">Tous les formats</option>
                                <option value="paysage">Paysage</option>
                                <option value="portrait">Portrait</option>
                            </select>
                        </label>
                    </div>
                    <label class="custom-select">
                        <select name="sample sort_by" id="sort-by">
                            <option value="">Non trié</option>
                            <option value="newest">Du plus récent au plus ancien</option>
                            <option value="oldest">Du plus ancien au plus récent</option>
                        </select>
                    </label>
                </div>
            </div>
        </form>
    </div>

    <?php
    include('templates/front-gallery.php');
    ?>


</main><!--#main-->

<script>
    $(document).ready(function() {
        var page = 1;

        // Fonction pour charger plus de photos
        function FrontloadMorePhotos() {
            var data = {
                action: 'load_more_photos',
                page: page,
                category_filter: $('#category-filter').val(),
                format_filter: $('#format-filter').val(),
                sort_by: $('#sort-by').val(),
            };

            $.get("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response) {
                if (page === 1) {
                    $('.container').empty();
                }
                $('.container').append(response);
                page++;

                // Masquer le bouton "Charger plus" si toutes les photos ont été chargées
                if ($('.img-detail').length < <?php echo $query->found_posts; ?>) {
                    $('#load-more-button').show();
                } else {
                    $('#load-more-button').hide();
                }
                initializeThickbox();
            });
        }

        // Appeler loadMorePhotos lorsqu'on clique sur le bouton "Charger plus"
        $('#load-more-button').on('click', function(event) {
            event.preventDefault();
            FrontloadMorePhotos();
        });

        // Appeler loadMorePhotos lorsqu'on change les filtres
        $('#category-filter, #format-filter, #sort-by').on('change', function() {
            page = 1; // Réinitialiser la page
            FrontloadMorePhotos();
        });
    });
</script>


<?php get_footer(); ?>