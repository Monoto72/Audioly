
    const storeHTML = document.querySelector('html');
    const storeBody = document.querySelector('body');
    const imageModal = document.querySelector('.imageOverlay');

    let imageOverlay = false;

    const storeImages = document.querySelectorAll('table img').forEach(img => {
        img.addEventListener('click', () => {
            imageModal.classList.remove('hidden');
            imageModal.classList.add('flex');

            imageOverlay = true;

            storeBody.classList.add('overflow-y-hidden');

            imageModal.querySelector('img').src = img.src;
        });
    });

    const storeImageButton = imageModal.querySelector('button').addEventListener('click', () => {
        imageModal.classList.add('hidden');
        imageModal.classList.remove('flex');

        imageOverlay = false;

        storeBody.classList.remove('overflow-y-hidden');
    });

    const checkoutModal = document.querySelector('.checkout');

    let checkoutOverlay = false;

    const checkoutButtons = document.querySelectorAll('table button').forEach(button => {
        button.addEventListener('click', () => {
            if (button.value != "update") {
                checkoutModal.classList.remove('hidden');
                checkoutModal.classList.add('flex');

                checkoutOverlay = true;

                storeBody.classList.add('overflow-y-hidden');

                checkoutModal.querySelector('#slug').value = button.value;
            }
        });
    });

    const checkoutButton = checkoutModal.querySelector('.checkout-close').addEventListener('click', () => {
        console.log('close');
        checkoutModal.classList.add('hidden');
        checkoutModal.classList.remove('flex');

        checkoutOverlay = false;

        storeBody.classList.remove('overflow-y-hidden');
    });