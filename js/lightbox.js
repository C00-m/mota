/* Lightbox */

document.addEventListener('DOMContentLoaded', function () {
    let currentPhotoIndex = 0;
    let filteredPhotos = [];

    function attachEventListeners() {
        const photEyeElements = document.querySelectorAll('.photEye');
        photEyeElements.forEach(function (photEye, index) {
            photEye.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();

                const lightbox = document.getElementById('lightbox');
                lightbox.style.display = 'block';

                const photoBlock = photEye.closest('.photo-block');
                if (photoBlock) {
                    const imageUrl = photoBlock.querySelector('img').getAttribute('src');
                    document.getElementById('lightbox-image').setAttribute('src', imageUrl);

                    const photoTitle = photoBlock.querySelector('.title_hov').textContent;
                    const photoCategory = photoBlock.querySelector('.categorie_hov').textContent;
                    const photoReference = getPhotoReference(photoBlock);

                    document.querySelector('.lightbox-ref').textContent = photoReference;
                    document.querySelector('.lightbox-cat').textContent = photoCategory;

                    currentPhotoIndex = index;
                    filteredPhotos = Array.from(document.querySelectorAll('.photo-block'));
                }
            });
        });
    }

    function getPhotoReference(photoBlock) {
        const referenceElement = photoBlock.querySelector('.reference');
        return referenceElement ? referenceElement.textContent : '';
    }

    function navigatePhotos(direction) {
        if (filteredPhotos.length > 0) {
            const prevIndex = currentPhotoIndex;
            currentPhotoIndex = (currentPhotoIndex + direction + filteredPhotos.length) % filteredPhotos.length;
            const newPhotoBlock = filteredPhotos[currentPhotoIndex];

            const newImageUrl = newPhotoBlock.querySelector('img').getAttribute('src');
            document.getElementById('lightbox-image').setAttribute('src', newImageUrl);

            const newPhotoTitle = newPhotoBlock.querySelector('.title_hov').textContent;
            const newPhotoCategory = newPhotoBlock.querySelector('.categorie_hov').textContent;
            const newPhotoReference = getPhotoReference(newPhotoBlock);

            document.querySelector('.lightbox-ref').textContent = newPhotoReference;
            document.querySelector('.lightbox-cat').textContent = newPhotoCategory;


            filteredPhotos[prevIndex].classList.remove('active');
            filteredPhotos[currentPhotoIndex].classList.add('active');
        }
    }

    attachEventListeners();

    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.addedNodes.length > 0) {
                attachEventListeners();
            }
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });

    document.querySelector('.close-lightbox').addEventListener('click', function () {
        document.getElementById('lightbox').style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        const lightbox = document.getElementById('lightbox');
        if (event.target === lightbox) {
            lightbox.style.display = 'none';
        }
    });

    document.querySelector('.lightbox-content').addEventListener('click', function (event) {
        event.stopPropagation();
    });

    document.querySelector('.prev').addEventListener('click', function () {
        navigatePhotos(-1);
    });

    document.querySelector('.next').addEventListener('click', function () {
        navigatePhotos(1);
    });
});




