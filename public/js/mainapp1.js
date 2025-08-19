
document.addEventListener('DOMContentLoaded', function () {
    // Handle stacked modals z-index & backdrop
    document.body.addEventListener('show.bs.modal', function (event) {
        var modal = event.target;
        var openModals = document.querySelectorAll('.modal.show');

        if (openModals.length > 0) {
            openModals.forEach(function (openModal) {
                if (openModal !== modal) {
                    document.body.classList.add('modal-stack');

                    // Adjust z-index for stacking
                    var count = openModals.length;
                    openModal.style.zIndex = 1040 + count * 10;
                    modal.style.zIndex = 1050 + count * 10;

                    // Adjust backdrop z-index
                    var modalBackdrop = document.querySelector('.modal-backdrop');
                    if (modalBackdrop) {
                        modalBackdrop.style.zIndex = 1039 + count * 10;
                    }
                }
            });
        }
    });

    document.body.addEventListener('hidden.bs.modal', function () {
        if (document.querySelectorAll('.modal.show').length === 0) {
            document.body.classList.remove('modal-stack');
        }
    });

    // Zoom modal logic
    var imageZoomModal = document.getElementById('imageZoomModal');
    var zoomedImage = document.getElementById('zoomedImage');

    imageZoomModal.addEventListener('show.bs.modal', function (event) {
        var triggerImg = event.relatedTarget;
        var src = triggerImg.getAttribute('data-image-src');
        zoomedImage.src = src;
        zoomedImage.alt = triggerImg.alt;

        // Keep body scroll if another modal is open
        var openModal = document.querySelector('.modal.show:not(#imageZoomModal)');
        if (openModal) {
            document.body.classList.add('modal-open');
        }
    });

    imageZoomModal.addEventListener('hidden.bs.modal', function () {
        zoomedImage.src = '';
        zoomedImage.alt = '';

        var stillOpenModal = document.querySelector('.modal.show');
        if (!stillOpenModal) {
            document.body.classList.remove('modal-open');
        }
    });
});

