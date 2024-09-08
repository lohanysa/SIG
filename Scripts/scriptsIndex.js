const galleryItems = document.querySelectorAll('.gallery-item');
let currentIndex = 0;

function showGalleryItem(index) {
    galleryItems.forEach((item, i) => {
        if (i === index) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

function nextGalleryItem() {
    currentIndex++;
    if (currentIndex >= galleryItems.length) {
        currentIndex = 0;
    }
    showGalleryItem(currentIndex);
}

setInterval(nextGalleryItem, 5000); // Cambiar imagen cada 5 segundos

galleryItems.forEach((item, index) => {
    item.addEventListener('click', () => {
        currentIndex = index;
        showGalleryItem(currentIndex);
    });
});