//-----------------------------Modal-------------------------------//

const modal = document.getElementById("contactmodal");
const btns = document.querySelectorAll(".contactbtn");

btns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    modal.style.display = "block";
  });
});

window.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});


//-----------------------------Menu burger-------------------------------//

const button = document.querySelector(".btnburgernmenu");
const menuburger = document.querySelector(".menuburger");
const nav = document.querySelector(".nav-burger");

button.addEventListener("click", () => {
  menuburger.classList.toggle("openburger");
  nav.classList.toggle("menuburgeropen");
  button.classList.toggle("burgeractive");

  // Vérifier si la classe openburger est présente
  if (menuburger.classList.contains("openburger")) {
    document.body.style.overflow = "hidden";
  } else {
    document.body.style.overflow = "auto";
  }
});


//-----------------------------Select changement de couleur-------------------------------//

document.querySelectorAll(".custom-select").forEach(setupSelector);

function setupSelector(selector) {
  selector.addEventListener("change", (e) => {
    console.log("changé", e.target.value);
  });

  if (window.innerWidth >= 420) {
    selector.addEventListener("mousedown", (e) => {
      e.preventDefault();

      const select = selector.children[0];
      const dropDown = document.createElement("ul");
      dropDown.className = "selector-options";

      [...select.children].forEach((option) => {
        const dropDownOption = document.createElement("li");
        dropDownOption.textContent = option.textContent;

        dropDownOption.addEventListener("mousedown", (e) => {
          e.stopPropagation();
          select.value = option.value;
          selector.value = option.value;
          select.dispatchEvent(new Event("change"));
          selector.dispatchEvent(new Event("change"));
          dropDown.remove();
        });

        dropDown.appendChild(dropDownOption);
      });

      selector.appendChild(dropDown);

      document.addEventListener("click", (e) => {
        if (!selector.contains(e.target)) {
          dropDown.remove();
        }
      });
    });
  }
}

//-----------------------------Formulaire préremplis-------------------------------//

jQuery(document).ready(function ($) {
  // Récupérer le bouton "Contact" et le champ "Réf.photo"
  const contactBtn = $(".contactbtn");
  const refPhotoInput = $('[name="ref-photo"]');

  contactBtn.on("click", function () {
    // Récupérer la référence de la photo depuis l'attribut "data-photo-reference"
    const photoReference = $(this).data("photo-reference");

    // Remplir le champ "Réf.photo" avec la référence de la photo
    refPhotoInput.val(photoReference);
  });
});

//-----------------------------Affichage lightbox-------------------------------//

document.addEventListener("DOMContentLoaded", function () {
  // Sélectionne tous les éléments avec la classe '.thickbox'
  var thickboxIcons = document.querySelectorAll(".thickbox");

  // Parcourt chaque icône '.thickbox'
  thickboxIcons.forEach(function (icon) {
    icon.addEventListener("click", function (e) {
      e.preventDefault();

      // Récupère l'élément parent
      var imageContainer = icon.closest(".image-container");

      // Récupère l'URL de l'image en tant qu'arrière-plan de l'élément parent
      var fullImageURL = getComputedStyle(imageContainer)
        .backgroundImage.replace('url("', "")
        .replace('")', "");

      // Récupère la référence et la catégorie de la photo à partir des attributs de l'élément '.image-container'
      var photoReference = imageContainer.getAttribute("data-reference");
      var photoCategoryElement =
        imageContainer.querySelector(".photo-category");
      var photoCategory = photoCategoryElement
        ? photoCategoryElement.textContent
        : ""; // Vérifie si .photo-category existe

      // Sélectionne tous les éléments '.image-container' pour créer une galerie
      var galleryImages = document.querySelectorAll(".image-container");
      var galleryItems = [];
      var currentIndex = 0;

      // Parcourt chaque élément '.image-container' pour construire un tableau d'URL d'images (galerie) et déterminer l'index de l'image actuellement affichée
      galleryImages.forEach(function (image, index) {
        var imageURL = getComputedStyle(image)
          .backgroundImage.replace('url("', "")
          .replace('")', "");
        galleryItems.push(imageURL);

        // Trouve l'index de l'image actuellement affichée dans la galerie
        if (imageURL === fullImageURL) {
          currentIndex = index;
        }
      });

      // Affiche la boîte modale (thickbox) avec les informations de l'image actuelle
      showThickbox(
        fullImageURL,
        photoReference,
        photoCategory,
        currentIndex,
        galleryImages,
        galleryItems
      );
    });
  });
});

