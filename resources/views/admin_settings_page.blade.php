@include('admin_dashboard_header2')

@if ($errors->any())
    <br><br>
    <div id="errorAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('UserVerified'))
    <br><br>
    <div id="successAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('UserVerified') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('update_success'))
    <br><br>
    <div id="successAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('update_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div class="mt-4" style = "display : flex; text-align : center; justify-content : center; align-items : center; gap : 2%;">
        <div style = "text-align : center; width : 11%;">
            <img alt="image" style = "border-radius : 50%; width : 100%; padding : 3%; border : 2px solid green;" src="{{ asset('storage/' . $admin_session->profile_pic)}}" class="user-img-radious-style">
        </div>
        
        <h1 style = "text-align : center; color : #454545;">Admin account details</h1>
    </div>

<form action="{{ route('updating_admin_details') }}" class="row g-3 mt-2" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="col-md-6">
        <label class="form-label" for="inputmentor">Name</label>

        @if(session('UserVerified'))
            <input class="form-control border border-secondary" id="inputprj" value="{{ $admin_session->name }}" name="name" placeholder="Enter your name" required type="text">
        @else
            <input class="form-control border border-secondary" id="inputprj" value="{{ $admin_session->name }}" name="name" placeholder="Enter your name" required type="text" readonly>
        @endif

    </div>
    <div class="col-md-6">
        <label class="form-label" for="inputprj">E-mail address</label>

        @if(session('UserVerified'))
            <input class="form-control border border-secondary" id="inputprj" value="{{ $admin_session->email }}" name="email" placeholder="Enter your e-mail address" required type="text">
        @else
            <input class="form-control border border-secondary" id="inputprj" value="{{ $admin_session->email }}" name="email" placeholder="Enter your e-mail address" required type="text" readonly>
        @endif
    </div>

    <div class="col-md-6">
        <label class="form-label" for="inputmentor">Phone number</label>

        @if(session('UserVerified'))
            <input class="form-control border border-secondary" id="inputprj" value="{{ $admin_session->phone_no }}" name="phone_no" placeholder="Enter your phone number" required type="text">
        @else
            <input class="form-control border border-secondary" id="inputprj" value="{{ $admin_session->phone_no }}" name="phone_no" placeholder="Enter your phone number" required type="text" readonly>
        @endif
    </div>

    <div class="col-md-6">
    <label class="form-label" for="thumbnail_image_tag">Profile pic</label>
    <input class="form-control border border-secondary" id="thumbnail_image_tag" name="profile_pic" type="file">
    </div>

    @if (Session::has('UserVerified'))
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
    @endif
</form>

    @if(!session('OTP_SENT') && !session('UserVerified'))

        <div class="col-12" style = "text-align : center;">
            <h5 class="mt-4 form-label" style = "color : #454545;">Verify yourself by email to get access to change admin account details</h5>
            <a href = "{{ route('send_otp_to_admin') }}" class="btn btn-primary">Send OTP</a>
        </div>

    @endif

    @if (Session::has('error'))
        <br><br>
        <div id="errorAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (Session::has('OTP_SENT'))
        <br><br>
        <div id="successAlert" style = "text-align : center; font-size : 16px; font-weight : 600;" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('OTP_SENT') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <form action="{{ route('verify_admin_otp') }}" method = "post">
            @csrf
            <div class="col-md-2" style = "margin : auto; text-align : center; align-iteams : center;">
                <label class="form-label" for="inputmentor">Enter received OTP</label>

                <input class="form-control border border-secondary" id="inputprj" name="input_otp" placeholder="OTP" required type="text">
                <button style = "margin-top : 4%;" class="btn btn-primary" type="submit">Verify</button>

            </div>
        </form>
    @endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@include('admin_dashboard_footer2')