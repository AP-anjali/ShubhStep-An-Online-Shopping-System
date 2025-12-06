<main>

    <!--
      - BANNER
    -->

    <div class="banner">

      <div class="container" id="container">

        <div class="slider-container has-scrollbar" id="slider-container">

          <div class="slider-item">

            <img src="./assets/images/banner/1.png" alt="women's latest fashion sale" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Trending items</p>

              <h2 class="banner-title">DISCOVER THE BEST DEALS</h2>

              <p class="banner-text">
                Find Your Perfect Fit
              </p>

              <a href = "/redirect-route" class="banner-btn">Shop now</a>

            </div>

          </div>

          <div class="slider-item">

            <img src="./assets/images/banner/2.png" alt="modern sunglasses" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">Safe Payments</p>

              <h2 class="banner-title">SECURE <br>& RELIABLE Transactions</h2>

              <p class="banner-text">
                By Razorpay Gateway
              </p>

              <a href = "/redirect-route" class="banner-btn">Shop now</a>

            </div>

          </div>

          <div class="slider-item">

            <img src="./assets/images/banner/3.png" alt="new fashion summer sale" class="banner-img">

            <div class="banner-content">

              <p class="banner-subtitle">More Reliability</p>

              <h2 class="banner-title">PAY AT YOUR DOORstep</h2>

              <p class="banner-text">
                Cash Payment On Delivery
              </p>

              <a href = "/redirect-route" class="banner-btn">Shop now</a>

            </div>

          </div>

        </div>
      
      </div>

    </div>

    
    <div class="product-container">

        <div id = "successScroll"></div>              

              @if (Session::has('success'))
                  <div style = "width : 100%;">
                    <div id = "msg_notification" style = "width : 80%; margin : auto;">
                        <div style="background: #4F9153; color: white; margin: auto; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                            <i class="fa-solid fa-circle-check" style="margin-right: 10px;"></i>
                            <span style="flex-grow: 1;">{{ Session::get('success') }}</span>
                            <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                        </div>
                        <br>
                    </div>
                  </div>
              @endif
          
              @if ($errors->any())
                  @foreach ($errors->all() as $index => $error)
                      <div style = "width : 100%;">
                        <div id = "msg_notification_{{ $index }}" style = "width : 80%; margin : auto;">
                            <div style="background: #FF474C; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #B22222; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                <span style="flex-grow: 1;">{{ $error }}</span>
                                <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification_{{ $index }}'); box.style.display = 'none';" id = "close--btn2"></i>
                            </div>
                            <br>
                        </div>
                      </div>
                  @endforeach
              @endif

        <div class="container">

            <div id = "EventSidebar" class="sidebar  has-scrollbar" style = "display : none;" data-mobile-menu>

                <div class="sidebar-category">

                    <div class="sidebar-top">
                    <h2 class="sidebar-title">Events</h2>

                    <button class="sidebar-close-btn" onclick = "closeEventSidebar()" data-mobile-menu-close-btn>
                        <ion-icon name="close-outline"></ion-icon>
                    </button>
                    </div>

                    <ul class="sidebar-menu-category-list">

                    @if(isset($allEvents))
                        @if(count($allEvents) > 0)
                        @foreach($allEvents as $eachEvent)
                            <li class="sidebar-menu-category">

                            <button class="sidebar-accordion-menu" data-accordion-btn>

                                <!-- <img src="./assets/images/icons/dress.svg" alt="clothes" width="20" height="20"
                                    class="menu-title-img"> -->

                                    @if($eachEvent->subEvents->isNotEmpty())
                                    <div class="menu-title-flex">
                                        <span style = "color : #8789ff;"><i class="fa-solid fa-circle-check"></i></span>
                                        <p class="menu-title">{{ $eachEvent->event_name }}</p>
                                    </div>

                                    <div>
                                        <ion-icon name="add-outline" class="add-icon"></ion-icon>
                                        <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                                    </div>
                                    @else
                                    <div class="menu-title-flex">
                                        <span style = "color : #8789ff;"><i class="fa-solid fa-circle-check"></i></span>
                                        <a href = "#" class="menu-title">{{ $eachEvent->event_name }}</a>
                                    </div>
                                    @endif

                            </button>

                            @if($eachEvent->subEvents->isNotEmpty())
                                <ul class="sidebar-submenu-category-list" data-accordion>

                                @foreach($eachEvent->subEvents as $subEvent)
                                    <li class="sidebar-submenu-category">
                                    <a style = "cursor : pointer;" onclick = "window.location.href = '/Event/{{$subEvent->event->event_name}}/{{$subEvent->sub_event_name}}/{{$subEvent->id}}'" class="sidebar-submenu-title">
                                        <p class="product-name">{{ $subEvent->sub_event_name }}</p>
                                    </a>
                                    </li>
                                @endforeach
                            
                                </ul>
                            @endif

                            </li>
                        @endforeach
                        @else
                        <h4 class="showcase-title" style = "text-align : center;">No any event added yet !</h4>
                        @endif
                    @endif

                    </ul>

                </div>

                <div class="product-showcase">

                    <h3 class="showcase-heading">Most sold products</h3>

                    <div class="showcase-wrapper">

                    <div class="showcase-container">

                        @if(isset($topSoldProducts))
                        @if(count($topSoldProducts) > 0)
                            @foreach($topSoldProducts as $eachProduct)
                            <div class="showcase">

                                <a style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'" class="showcase-img-box">
                                <img src="{{ asset('storage/' . $eachProduct->thumbnail_image ) }}" alt="product main img" width="70" height="75"
                                    class="showcase-img">
                                </a>

                                <div class="showcase-content">

                                <a style = "cursor : pointer;" onclick = "window.location.href = '/product-details/{{$eachProduct->id}}'">
                                    <h4 class="showcase-title">{{ $eachProduct->product_name }}</h4>
                                </a>

                                <div class="showcase-rating">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                </div>

                                <div class="price-box">
                                    <del><i class="fa-solid fa-indian-rupee-sign"></i> {{ $eachProduct->price_without_discount }}</del>
                                    <p class="price"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $eachProduct->price_with_discount }}</p>
                                </div>

                                </div>

                            </div>
                            @endforeach
                        @else
                            <h4 class="showcase-title" style = "text-align : center;">No any product uploaded yet !</h4>
                            <!-- <div style = "font-size : 16px; color : #343434; width : text-align : center; "><b><i>There is no any data to show !</i></b></div> -->
                        @endif
                        @endif

                    </div>

                    </div>

                </div>

            </div>



            <div class="product-box" style = "width : 100%;">
              <div class="container_anjali">
                
                <div class="form_anjali">
                  <div class="contact-info_anjali">
                    <h3 class="title_anjali">Let's get in touch</h3>
                    <hr>
              
                    <p class="text_anjali" style="margin-top: 1.5rem; text-align: center;">
                      Hello, dear customer !
                    </p>
              
                    <p class="text_anjali" style="text-align: justify;">
                      Whether you have a question about your order, our products, or anything else, our team is ready to answer all your questions. 
                    </p>
              
                    <p class="text_anjali" style="text-align: justify;">
                      Our team is dedicated to providing you with the best service possible. Reach out to us through this contact form. 
                    </p>
              
                    <div style="text-align: center; margin-top: 3rem; align-items: center; justify-content: center;">
                      <img src="{{ asset('img/logo.png') }}" id = "logo_IMG" width="300" alt="logo">
                    </div>
                  </div>
              
                  <div class="contact-form_anjali">
                    <span class="circle one"></span>
                    <span class="circle two"></span>
              
                    <form action="{{ route('contact_us_form_submit') }}" method = "post" autocomplete="off">
                      @csrf
                      <h3 class="title_anjali">Contact us</h3>
                      <div class="input-container_anjali">
                        <input type="text" name="name" class="input" required />
                        <label for="">Name</label>
                        <span>Name</span>
                      </div>
                      <div class="input-container_anjali">
                        <input type="email" name="email" class="input" required />
                        <label for="">Email</label>
                        <span>Email</span>
                      </div>
                      <div class="input-container_anjali">
                        <input type="tel" maxlength="10" name="phone_no" class="input" required />
                        <label for="">Phone</label>
                        <span>Phone</span>
                      </div>
                      <div class="input-container_anjali textarea">
                        <textarea name="message" class="input" id = "anjalitextArea" required></textarea>
                        <label for="">Message</label>
                        <span>Message</span>
                      </div>
                      <input type="submit" value="Send" class="btn_anjali" />
                    </form>
                  </div>
                </div>
              </div>
            </div>

        </div>

    </div>

</main>

<script src="{{ asset('js/form.js') }}"></script>

<script>
  window.onload = function() {
      let successScroll = document.getElementById('successScroll');
      successScroll.scrollIntoView({ behavior: 'smooth' });
  };
</script>