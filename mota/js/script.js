jQuery(document).ready(function ($) {


    // Afficher la popup lorsque les éléments avec la classe 'contact-link' sont cliqués
    $('.contact-link').on('click', function (e) {
        e.preventDefault();
        $('#refPhoto').val('');
        $('#contact-popup').fadeIn();
    });

    // Afficher la popup lorsque les éléments avec la classe 'contact-link-mobile' sont cliqués
    $('.contact-link-mobile').on('click', function (e) {
        e.preventDefault();
        $('#refPhoto').val('');
        $('#contact-popup').fadeIn();
    });

    // Afficher la popup lorsque le bouton 'contact_button' est cliqué
    $('.contact_button').on('click', function (event) {
        event.preventDefault();
        var photoReference = $(this).data('photo-ref');
        $('#refPhoto').val(photoReference);
        $('#contact-popup').fadeIn();
    });

    // Fermer la popup lorsque le bouton de fermeture est cliqué
    $('#close-popup').on('click', function () {
        $('#contact-popup').fadeOut();
    });

    // Fermer la popup en cliquant en dehors de la fenêtre
    $(document).mouseup(function (e) {
        var popupContent = $(".popup-salon");
        if (!popupContent.is(e.target) && popupContent.has(e.target).length === 0) {
            $('#contact-popup').fadeOut();
        }
    });
});


/* Menu BURGER */
document.addEventListener('DOMContentLoaded', function () {
    const burgerButton = document.querySelector('.burger_button');
    const fullscreenMenu = document.querySelector('.fullscreen_menu');
    const body = document.querySelector('body');

    if (burgerButton && fullscreenMenu && body) {
        burgerButton.addEventListener('click', function () {
            fullscreenMenu.classList.toggle('is-visible');
            body.classList.toggle('no-scroll');
            burgerButton.classList.toggle('active');
        });
    }
});
