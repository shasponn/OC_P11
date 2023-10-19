function SingleloadMorePhotos(MoreButton, loadMoreNonce, galleryContainer, currentPhotoId) {
    const categoryIds = JSON.parse(MoreButton.getAttribute('data-category-ids'));
  
    // Requête Ajax en JS natif via Fetch
    fetch(MoreButton.getAttribute('data-ajaxurl'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            action: 'single_load_more_photos',
            category_ids: JSON.stringify(categoryIds),
            load_more_nonce: loadMoreNonce,
            current_photo_id: currentPhotoId
        }),
    })
    .then(response => response.text())
    .then(html => {
        galleryContainer.innerHTML = html; // Remplacer le contenu par les nouvelles photos
        initializeThickbox(); // Appeler initializeThickbox après l'insertion de nouveau contenu
    });
  }