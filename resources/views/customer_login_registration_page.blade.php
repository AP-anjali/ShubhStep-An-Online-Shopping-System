<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="./assets/images/logo/icon.png">
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="{{ asset('cssfiles/customer_login_registration_page.css') }}">
    <title>SHUBHSTEP | Login & Registration</title>
  </head>
  <body>

    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">

            <!-- --------------------------- login form ---------------------- -->

            <!-- -------------- email verification and sending otp -------------- -->
            <!-- -------------- OTP verification -------------- -->

                        @if(session('showCustomerLoginAlert'))

                            <div class="alert-anjali show showAlert" id = "msg_slot">
                                <div>
                                  <span class="fas fa-exclamation-circle"></span>
                                  <span class="msg">To access further pages, please login first !</span>
                                  <div class="close-btn-anjali2" onclick = "closeBtn()">
                                      <span class="fas fa-times"></span>
                                  </div>
                                </div>

                            </div>

                                <script>
                                    function closeBtn()
                                    {
                                        let msg_slot = document.getElementById('msg_slot');
                                        msg_slot.style.display = "none";
                                    }
                                </script>
                        @endif

                        @if(session('error'))

                            <div class="alert-anjali show showAlert" id = "msg_slot">
                                <div>
                                  <span class="fas fa-exclamation-circle"></span>
                                  <span class="msg">{{ Session::get('error') }}</span>
                                  <div class="close-btn-anjali2" onclick = "closeBtn()">
                                      <span class="fas fa-times"></span>
                                  </div>
                                </div>

                            </div>

                                <script>
                                    function closeBtn()
                                    {
                                        let msg_slot = document.getElementById('msg_slot');
                                        msg_slot.style.display = "none";
                                    }
                                </script>
                        @endif

                        @if (Session::has('success'))
                            <div class="alert show showAlert" id = "msg_slot">
                                <div>
                                  <span class="fas fa-exclamation-circle"></span>
                                  <span class="msg">{{ Session::get('success') }}</span>
                                  <div class="close-btn-anjali" onclick = "closeBtn()">
                                      <span class="fas fa-times"></span>
                                  </div>
                                </div>

                            </div>

                                <script>
                                    function closeBtn()
                                    {
                                        let msg_slot = document.getElementById('msg_slot');
                                        msg_slot.style.display = "none";
                                    }
                                </script>
                        @endif

                        @if($errors->any())

                            @foreach ($errors->all() as $index => $error)
                                <div class="alert-anjali show showAlert" style = "margin-top : 0.5rem;" id = "msg_slot_{{$index}}">
                                    <div>
                                    <span class="fas fa-exclamation-circle"></span>
                                    <span class="msg">{{ $error }}</span>
                                    <div class="close-btn-anjali2" onclick = "closeBtn({{ $index }})">
                                        <span class="fas fa-times"></span>
                                    </div>
                                    </div>

                                </div>
                            @endforeach

                                <script>
                                    function closeBtn(index)
                                    {
                                        let msg_slot = document.getElementById('msg_slot_' + index);
                                        if (msg_slot) {
                                            msg_slot.style.display = "none";
                                        }
                                    }
                                </script>
                        @endif


            @if(Session::has('mail_has_been_sent_to_user'))
                <form action="{{ route('otp_verification') }}" class="sign-in-form" method = "post">
                    @csrf
                    <h2 class="title">Sign in</h2>

                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" value = "{{ Session::get('input_email') }}" name = "registered_email" style = "cursor : not-allowed;" placeholder="Email Address" readonly />
                    </div>
                    
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="text" maxlength = "6" name = "input_otp" placeholder="Verification OTP" required />
                    </div>

                    <div>
                        <input type="button" onclick = "window.location = '/'" value="Exit" class="btn solid" />
                        <input type="submit" value="Login" class="btn solid" />
                    </div>

                    <p class="social-text">Or Sign in with social platform</p>
                        <div class="container_anjalianjali">
                            <a href="{{ route('login_by_google') }}">
                                <div class="g-sign-in-button_anjali">
                                    <div class="content-wrapper_anjaliajnali">
                                        <div class="logo-wrapper_anjailianjali">
                                            <img src="https://developers.google.com/identity/images/g-logo.png">
                                        </div>
                                        <span class="text-containeranjalianjai"><span>Sign in with Google</span></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <p class="social-text-last">"SubhStep - Kadam uthao, sapne sajao &#10084;"</p>

                </form>
            @else
                <form action="{{ route('email_verification_and_sending_otp') }}" class="sign-in-form" method = "post">
                    @csrf
                    <h2 class="title">Sign in</h2>

                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name = "input_email" value = "{{ old('input_email') }}" placeholder="Email Address" required />
                    </div>

                    <div>
                        <input type="button" onclick = "window.location = '/'" value="Exit" class="btn solid" />
                        <input type="submit" value="Send OTP" class="btn solid" />
                    </div>

                    <p class="social-text">Or Sign in with social platform</p>
                        <div class="container_anjalianjali">
                            <a href="{{ route('login_by_google') }}">
                                <div class="g-sign-in-button_anjali">
                                    <div class="content-wrapper_anjaliajnali">
                                        <div class="logo-wrapper_anjailianjali">
                                            <img src="https://developers.google.com/identity/images/g-logo.png">
                                        </div>
                                        <span class="text-containeranjalianjai"><span>Sign in with Google</span></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <p class="social-text-last">"SubhStep - Kadam uthao, sapne sajao &#10084;"</p>

                </form>
            @endif

            
            <!-- ------------------------------------------------------------- -->

            <!-- --------------------------- registration form ---------------------- -->
            <form action="{{ route('customer_registration') }}" class="sign-up-form" method = "post">
                @csrf
                <h2 class="title">Sign up</h2>
                
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name = "name" placeholder="Full Name" required/>
                </div>
                
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name = "email" placeholder="Email Address" required/>
                </div>
                
                <div class="input-field">
                    <i class="fas fa-phone flipped-icon"></i>
                    <input type="text" name = "phone_no" maxlength = "10" placeholder="Phone Number" required/>
                </div>

                <div>
                    <input type="button" onclick = "window.location = '/'" value="Exit" class="btn solid" />
                    <input type="submit" class="btn" value="Sign up" />
                </div>

                <p class="social-text">Or Sign in with social platform</p>
                        <div class="container_anjalianjali">
                            <a href="{{ route('login_by_google') }}">
                                <div class="g-sign-in-button_anjali">
                                    <div class="content-wrapper_anjaliajnali">
                                        <div class="logo-wrapper_anjailianjali">
                                            <img src="https://developers.google.com/identity/images/g-logo.png">
                                        </div>
                                        <span class="text-containeranjalianjai"><span>Sign in with Google</span></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                <p class="social-text-last">"SubhStep - Kadam uthao, sapne sajao &#10084;"</p>
            </form>
            <!-- ------------------------------------------------------------- -->

            </div>
        </div>

        <div class="panels-container">

            <div class="panel left-panel">
            <div class="content">
                <h3>New here ?</h3>
                <p>
                A warm welcome to all the Customers ! <br> Take a STEP, and start your journey with "SHUBHSTEP"
                </p>
                <button class="btn transparent" id="sign-up-btn">
                Sign up
                </button>
            </div>
            <img src="./assets/images/login.svg" class="image" alt="" />
            </div>

            <div class="panel right-panel">
            <div class="content">
                <h3>One of us ?</h3>
                <p>
                Login to your account to get your premium access <br> Take a STEP, and resume your journey with "SHUBHSTEP"
                </p>
                <button class="btn transparent" id="sign-in-btn">
                Sign in
                </button>
            </div>
            <img src="./assets/images/reg.svg" class="image" alt="" />
            </div>

        </div>

    </div>

  <script src="{{ asset('js/customer_login_registration_page.js') }}"></script>

  
  </body>
</html>