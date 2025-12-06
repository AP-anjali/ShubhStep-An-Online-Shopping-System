<header>


    <div class="header-main">

      <div class="container">

        <a href="/" class="header-logo">
          <img src = "{{ asset('img/logo.png') }}" alt="shubhstep logo" width="220" height="43">
          <!-- <div class = "logo_text">SHUBH<span>STEP</span></div> -->
        </a>

        <div class="header-search-container">

          <input type="search" id="searchBox" name="search" class="search-field" oninput = "filterproducts3()" placeholder="Search product here...">

          <button class="search-btn" onclick = "filterproducts2()">
            <ion-icon name="search-outline"></ion-icon>
          </button>

        </div>

        <div class="header-user-actions">      

        @if(Session::has('customer_session'))
            <button class="action-btn myhover" onclick = "window.location.href = '/customer-orders'" style = "background : #8789ff; opacity: 0.9; color : white; font-size : 1.6rem; border-radius: 8px;">
              <ion-icon name="bag-handle-outline"></ion-icon>
            </button>

            <button class="action-btn myhover" onclick = "window.location.href = '/customer-wishlist'" style = "background : #8789ff; opacity: 0.9; color : white; font-size : 1.6rem; border-radius: 8px;">
              <ion-icon name="heart-outline"></ion-icon>

              @if(isset($customer_session))
                <span class="count">{{ $productCountWhishlist }}</span>
              @endif
            </button>

            <button class="action-btn myhover" onclick = "window.location.href = '/customer-cart'" style = "background : #8789ff; opacity: 0.9; color : white; font-size : 1.6rem; border-radius: 8px;">
              <ion-icon name="cart-outline"></ion-icon>

              @if(isset($customer_session))
                <span class="count">{{ $productCount }}</span>
              @endif
            </button>

            <!-- <button class="action-btn myhover" onclick = "window.location.href = '/customer-account'" style = "background : #8789ff; opacity: 0.9; color : white; font-size : 1.6rem; border-radius: 8px;">
              <ion-icon name="person-outline"></ion-icon>
            </button> -->

            <a class="not_logged_in_user" href="{{ route('customer_dashboard') }}">
              <div style = "font-size: 21px; font-weight: 500; display : flex;">
                {{ explode(' ', $customer_session->name)[0] }} 
                <i class="fa-solid fa-sort-down" style = "margin-left : 0.7rem;"></i>
              </div>
            </a>
          @elseif(Session::has('admin_session'))
            <a class="not_logged_in_user" href="{{ route('admin_dashboard') }}">
              <div style = "font-size: 21px; font-weight: 500;">Dashboard</div>
            </a>
          @else
            <a class="not_logged_in_user" href="{{ route('customer_login_registration_page') }}">
              <div style = "font-size: 21px; font-weight: 500;">Entry Point</div>
            </a>
          @endif

        </div>

      </div>

    </div>

    <nav class="desktop-navigation-menu">

      <div class="container">

        <ul class="desktop-menu-category-list">

          <li class="menu-category">
            <a href="{{ route('main_initial_page') }}" class="menu-title">shubhstep Home</a>
          </li>

          <li class="menu-category">
            <a href="#" class="menu-title">All Events</a>

            <div class="dropdown-panel">

            @if(isset($allEvents))
              @if(count($allEvents) > 0)
                @foreach($allEvents as $eachEvent)
                  @if($eachEvent->subEvents->isNotEmpty())
                    <ul class="dropdown-panel-list">

                      <li class="menu-title">
                        <a style = "pointer-events : none;">{{ $eachEvent->event_name }}</a>
                      </li>


                        @foreach($eachEvent->subEvents as $subEvent)
                          @if($subEvent->is_active == '1')
                            <li class="panel-list-item">
                              <a style = "cursor : pointer;" onclick = "window.location.href = '/Event/{{$subEvent->event->event_name}}/{{$subEvent->sub_event_name}}/{{$subEvent->id}}'" >{{ $subEvent->sub_event_name }}</a>
                            </li>
                          @endif
                        @endforeach

                    </ul>
                  @endif
                @endforeach
              @else
                <div style = "font-size : 16px; white-space : nowrap; color : #343434; width : 100%; text-align : center; "><b><i>There is no any data to show !</i></b></div>
              @endif
            @endif

            </div>

          </li>

          @if(isset($EventsWithLimit))
              @if(count($EventsWithLimit) > 0)
                @foreach($EventsWithLimit as $eachEvent)
                  <li class="menu-category">
                    <a style = "cursor : pointer;" class="menu-title">{{ $eachEvent->event_name }}</a>

                    @if($eachEvent->subEvents->isNotEmpty())

                        <ul class="dropdown-list">

                          @foreach($eachEvent->subEvents as $subEvent)

                            @if($subEvent->is_active == '1')
                              <li class="dropdown-item">
                                <a style = "cursor : pointer;" onclick = "window.location.href = '/Event/{{$subEvent->event->event_name}}/{{$subEvent->sub_event_name}}/{{$subEvent->id}}'" >{{ $subEvent->sub_event_name }}</a>
                              </li>
                            @endif

                          @endforeach
                        </ul>
                    @endif
                  </li>
                @endforeach
              @endif
          @endif

        </ul>

      </div>

    </nav>

    <div class="mobile-bottom-navigation">

      <button class="action-btn" data-mobile-menu-open-btn>
        <ion-icon name="menu-outline"></ion-icon>
      </button>
      
      <button class="action-btn" id = "openEventSidebarBtn" data-mobile-menu-open-btn>
        <ion-icon name="grid-outline"></ion-icon>
      </button>

      <button class="action-btn" onclick = "window.location.href = '/customer-orders'">
        <ion-icon name="bag-handle-outline"></ion-icon>
      </button>

      <button class="action-btn" onclick = "window.location.href = '/'">
        <ion-icon name="home-outline"></ion-icon>
      </button>

      <button class="action-btn" onclick = "window.location.href = '/customer-cart'">
        <ion-icon name="cart-outline"></ion-icon>

        @if(isset($customer_session))
          <span class="count">{{ $productCount }}</span>
        @endif
      </button>

      <button class="action-btn" onclick = "window.location.href = '/customer-wishlist'">
        <ion-icon name="heart-outline"></ion-icon>

        @if(isset($customer_session))
          <span class="count">{{ $productCountWhishlist }}</span>
        @endif
      </button>

      <!-- <button class="action-btn">
        <ion-icon name="cart-outline"></ion-icon>

        <span class="count">0</span>
      </button> -->

      @if(isset($customer_session))
        <button class="action-btn" onclick = "window.location.href = '/customer-dashboard'">
          <ion-icon name="person-outline"></ion-icon>
        </button>
      @elseif(isset($admin_session))
        <button class="action-btn" onclick = "window.location.href = '/admin-dashboard'">
          <ion-icon name="person-outline"></ion-icon>
        </button>
      @else
        <button class="action-btn" onclick = "window.location.href = '/login-registration'">
          <ion-icon name="person-outline"></ion-icon>
        </button>
      @endif

    </div>

    <nav class="mobile-navigation-menu  has-scrollbar" data-mobile-menu>

      <div class="menu-top">
        <h2 class="menu-title">Menu</h2>

        <button class="menu-close-btn" data-mobile-menu-close-btn>
          <ion-icon name="close-outline"></ion-icon>
        </button>
      </div>

      <ul class="mobile-menu-category-list">

        <li class="menu-category">
          <a href="{{ route('main_initial_page') }}" class="menu-title">Shubhstep Home</a>
        </li>

            @if(isset($EventsWithLimit))
              @if(count($EventsWithLimit) > 0)
                @foreach($EventsWithLimit as $eachEvent)
                  <li class="menu-category">

                    <button class="accordion-menu" data-accordion-btn>
                      <p class="menu-title">{{ $eachEvent->event_name }}</p>

                      @if($eachEvent->subEvents->isNotEmpty())
                        <div>
                          <ion-icon name="add-outline" class="add-icon"></ion-icon>
                          <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                        </div>
                      @endif

                    </button>

                    @if($eachEvent->subEvents->isNotEmpty())

                      <ul class="submenu-category-list" data-accordion>

                        @foreach($eachEvent->subEvents as $subEvent)

                          @if($subEvent->is_active == '1')
                            <li class="submenu-category">
                              <a style = "cursor : pointer;" onclick = "window.location.href = '/Event/{{$subEvent->event->event_name}}/{{$subEvent->sub_event_name}}/{{$subEvent->id}}'" class="submenu-title">{{ $subEvent->sub_event_name }}</a>
                            </li>
                          @endif

                        @endforeach

                      </ul>
                    
                    @endif

                  </li>
                @endforeach
              @endif
            @endif

      </ul>

    </nav>

  </header>