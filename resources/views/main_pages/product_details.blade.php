<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product_data->product_title }}</title>

    <link rel="shortcut icon" href="./assets/images/logo/icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cssfiles/main_style.css') }}">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
      .product-featured {
          padding: 1rem;
      }

      /* Lightbox styling */
      .lightbox {
          display: none;
          position: fixed;
          z-index: 10;
          padding-top: 60px;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          overflow: auto;
          background-color: rgba(0, 0, 0, 0.9);
      }

      .lightbox-content-container {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 80%;
          max-height: 80%;
      }

      .lightbox-content {
          max-width: 100%;
          max-height: 100%;
          object-fit: contain;
      }

      .lightbox-thumbnails {
          display: flex;
          justify-content: center;
          flex-wrap: wrap;
          gap: 10px;
          margin: 20px 0;
      }

      .lightbox-thumbnails img {
          height: 50px;
          cursor: pointer;
          border-radius: 8px;
          opacity: 0.6;
          transition: opacity 0.2s;
      }

      .lightbox-thumbnails img:hover {
          opacity: 1;
      }

      .close {
          position: absolute;
          top: 20px;
          right: 35px;
          color: #f1f1f1;
          font-size: 40px;
          font-weight: bold;
          transition: 0.3s;
          cursor: pointer;
      }

      .close:hover,
      .close:focus {
          color: #bbb;
          text-decoration: none;
          cursor: pointer;
      }

      .prev,
      .next {
          cursor: pointer;
          position: absolute;
          top: 50%;
          width: auto;
          padding: 16px;
          margin-top: -50px;
          color: white;
          font-weight: bold;
          font-size: 20px;
          transition: 0.3s;
          user-select: none;
          -webkit-user-select: none;
      }

      .prev {
          left: 0;
      }

      .next {
          right: 0;
      }

      .prev:hover,
      .next:hover {
          background-color: rgba(0, 0, 0, 0.8);
      }

      /* Ensure all images in the showcase are the same size */
      .showcase-img {
          height: auto;
          max-width: 100%;
          object-fit: cover;
      }

      .thumbnail-img {
          height: 80px;
          width: 80px;
          object-fit: cover;
          cursor: pointer;
          border-radius: 0.4rem;
          margin: 5px;
          transition: transform 0.2s;
      }

      .thumbnail-img:hover {
          transform: scale(1.05);
      }      
    </style>

</head>

