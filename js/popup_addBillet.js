document.addEventListener('DOMContentLoaded', function() {
    let popupAddBillet = document.querySelector('.popup-add-billet');
    let addBilletBtn = document.querySelector('.add-billet span');
    let closePopupBtn = document.querySelector('.popup-add-billet .popup-content .close-popup');

    // Close the popup when clicking the close button
    closePopupBtn.addEventListener('click', function() {
        popupAddBillet.style.display = 'none';
        // Réactive le scroll sur la page principale
        document.body.style.overflow = 'auto';
    });

    addBilletBtn.addEventListener('click', function() {
        popupAddBillet.style.display = 'block';
        // Désactive le scroll sur la page principale
        document.body.style.overflow = 'hidden';

    });
   
});