// Fonction pour afficher la boîte modale (thickbox) avec les informations de l'image
function showThickbox(
  imageURL,
  reference,
  category,
  currentIndex,
  galleryImages,
  galleryItems
) {
  // Création de la modale overlay
  // Crée l'élément overlay pour la boîte modale
  var overlay = document.createElement("div");
  overlay.classList.add("thickbox-overlay");

  // Crée le conteneur principal de la boîte modale
  var container = document.createElement("div");
  container.classList.add("thickbox-container");

  // Crée le bouton de fermeture de la boîte modale
  var closeButton = document.createElement("span");
  closeButton.classList.add("thickbox-close");
  closeButton.innerHTML = "&#10005;";
  closeButton.addEventListener("click", function () {
    // Ferme la boîte modale en supprimant l'élément overlay
    document.body.removeChild(overlay);
  });

  // Crée l'élément image pour afficher l'image sélectionnée
  var imageElement = document.createElement("img");
  imageElement.src = imageURL;
  container.appendChild(imageElement);

  // Crée l'élément info pour afficher la référence et la catégorie de la photo
  var infoElement = document.createElement("div");
  infoElement.classList.add("thickbox-info");
  infoElement.innerHTML =
    '<p class="photo-reference">' +
    reference +
    '</p><h4 class="photo-category">' +
    category +
    "</h4>";
  container.appendChild(infoElement);

  // Crée les flèches de navigation (précédent et suivant) pour parcourir la galerie
  var prevArrow = document.createElement("span");
  prevArrow.classList.add("thickbox-prev");
  prevArrow.innerHTML =
    '<img src="http://localhost/p11/wp-content/uploads/2023/08/Line-7-3.png" alt="Précédent" class="arrow-image"> <span class="arrow-text">Précédent</span>';
  prevArrow.addEventListener("click", function () {
    // Affiche l'image précédente de la galerie
    currentIndex =
      (currentIndex - 1 + galleryItems.length) % galleryItems.length;
    imageElement.src = galleryItems[currentIndex];
    reference = galleryImages[currentIndex].getAttribute("data-reference");
    category =
      galleryImages[currentIndex].querySelector(".photo-category").textContent;
    infoElement.innerHTML =
      '<p class="photo-reference">' +
      reference +
      '</p><h4 class="photo-category">' +
      category +
      "</h4>";
  });

  var nextArrow = document.createElement("span");
  nextArrow.classList.add("thickbox-next");
  nextArrow.innerHTML =
    '<span class="arrow-text">Suivant</span> <img src="http://localhost/p11/wp-content/uploads/2023/08/Line-7-2.png" alt="Suivant" class="arrow-image">';
  nextArrow.addEventListener("click", function () {
    // Affiche l'image suivante de la galerie
    currentIndex = (currentIndex + 1) % galleryItems.length;
    imageElement.src = galleryItems[currentIndex];
    reference = galleryImages[currentIndex].getAttribute("data-reference");
    category =
      galleryImages[currentIndex].querySelector(".photo-category").textContent;
    infoElement.innerHTML =
      '<p class="photo-reference">' +
      reference +
      '</p><h4 class="photo-category">' +
      category +
      "</h4>";
  });

  // Ajoute les flèches de navigation 
  container.appendChild(prevArrow);
  container.appendChild(nextArrow);
  // Ajoute tous les éléments créés à l'overlay pour afficher la boîte modale complète
  overlay.appendChild(container);
  overlay.appendChild(closeButton);
  // Ajoute l'overlay au corps (body) du document pour afficher la boîte modale
  document.body.appendChild(overlay);
}

//-----------------------------Initialiser la thickbox pour les nouvelles photos-------------------------------//

function initializeThickbox() {
  var thickboxIcons = document.querySelectorAll(".thickbox");

  thickboxIcons.forEach(function (icon) {
    icon.addEventListener("click", function (e) {
      e.preventDefault();

      // Vérifie si la thickbox est déjà initialisée pour cette image
      if (icon.getAttribute("data-thickbox-initialized") === "true") {
        return; // Ne pas initialiser à nouveau si déjà initialisé
      }

      // Récupére tous les élements
      var imageContainer = icon.closest(".image-container");
      var fullImageURL = getComputedStyle(imageContainer)
        .backgroundImage.replace('url("', "")
        .replace('")', "");

      var photoReference = imageContainer.getAttribute("data-reference");
      var photoCategory =
        imageContainer.querySelector(".photo-category").textContent;

      var galleryImages = document.querySelectorAll(".image-container");
      var galleryItems = [];
      var currentIndex = 0;

      galleryImages.forEach(function (image, index) {
        var imageURL = getComputedStyle(image)
          .backgroundImage.replace('url("', "")
          .replace('")', "");
        galleryItems.push(imageURL);

        if (imageURL === fullImageURL) {
          currentIndex = index;
        }
      });

      // Marque l'icône comme étant initialisée pour éviter la duplication
      icon.setAttribute("data-thickbox-initialized", "true");

      showThickbox(
        fullImageURL,
        photoReference,
        photoCategory,
        currentIndex,
        galleryImages,
        galleryItems
      );
    });
  });
}

//-----------------------------Carrosel-------------------------------//

var images = document.querySelectorAll(".carousel-image");
var currentIndex = 0;

function showImage(index) {
  // Masquer toutes les images
  images.forEach(function (image) {
    image.style.display = "none";
  });
  // Afficher l'image à l'index donné
  images[index].style.display = "block";
  currentIndex = index;
}

// Si l'ID de l'image correspond à l'ID de la photo actuelle, exclure cette image du carrousel
images.forEach(function (image, index) {
  var imageId = parseInt(image.dataset.photoId);
  if (imageId === currentPhotoId) {
    image.style.display = "none";
  }
});

// Afficher l'image par défaut
showImage(currentIndex);

function navigateCarousel(direction) {
  // Calculer l'index de l'image suivante ou précédente
  if (direction === "prev") {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
  } else if (direction === "next") {
    currentIndex = (currentIndex + 1) % images.length;
  }
  showImage(currentIndex);
}

