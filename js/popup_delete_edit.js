// Gestion du menu admin (Modifier/Supprimer un billet)
const menuToggle = document.querySelector('.menu-toggle');
const menuList = document.querySelector('.display-menu-list-admin');

menuToggle.addEventListener('click', (e) => {
    e.preventDefault();
    menuList.style.display = menuList.style.display === 'flex' ? 'none' : 'flex';
});

document.addEventListener('click', (e) => {
    if (!menuList.contains(e.target) && !menuToggle.contains(e.target)) {
        menuList.style.display = 'none';
    }
});

// --- Popups ---
const popupDelete = document.querySelector('.popup-delete');
const popupEdit = document.querySelector('.popup-edit');

const deleteBtn = document.querySelector('.menu-admin .delete');
const editBtn = document.querySelector('.menu-admin .edit');

const closeBtns = document.querySelectorAll('.close-popup');
const cancelBtns = document.querySelectorAll('.cancel');

// Ouvrir popup supprimer
deleteBtn.addEventListener('click', (e) => {
    e.preventDefault();
    popupDelete.style.display = 'flex';
});

// Ouvrir popup modifier
editBtn.addEventListener('click', (e) => {
    e.preventDefault();
    popupEdit.style.display = 'flex';
});

// Fermer les popups
closeBtns.forEach(btn => btn.addEventListener('click', () => {
    popupDelete.style.display = 'none';
    popupEdit.style.display = 'none';
}));
cancelBtns.forEach(btn => btn.addEventListener('click', () => {
    popupDelete.style.display = 'none';
    popupEdit.style.display = 'none';
}));

// Fermer si clic à l’extérieur
window.addEventListener('click', (e) => {
    if (e.target === popupDelete) popupDelete.style.display = 'none';
    if (e.target === popupEdit) popupEdit.style.display = 'none';
});

// Afficher aperçu de l'image modifiée sur le popup de modification de billet
const imageInput = document.getElementById('image_edit');
const preview = document.createElement('img');
preview.style.display = 'none';
preview.style.maxWidth = '100%';
preview.style.marginTop = '10px';
imageInput.parentNode.appendChild(preview);

imageInput.addEventListener('change', () => {
    const file = imageInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});