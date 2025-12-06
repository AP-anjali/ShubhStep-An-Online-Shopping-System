<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHUBHSTEP | ABOUT US</title>

    <link rel="shortcut icon" href="./assets/images/logo/icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cssfiles/main_style.css') }}">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body>


  <div class="overlay" data-overlay></div>

    <!-- --- header [start] --- -->
    @include('main_pages.header_layout2')
    <!-- --- header [end] --- -->

    <!-- --- main_content [start] --- -->
    @include('main_pages.about_us_CONTENT')
    <!-- --- main_content [end] --- -->

    <!-- --- footer [start] --- -->
    @include('main_pages.footer_layout2')
    <!-- --- footer [end] --- -->


  <script src="{{ asset('js/main_script.js') }}"></script>


  <!--- ionicon link -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

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