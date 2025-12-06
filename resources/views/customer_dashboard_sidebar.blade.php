      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          
          <div class="sidebar-brand" id = "forFullWidth">
            <a href="/"> <img alt="image" src="./assets/images/logo/icon.png" id = "icon_img" class="header-logo" /> <span
                class="logo-name"><img alt="image" src="./assets/images/logo/logo.png" class="header-logo" id = "logo_img" /></span>
            </a>
          </div>

          <div class="sidebar-brand" id = "forSmallWidth">
            <a href="/"><span class="logo-name"><img alt="image" src="./assets/images/logo/logo.png" class="header-logo" /></span>
            </a>
          </div>

          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown" id = "dashboard">
              <a href="{{ route('customer_dashboard') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
              <a href="{{ route('main_initial_page') }}" class="nav-link"><i data-feather="home"></i><span>Home Page</span></a>
            </li>

            <li class="dropdown" id = "cart">
              <a href="{{ route('customer_cart') }}" class="nav-link"><i data-feather="shopping-cart"></i><span>Cart</span></a>
            </li>

            <li class="dropdown" id = "wishlist">
              <a href="{{ route('customer_wishlist') }}" class="nav-link"><i data-feather="heart"></i><span>Wishlist</span></a>
            </li>

            <li class="dropdown" id = "orders">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="shopping-bag"></i><span>Orders</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('customer_orders') }}" id = "Orders_Record">New Orders</a></li>
                <li><a class="nav-link" href="{{ route('cancelled_orders') }}" id = "Cancelled_Record">Cancelled Orders</a></li>
                <li><a class="nav-link" href="{{ route('rejected_orders') }}" id = "Rejected_Record">Rejected Orders</a></li>
                <li><a class="nav-link" href="{{ route('completed_orders') }}" id = "Completed_Record">Completed Orders</a></li>
              </ul>
            </li>

            <li class="dropdown" id = "Exchnage_Request">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="refresh-cw"></i><span>Exchange Request</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('customer_new_exchange_request') }}" id = "new_exchange_requests">New Requests</a></li>
                <li><a class="nav-link" href="{{ route('exchanged_orders') }}" id = "Exchanged_Record">Exchanged Orders</a></li>
              </ul>
            </li>

            <li class="dropdown" id = "Return_Request">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="rotate-cw"></i><span>Return Request</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('customer_new_returne_request') }}" id = "new_return_requests">New Requests</a></li>
                <li><a class="nav-link" href="{{ route('returned_orders') }}" id = "Returned_Record">Returned Orders</a></li>
              </ul>
            </li>

            <li class="dropdown" id = "profile">
              <a href="{{ route('customer_account') }}" class="nav-link"><i data-feather="user"></i><span>Profile</span></a>
            </li>

            <li class="dropdown" id="swal-6">
              <a class="nav-link"><i data-feather="log-out"></i><span>Logout</span></a>
            </li>            

          </ul>
        </aside>
      </div>

      <script>

        let icon_img = document.getElementById('icon_img');
        let logo_img = document.getElementById('logo_img');

        icon_img.style.display = 'none';
        logo_img.style.display = 'inline-block';

        function karvaToDe() 
        {
          if (icon_img.style.display === 'none') {
              icon_img.style.display = 'inline-block';
              logo_img.style.display = 'none';
          } else {
              icon_img.style.display = 'none';
              logo_img.style.display = 'inline-block';
          }
        }
      </script>