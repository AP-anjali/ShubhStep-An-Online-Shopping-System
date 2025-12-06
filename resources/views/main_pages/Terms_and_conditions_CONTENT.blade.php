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

        <div id = "successScroll"></div>              

    </div>
    
    <div class="product-container">


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

            <div class="product-box" style = "width : 100%; border-radius : 10px; background-color: whitesmoke; overflow: hidden; box-shadow: 0 0 10px hsla(0, 0%, 0%, 0.25); margin-top: 2rem; margin-bottom : 3rem;">
            
                <div class="heading_anjali2">
                    <h1>Terms And Conditions</h1>
                </div>

                <ul id = "accordion_anjali">
                    <li>
                        <label for="first">Introduction<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="first" checked>
                        <div class="content_anjali20">
                            <p>
                                Welcome to SHUBHSTEP! These terms and conditions outline the rules and regulations for the use of our website.
                                <br><br>
                                By accessing this website, we assume you accept these terms and conditions completely. Please do not continue to use this website if you do not accept all of the terms and conditions stated on this page.
                                By using this platform, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions. These terms and conditions are effective from <b>"{{ env('LAUNCH_DATE') }}"</b>.
                            </p>

                        </div>
                    </li>

                    <div id="forPaymentMethodsScroll"></div>

                    <li>
                        <label for="second">Customer Registration and Authentication<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="second">
                        <div class="content_anjali20">
                            <p>
                                To access certain features of the website, such as adding products to the cart or wishlist, and purchasing products, you are required to create an account. You must provide accurate and complete information during the registration process. You are responsible for maintaining the confidentiality of your account and orders.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; You can register manually by providing the following details :
                                <br>
                                1] Your Full Name
                                <br>
                                2] Your Phone Number (for communication purposes)
                                <br>
                                3] Your Email Address (for notification purposes)
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; Alternatively, you can log in directly using your existing Google account. In this method, your name and email address will be saved initially, and you will need to manually add your phone number for communication purposes.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; In both methods, you must provide your proper address for delivery purposes. You can access your address status, and can add or change your address details in your account page, in address section.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; To order any product from SHUBHSTEP, you must provide all the details mentioned above to ensure the proper communication, notification, and delivery processes.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="third">Orders and Payments<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="third">
                        <div class="content_anjali20">
                            <p>
                                All orders placed through our website are subject to availability and acceptance. We reserve the right to refuse or reject any order for any reason at any time. Prices displayed on our website are in Indian currency, exclusive of taxes and shipping costs.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; We accept payment for orders in two modes:
                                <br>
                                1) Online Payment
                                <br>
                                2) Cash Payment on Delivery
                                <br><br>
                                You can order any single product or purchase multiple products together by adding them to your cart. After successful order placement and acceptance, your order will be delivered in the coming days.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="extra">Payment Methods<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="extra">
                        <div class="content_anjali20">
                            <p>

                                <i class="fa-solid fa-right-long"></i> &nbsp; We accept payment of orders through two methods : <br>
                                1) Online Payment<br>
                                2) Cash Payment on Delivery<br><br>

                                <i class="fa-solid fa-right-long"></i> &nbsp; 1) Online Payments : <br><br>
                                We offer a variety of secure online payment methods to make your shopping experience convenient and safe. Our accepted online payment options include :<br>
                                &nbsp; &nbsp; a) Credit and Debit Cards: We accept major credit and debit cards.<br>
                                &nbsp; &nbsp; b) Net Banking: Choose from a wide range of banks to make a payment directly from your bank account.<br>
                                &nbsp; &nbsp; c) UPI: Use UPI to quickly and securely transfer money from your bank account.<br>
                                &nbsp; &nbsp; d) Mobile Wallets: Pay using popular mobile wallets like Paytm, PhonePe, and more.<br><br>
                                &bull; All online transactions are encrypted and processed through secure payment gateways to ensure the safety of your financial information.<br>
                                &bull; For any issues or queries regarding online payments, please contact our customer support team.

                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; 2) Cash Payment On Delivery : <br><br>
                                    &bull; For your convenience, we also offer a Cash Payment On Delivery (COD) option. You can choose this method at checkout if you prefer to pay in cash when your order is delivered to your doorstep.<br>
                                    &bull; Our delivery agents will collect the cash payment before handing over the package to you. Please ensure that you have the exact amount ready, as our delivery agents might not carry change.<br>
                                    &bull; For any issues or queries regarding cash payment on delivery, please contact our customer support team. <br>
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="forth">Order Cancellation<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="forth">
                        <div class="content_anjali20">
                            <p>
                                After ordering any product from SHUBHSTEP, you can cancel your order until our team accepts your order request. Please note that after acceptance of your order by our team, you cannot cancel your order!
                                <br><br>
                                If you cancel your order and have made the payment through online methods, your paid amount will be refunded after deducting {{ env('ORDER_CANCELLATION_CHARGE_PERCENTAGE') }}% of the paid amount as an order cancellation charge.
                                <br><br>
                                After successful cancellation of your order, you will receive your refund in the coming days. For more details on the refund process, you can check the Razorpay payment refund process terms and conditions.
                                <br><br>
                                Please note that this refund process is automated when you cancel your order, and no human interaction is involved, So you can rely on SHUBHSTEP for your payments and refunds.
                                <br><br>
                                For any questions, queries, or problems, please notify us by filling out the <a style = "display : inline-block; color : white;" href = "{{route('customer_support')}}">' customer support '</a> form which can be found in the footer section.
                            </p>
                        </div>
                    </li>

                    <div id="forReturnPolicyScroll"></div>

                    <li>
                        <label for="fifth">Order Rejection<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="fifth">
                        <div class="content_anjali20">
                            <p>
                                After ordering any product from SHUBHSTEP, it is subject to availability and acceptance. We reserve the right to refuse or reject any order for any reason at any time.
                                <br><br>
                                In case, if your order is rejected and you have made the payment via online payment method, the full amount paid will be refunded by SHUBHSTEP.
                                <br><br>
                                After rejection of your order, if you have made the payment via online payment method, the full paid amount will be refunded in the coming days. For more details on the refund process, please refer to the Razorpay payment refund process terms and conditions.
                                <br><br>
                                Please note that this type of refund process is automated when the administrative department rejects your order, and no human interaction is involved, So you can rely on SHUBHSTEP for your payments and refunds.
                                <br><br>
                                For any questions, queries, or problems, please notify us by filling out the <a style = "display : inline-block; color : white;" href = "{{route('customer_support')}}">' customer support '</a> form which can be found in the footer section.
                            </p>
                        </div>
                    </li>

                    <div id="forExchangePolicyScroll"></div>

                    <li>
                        <label for="sixth">Delivery Security<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="sixth">
                        <div class="content_anjali20">
                            <p>
                                For secure and authenticated delivery, we ensure your order is marked as delivered only after verifying the OTP sent to your registered email address. This ensures the reliability of delivery by SHUBHSTEP.
                                <br><br>
                                After successful delivery of your order, you can provide feedback if you are satisfied or proceed accordingly based on your experience.
                            </p>
                        </div>
                    </li>

                    <div id="forRefundPolicyScroll"></div>

                    <li>
                        <label for="seventh">Return Policy<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="seventh">
                        <div class="content_anjali20">
                            <p>
                                At SHUBHSTEP, we strive to ensure that you are completely satisfied with your purchase. If for any reason you are not satisfied with your order, we offer a hassle-free returns process. Below, you will find our comprehensive Returns and Refunds Policy.
                                <br><br>
                                If you wish to return an item, you may do so within 7 days of receiving your order. Our simple and straightforward returns process ensures your satisfaction.
                                <br><br>

                                <i class="fa-solid fa-right-long"></i> &nbsp; Please note that you can apply for a return or exchange for a particular order only once.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; <b>Eligibility for Returns:</b><br>

                                <br>&nbsp;&nbsp;&bull; Provide a reasonable reason for the return for our information.
                               <br>&nbsp;&nbsp;&bull; If you have valid reason for return the order, then only you can apply for return.
                                <br>
                                &nbsp;&nbsp;&bull; The item must be unused and in the same condition as when you received it.
                                <br>
                                &nbsp;&nbsp;&bull; It should be in its original packaging, including all tags, labels, and accessories.
                                <br>
                                &nbsp;&nbsp;&bull; A receipt or proof of purchase must accompany the returned item.
                                <br>
                                &nbsp;&nbsp;&bull; Pack the item securely in its original packaging, including all parts, accessories, and documentation.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; <b>Refunds of Returns:</b>
                                <br><br>
                                Once we receive your returned item, our team will inspect it. Upon successful inspection, your payment refund process will be initiated.
                                <br><br>
                                If you paid for the order using an online payment method, the refund will be issued to the original payment method used during purchase, with the full amount refunded by SHUBHSTEP.
                                <br><br>
                                If you paid for the order using cash-on-delivery, you will need to provide your bank details via a form submission . The refund will then be processed to the provided bank account. Please ensure accuracy when filling out the bank details form, as any errors are your responsibility.
                                <br><br>
                                The refund process typically takes 5-10 business days to reflect in your account. For more details on the refunding process timeframe, please refer to the Razorpay payment refund process terms and conditions.
                                <br><br>
                                Please note that this refund process is automated once initiated by our administrative department, ensuring no human interaction is involved. You can rely on SHUBHSTEP for secure and timely payments and refunds.
                                <br><br>
                                For any questions, queries, or problems, please notify us by filling out the <a style = "display : inline-block; color : white;" href = "{{route('customer_support')}}">' customer support '</a> form available in the footer section.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="eighth">Exchange Policy<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="eighth">
                        <div class="content_anjali20">
                            <p>
                                If you received a defective or damaged item, we are happy to offer an exchange. Please apply for exchange of your order within 7 days of receiving your order to arrange an exchange. Provide details of the defect or damage as an exchange reason.

                               <br><br>

                                <i class="fa-solid fa-right-long"></i> &nbsp; Please note that you can apply for a return or exchange for a particular order only once.
                                <br><br>

                               <i class="fa-solid fa-right-long"></i> &nbsp; <b>Eligibility for Exchange :</b><br>
                               <br>&nbsp;&nbsp;&bull; &nbsp; Provide the valid reason for the exchnage for our information.
                               <br>&nbsp;&nbsp;&bull; &nbsp; If you received a defective or damaged item, then only you can apply for exchange.
                               <br>&nbsp;&nbsp;&bull; &nbsp; The item must be unused and in the same condition as when you received it.
                                <br>&nbsp;&nbsp;&bull; &nbsp; It should be in its original packaging, including all tags, labels, and accessories.
                                <br>&nbsp;&nbsp;&bull; &nbsp; A receipt or proof of purchase must accompany the returned item.
                                <br>&nbsp;&nbsp;&bull; &nbsp; Pack the item securely in its original packaging, including all parts, accessories, and documentation.

                                <br><br>
                                Please not that, this type of exchange process will take 5-10 business days.

                                <br><br>
                                For any question, query, or problem you can notify us, by filling the <a style = "display : inline-block; color : white;" href = "{{route('customer_support')}}">' customer support '</a> form which you can found in footer section.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="ninth">Refund Guarantee Policy<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="ninth">
                        <div class="content_anjali20">
                            <p>
                                At SHUBHSTEP, we are dedicated to ensuring your complete satisfaction with every purchase. If for any reason you are not delighted with your order, our Refund Guarantee Policy is here to provide you with a smooth and straightforward resolution.
                                <br><br>
                                <i class="fa-solid fa-right-long"></i> &nbsp; <b>Cases, in which you get a refund :</b><br>
                                &nbsp;&nbsp;&bull; If you cancel the order and have made the payment via online payment method, your paid amount will be refunded after deducting {{ env('ORDER_CANCELLATION_CHARGE_PERCENTAGE') }}% as an order cancellation charge.
                                <br>
                                &nbsp;&nbsp;&bull; If your order is rejected by the administrative department, the full paid amount will be refunded by SHUBHSTEP.
                                <br>
                                &nbsp;&nbsp;&bull; If an order is successfully returned, the full paid amount will be refunded by SHUBHSTEP.
                                <br><br>
                                Please note that, this refund process is automated once our conditions are satisfied, ensuring no human interaction is involved, So you can rely on SHUBHSTEP for your payments and refunds.
                                <br><br>
                                For any questions, queries, or problems, please notify us by filling out the <a style = "display : inline-block; color : white;" href = "{{route('customer_support')}}">' customer support '</a> form available in the footer section.
                            </p>
                        </div>
                    </li>

                    <li>
                        <label for="tenth">Privacy & Data Protection<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="tenth">
                        <div class="content_anjali20">
                            <p>
                                <i class="fa-solid fa-right-long"></i> &nbsp; Your data privacy is important to us. Please review our <a style = "display : inline-block; color : white;" href = "{{route('privacy_policy')}}">' Privacy Policy '</a> page which you can find in the footer section, governing the use of your personal data on our website.
                            </p>

                        </div>
                    </li>

                    <li>
                        <label for="elevanth">Customer Support<span><i class="fa-solid fa-sort-down"></i></span></label>
                        <input type="radio" name="accordion" id="elevanth">
                        <div class="content_anjali20">
                            <p>
                                <i class="fa-solid fa-right-long"></i> &nbsp; For customer support regarding orders or any general inquiries, please contact our customer support team by filling out the <a style = "display : inline-block; color : white;" href = "{{route('customer_support')}}">' customer support '</a> form located in the footer section. We strive to respond to all inquiries within 7 to 10 business days.
                            </p>
                        </div>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</main>

