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
              <a href="{{ route('admin_dashboard') }}" class="nav-link"><i data-feather="grid"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
              <a href="{{ route('main_initial_page') }}" class="nav-link"><i data-feather="home"></i><span>Home Page</span></a>
            </li>

            <li class="menu-header">CONTENT MANAGEMENT</li>

            <li class="dropdown" id = "Events">
              <a href="{{ route('admin_dahboard_events_page') }}" class="nav-link"><i data-feather="list"></i><span>Events</span></a>
            </li>

            <li class="dropdown" id = "Sub_events">
              <a href="{{ route('admin_dahboard_sub_events_page') }}" class="nav-link"><i data-feather="edit-3"></i><span>Sub-events</span></a>
            </li>

            <li class="dropdown" id = "Products">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="file-text"></i><span>Products</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('admin_dashboard_add_products_page') }}" id = "add_product">Add Product</a></li>
                <li><a class="nav-link" href="{{ route('admin_dashboard_all_products_page') }}" id = "Uploded_product">Uploaded Products</a></li>
              </ul>
            </li>

            <li class="menu-header">Orders MANAGEMENT</li>

            <li class="dropdown" id = "orders">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="shopping-bag"></i><span>Orders</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('admin_new_orders') }}" id = "New_Record">New Orders</a></li>
                <li><a class="nav-link" href="{{ route('admin_cancelled_orders') }}" id = "Cancelled_Record">Cancelled Orders</a></li>
                <li><a class="nav-link" href="{{ route('admin_rejected_orders') }}" id = "Rejected_Record">Rejected Orders</a></li>
                <li><a class="nav-link" href="{{ route('admin_accepted_orders') }}" id = "Accpted_Record">Accpted Orders</a></li>
                <li><a class="nav-link" href="{{ route('admin_ready_orders') }}" id = "Ready_Record">Ready Orders</a></li>
                <li><a class="nav-link" href="{{ route('admin_completed_orders') }}" id = "Completed_Record">Completed Orders</a></li>
              </ul>
            </li>

            <li class="dropdown" id = "Exchnage_Request">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="refresh-cw"></i><span>Exchnage Request</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('admin_new_exchange_request') }}" id = "Exchange_New_Request">New Request</a></li>
                <li><a class="nav-link" href="{{ route('admin_accepted_exchange_request') }}" id = "Exchange_Accepted_Request">Accepted Request</a></li>
                <li><a class="nav-link" href="{{ route('admin_exchanged_orders') }}" id = "Exchanged_Record">Exchanged Orders</a></li>
              </ul>
            </li>

            <li class="dropdown" id = "Return_Request">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="rotate-cw"></i><span>Return Request</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('admin_new_return_request') }}" id = "return_New_Request">New Request</a></li>
                <li><a class="nav-link" href="{{ route('admin_accepted_return_request') }}" id = "return_Accepted_Request">Accepted Request</a></li>
                <li><a class="nav-link" href="{{ route('admin_returned_orders') }}" id = "returned_Record">Returned Orders</a></li>
              </ul>
            </li>

            <li class="dropdown" id = "Orders_Feedbacks">
              <a href="{{ route('orders_feedback') }}" class="nav-link"><i data-feather="gift"></i><span>Orders Feedbacks</span></a>
            </li>

            <li class="menu-header">Plateform MANAGEMENT</li>

            <li class="dropdown" id = "Contact_Mails">
              <a href="{{ route('contact_mails') }}" class="nav-link"><i data-feather="mail"></i><span>Contact Mails</span></a>
            </li>

            <li class="dropdown" id = "Plateform_Feedback">
              <a href="{{ route('platform_feedback') }}" class="nav-link"><i data-feather="heart"></i><span>Platform Feedbacks</span></a>
            </li>

            <li class="dropdown" id = "Customer_support_Mails">
              <a href="{{ route('customer_support_mails') }}" class="nav-link"><i data-feather="at-sign"></i><span>Customer Support Mails</span></a>
            </li>


            <li class="menu-header">Account Settings</li>

            <li class="dropdown" id = "profile">
              <a href="{{ route('admin_account') }}" class="nav-link"><i data-feather="user"></i><span>Profile</span></a>
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