<body>


  <div class="overlay" data-overlay></div>

    <!-- --- header [start] --- -->
    @include('main_pages.header_layout2')
    <!-- --- header [end] --- -->

    <!-- --- main_content [start] --- -->
    @include('main_pages.main_content2')
    <!-- --- main_content [end] --- -->

    <!-- --- footer [start] --- -->
    @include('main_pages.footer_layout2')
    <!-- --- footer [end] --- -->


  <script src="{{ asset('js/main_script.js') }}"></script>


  <!--- ionicon link -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  <script>
        document.addEventListener('DOMContentLoaded', () => {
        const lightbox = document.getElementById('lightbox');
        const lightboxContent = document.querySelector('.lightbox-content');
        const lightboxThumbnails = document.querySelector('.lightbox-thumbnails');
        const mainImage = document.getElementById('main-image');
        const images = document.querySelectorAll('.thumbnail-img');
        const closeBtn = document.querySelector('.close');
        const prevBtn = document.querySelector('.prev');
        const nextBtn = document.querySelector('.next');
        let currentIndex = 0;

        mainImage.addEventListener('click', () => {
            openLightbox(0);
        });

        images.forEach((img, index) => {
            img.addEventListener('click', () => {
                openLightbox(index + 1); // +1 to account for the main image
            });
        });

        function openLightbox(index) {
            lightbox.style.display = 'block';
            currentIndex = index;
            displayImage();
            displayThumbnails();
        }

        function closeLightbox() {
            lightbox.style.display = 'none';
        }

        function displayImage() {
            if (currentIndex === 0) {
                lightboxContent.src = mainImage.src;
            } else {
                lightboxContent.src = images[currentIndex - 1].src;
            }
        }

        function displayThumbnails() {
            lightboxThumbnails.innerHTML = '';
            const allImages = [mainImage, ...images];
            allImages.forEach((img, index) => {
                const thumbnail = document.createElement('img');
                thumbnail.src = img.src;
                thumbnail.addEventListener('click', () => {
                    currentIndex = index;
                    displayImage();
                });
                lightboxThumbnails.appendChild(thumbnail);
            });
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % (images.length + 1);
            displayImage();
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + images.length + 1) % (images.length + 1);
            displayImage();
        }

        closeBtn.addEventListener('click', closeLightbox);
        prevBtn.addEventListener('click', prevImage);
        nextBtn.addEventListener('click', nextImage);

        // Close lightbox on overlay click
        lightbox.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });
    });
  </script>

  <script>
    let EventSidebar = document.getElementById('EventSidebar');
    let openEventSidebarBtn = document.getElementById('openEventSidebarBtn');

    function openEventSidebar()
    {
        EventSidebar.style.display = "block";
        EventSidebar.style.transition = "0.5s ease";

        EventSidebar.style.opacity = 0;
        EventSidebar.style.visibility = "hidden";
    
        EventSidebar.offsetHeight;
        
        EventSidebar.style.opacity = 1;
        EventSidebar.style.visibility = "visible";
    }

    function closeEventSidebar() {
        EventSidebar.style.display = "none";
    }

    openEventSidebarBtn.addEventListener('click', function(event) {
        event.stopPropagation(); 
        openEventSidebar();
    });

    document.addEventListener('click', function() {
        closeEventSidebar();
    });

    EventSidebar.addEventListener('click', function(event) {
        event.stopPropagation(); 
    });

  </script>

  <script>
    const modal = document.querySelector('[data-modal]');
    const modalCloseBtn = document.querySelector('[data-modal-close]');
    const modalCloseOverlay = document.querySelector('[data-modal-overlay]');

    const modalCloseFunc = function () { modal.classList.add('closed') }

    modalCloseOverlay.addEventListener('click', modalCloseFunc);
    modalCloseBtn.addEventListener('click', modalCloseFunc);

    // ----------------------
    const modal2 = document.querySelector('[data-modal2]');
    const modalCloseBtn2 = document.querySelector('[data-modal-close2]');
    const modalCloseOverlay2 = document.querySelector('[data-modal-overlay2]');

    const modalCloseFunc2 = function () { modal2.classList.add('closed') }

    modalCloseOverlay2.addEventListener('click', modalCloseFunc2);
    modalCloseBtn2.addEventListener('click', modalCloseFunc2);
    // ----------------------

    // ----------------------
    const modal3 = document.querySelector('[data-modal3]');
    const modalCloseBtn3 = document.querySelector('[data-modal-close3]');
    const modalCloseOverlay3 = document.querySelector('[data-modal-overlay3]');

    const modalCloseFunc3 = function () { modal3.classList.add('closed') }

    modalCloseOverlay3.addEventListener('click', modalCloseFunc3);
    modalCloseBtn3.addEventListener('click', modalCloseFunc3);
    // ----------------------

    function openWhishlist(index) {
      document.getElementById('wishlist_pop_up_' + index).classList.remove('closed');
    }

    function openCart(index) {
      document.getElementById('cart_pop_up_' + index).classList.remove('closed');
    }

    function openBuyNow(index) {
      document.getElementById('buy_now_pop_up_' + index).classList.remove('closed');
    }

    function openCart2() {
      document.getElementById('cart_pop_up').classList.remove('closed');
    }

    function openWhishlist2() {
      document.getElementById('wishlist_pop_up').classList.remove('closed');
    }

    function openBuyNow2() {
      document.getElementById('buy_now_pop_up').classList.remove('closed');
    }

    document.querySelectorAll('[data-modal-close]').forEach(btn => {
      btn.addEventListener('click', function() {
        this.closest('.modal').classList.add('closed');
      });
    });

    document.querySelectorAll('[data-modal-overlay]').forEach(overlay => {
      overlay.addEventListener('click', function() {
        this.closest('.modal').classList.add('closed');
      });
    });

    // --------------------------------

    document.querySelectorAll('[data-modal-close2]').forEach(btn => {
      btn.addEventListener('click', function() {
        this.closest('.modal').classList.add('closed');
      });
    });

    document.querySelectorAll('[data-modal-overlay2]').forEach(overlay => {
      overlay.addEventListener('click', function() {
        this.closest('.modal').classList.add('closed');
      });
    });

    // --------------------------------

    document.querySelectorAll('[data-modal-close3]').forEach(btn => {
      btn.addEventListener('click', function() {
        this.closest('.modal').classList.add('closed');
      });
    });

    document.querySelectorAll('[data-modal-overlay3]').forEach(overlay => {
      overlay.addEventListener('click', function() {
        this.closest('.modal').classList.add('closed');
      });
    });
  </script>

</body>

</html>