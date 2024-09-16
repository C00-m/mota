jQuery(document).ready(function ($) {
    var photoContainer = document.getElementById('photo-container');
    var loadMoreButton = document.getElementById('load-more-photos');
    var currentPage = 1;
    var isLoading = false;

    function loadPhotos(page, append = true) {
        if (isLoading) return;
        isLoading = true;

        var category = $('#photo-category-filter').val() || '';
        var format = $('#photo-format-filter').val() || '';
        var sort = $('#photo-sort').val() || 'date_desc';

        fetch(`${wp_vars.ajax_url}?action=load_photos&page=${page}&category=${category}&format=${format}&sort=${sort}`)
            .then((response) => {
                if (!response.ok) {
                    console.error("Erreur lors de la requête AJAX:", response.status, response.statusText);
                    isLoading = false;
                    return;
                }

                return response.json();
            })
            .then((data) => {
                if (!data || !data.html) {
                    console.error("Données incorrectes retournées par AJAX.");
                    isLoading = false;
                    return;
                }

                if (append) {
                    photoContainer.innerHTML += data.html;
                } else {
                    photoContainer.innerHTML = data.html;
                }


                if (data.has_more === false) {
                    loadMoreButton.style.display = 'none';
                } else {
                    loadMoreButton.style.display = 'block';
                }

                isLoading = false;
            })
            .catch((error) => {
                console.error("Erreur lors du chargement des photos:", error);
                isLoading = false;
            });
    }


    loadPhotos(currentPage, false);


    loadMoreButton.addEventListener('click', function () {
        currentPage++;
        loadPhotos(currentPage, true);
    });


    $('#photo-category-filter').select2();
    $('#photo-format-filter').select2();
    $('#photo-sort').select2();

    // Gestion des filtres
    $('#photo-category-filter').on('change', function () {
        currentPage = 1;
        loadPhotos(currentPage, false);
    });

    $('#photo-format-filter').on('change', function () {
        currentPage = 1;
        loadPhotos(currentPage, false);
    });

    $('#photo-sort').on('change', function () {
        currentPage = 1;
        loadPhotos(currentPage, false);
    });
});
