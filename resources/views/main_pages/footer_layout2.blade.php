<footer>

<div class="footer-nav">

  <div class="container">

    <ul class="footer-nav-list">
    
      <li class="footer-nav-item">
        <h2 class="nav-title">Get To Know Us</h2>
      </li>
    
      <li class="footer-nav-item">
        <a href="{{ route('about_us') }}" class="footer-nav-link">About Us</a>
      </li>

      <li class="footer-nav-item">
        <a href="/developer-anjali-patel" target = "_blank" class="footer-nav-link">Developer</a>
      </li>

      <li class="footer-nav-item">
        <a href="{{ route('privacy_policy') }}" class="footer-nav-link">Privacy Policy</a>
      </li>

      <li class="footer-nav-item">
        <a href="{{ route('terms_and_conditions') }}" class="footer-nav-link">Terms and conditions</a>
      </li>
    
    </ul>

    <ul class="footer-nav-list">
    
      <li class="footer-nav-item">
        <h2 class="nav-title">Connect with Us</h2>
      </li>

      <li class="footer-nav-item">
        <a href="{{ route('FAQs') }}" class="footer-nav-link">FAQs</a>
      </li>
    
      <li class="footer-nav-item">
        <a href="{{ route('contact_us') }}" class="footer-nav-link">Contact Us</a>
      </li>
    
      <li class="footer-nav-item">
        <a href="{{ route('feedback_form') }}" class="footer-nav-link">Feedback Form</a>
      </li>
    
      <li class="footer-nav-item">
        <a href="{{ route('customer_support') }}" class="footer-nav-link">Customer Support</a>
      </li>
    
    </ul>

    <ul class="footer-nav-list">
    
      <li class="footer-nav-item">
        <h2 class="nav-title">Payment Methods</h2>
      </li>
    
      <li class="footer-nav-item">
        <a href="{{ route('redirecting_payment_methods') }}" class="footer-nav-link">Cash on delivery</a>
      </li>
    
      <li class="footer-nav-item">
        <a href="{{ route('redirecting_payment_methods') }}" class="footer-nav-link">Secured Online Payment</a>
      </li>
    
    </ul>

    <ul class="footer-nav-list">
    
      <li class="footer-nav-item">
        <h2 class="nav-title">Services</h2>
      </li>

      <li class="footer-nav-item">
        <a href="{{ route('redirecting_short_service') }}" class="footer-nav-link">Return Policy</a>
      </li>

      <li class="footer-nav-item">
        <a href="{{ route('redirecting_short_service') }}" class="footer-nav-link">Instant Refund</a>
      </li>

      <li class="footer-nav-item">
        <a href="{{ route('redirecting_short_service') }}" class="footer-nav-link">Exchange Policy</a>
      </li>
    
    </ul>

    <ul class="footer-nav-list">

      <li class="footer-nav-item">
        <h2 class="nav-title">Address Info</h2>
      </li>

      <li class="footer-nav-item flex">
        <div class="icon-box">
          <ion-icon name="location-outline"></ion-icon>
        </div>

        <address class="content">
          {{ env('HOME_ADDRESS') }}
        </address>
      </li>

      <li class="footer-nav-item flex">
        <div class="icon-box">
          <ion-icon name="call-outline"></ion-icon>
        </div>

        <a class="content">{{env('PHONE_NUMBER')}}</a>
      </li>

      <li class="footer-nav-item flex">
        <div class="icon-box">
          <ion-icon name="mail-outline"></ion-icon>
        </div>

        <a href="mailto:example@gmail.com" class="footer-nav-link">{{env('EMAIL_ADDRESS')}}</a>
      </li>

    </ul>

    <ul class="footer-nav-list">

      <li class="footer-nav-item">
        <h2 class="nav-title">Follow Us</h2>
      </li>

      <li>
        <ul class="social-link">

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>

          <li class="footer-nav-item">
            <a href="#" class="footer-nav-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

        </ul>
      </li>

    </ul>

  </div>

</div>

<div class="footer-bottom">

  <div class="container">
    
    <p class="copyright">
      &copy; 2024<a href="/"> SHUBHSTEP</a> all rights reserved
    </p>

  </div>

</div>

</footer>