<script src="{{ asset('js/form.js') }}"></script>

@if (Session::has('paymentMethod'))
    <script>
        window.onload = function() {
            let forPaymentMethodsScroll = document.getElementById('forPaymentMethodsScroll');
            forPaymentMethodsScroll.scrollIntoView({ behavior: 'smooth' });

            let discheckElement = document.getElementById('first');
            let checkElement = document.getElementById('extra');

            discheckElement.checked = false;
            checkElement.checked = true;
        };
    </script>
@elseif (Session::has('returnPolicy'))
    <script>
        window.onload = function() 
        {
            let forReturnPolicyScroll = document.getElementById('forReturnPolicyScroll');
            forReturnPolicyScroll.scrollIntoView({ behavior: 'smooth' });

            let discheckElement = document.getElementById('first');
            let checkElement = document.getElementById('seventh');

            discheckElement.checked = false;
            checkElement.checked = true;
        };
    </script>
@elseif (Session::has('refundPolicy'))
    <script>
        window.onload = function() 
        {
            let forRefundPolicyScroll = document.getElementById('forRefundPolicyScroll');
            forRefundPolicyScroll.scrollIntoView({ behavior: 'smooth' });

            let discheckElement = document.getElementById('first');
            let checkElement = document.getElementById('ninth');

            discheckElement.checked = false;
            checkElement.checked = true;
        };
    </script>

@elseif (Session::has('exchangePolicy'))
    <script>
        window.onload = function() 
        {
            let forExchangePolicyScroll = document.getElementById('forExchangePolicyScroll');
            forExchangePolicyScroll.scrollIntoView({ behavior: 'smooth' });

            let discheckElement = document.getElementById('first');
            let checkElement = document.getElementById('eighth');

            discheckElement.checked = false;
            checkElement.checked = true;
        };
    </script>
@else
    <script>
        window.onload = function() {
            let successScroll = document.getElementById('successScroll');
            successScroll.scrollIntoView({ behavior: 'smooth' });
        };
    </script>
@endif
