@extends('admin_dashboard_layout')

@section('title')
<title>Admin Dashboard | Profile</title>
@endsection

@section('style')
<style>
  
</style>
@endsection

@section('body')

    <script>
        function checkFormChanges2(){
            let name = "{{ $admin_session->name }}";
            let email = "{{ $admin_session->email }}";
            let phone_no = "{{ $admin_session->phone_no }}";
            let original_profile_pic = "{{ $admin_session->profile_pic }}";

            let input_name = document.getElementById('name').value;
            let input_email = document.getElementById('email').value;
            let input_phone_no = document.getElementById('phone_no').value;
            let new_profile_pic = document.getElementById('profile_pic').files[0];

            let save_changes_btn_slot = document.getElementById('id_for_enable_desable_save_changes_btn2');

            if(input_name === name && input_email === email &&  input_phone_no === phone_no && (!new_profile_pic || new_profile_pic.name === original_profile_pic)) {
                console.log("Badhu Barabar chhe");
                save_changes_btn_slot.classList.add("disabled_due_to_same_data");
            }
            else {
                console.log("Kasu barabar nathi");
                save_changes_btn_slot.classList.remove("disabled_due_to_same_data");
            }
        }
    </script>

    <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card author-box">
                  <div class="card-body">
                    <div class="author-box-center">
                      <img alt="image" src="{{ asset('storage/' . $admin_session->profile_pic)}}" class="rounded-circle author-box-picture">
                      <div class="clearfix"></div>
                      <div class="author-box-name">
                        <p class = "mt-2" style = " color : #454545; font-weight : 650; ">{{ $admin_session->name }}</p>
                      </div>
                      <div class="author-box-job">Welcome back, dear admin !</div>
                      <div class="author-box-job">stay safe & happy &#10084;</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-12 col-lg-8">

                    @if (Session::has('success'))
                        <div id = "msg_notification">
                            <div style="background: #4F9153; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                <span style="flex-grow: 1;">{{ Session::get('success') }}</span>
                                <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                            </div>
                            <br>
                        </div>
                    @endif

                    @if (Session::has('UserVerified'))
                        <div id = "msg_notification">
                            <div style="background: #4F9153; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                <span style="flex-grow: 1;">{{ Session::get('UserVerified') }}</span>
                                <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                            </div>
                            <br>
                        </div>
                    @endif

                    @if (Session::has('OTP_SENT'))
                        <div id = "msg_notification">
                            <div style="background: #4F9153; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #006400; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                <span style="flex-grow: 1;">{{ Session::get('OTP_SENT') }}</span>
                                <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn"></i>
                            </div>
                            <br>
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div id = "msg_notification">
                            <div style="background: #FF474C; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #B22222; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                <span style="flex-grow: 1;">{{ Session::get('error') }}</span>
                                <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn2"></i>
                            </div>
                            <br>
                        </div>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $index => $error)
                            <div id="msg_notification_{{ $index }}">
                                <div style="background: #FF474C; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #B22222; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                    <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                    <span style="flex-grow: 1;">{{ $error }}</span>
                                    <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick="let box = document.getElementById('msg_notification_{{ $index }}'); box.style.display = 'none';" id = "close--btn2"></i>
                                </div>
                                <br>
                            </div>
                        @endforeach
                    @endif

                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                          aria-selected="true">Profile</a>
                      </li>
                    </ul>

                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                        

                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>

                            @if(!session('OTP_SENT') && !session('UserVerified'))
                                <div style = "font-size : 1.1rem; font-weight : 700; margin-top : 1rem; margin-bottom : 1rem; text-align : center; color : #454545;">
                                    Verify yourself by email to get access to change admin account details
                                </div>

                                <div class="text-center">
                                    <button onclick = "window.location.href = '/send_otp_to_admin'" class="btn btn-primary">Send OTP</button>
                                </div>
                                <hr>
                            @endif

                            @if (Session::has('OTP_SENT'))
                                <form method="post" action="{{ route('verify_admin_otp') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row" style = "text-align : center; align-items : center; justify-content : center;">
                                            <div class="form-group col-md-6 text-center mb-0">
                                                <label>Enter received OTP</label>
                                                <input type="number" min = "6" class="form-control" name = "input_otp" placeholder="OTP" required>
                                                <button class="btn btn-primary mt-3">Verify</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                            @endif

                        <form method="post" action = "" id="updateForm" class="needs-validation" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" value="{{$admin_session->id}}" name = "customer_id">
                            
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-md-12 col-12">
                                <label>Full Name</label>

                                    @if(session('UserVerified'))
                                        <input type="text" class="form-control" oninput="checkFormChanges2();" name = "name" id = "name" value="{{ $admin_session->name }}" required>
                                    @else
                                        <input type="text" class="form-control" oninput="checkFormChanges2();" name = "name" id = "name" value="{{ $admin_session->name }}" required readonly>
                                    @endif

                                <div class="invalid-feedback">
                                  Please fill in the Full name
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Email</label>

                                    @if(session('UserVerified'))
                                        <input type="email" class="form-control" oninput="checkFormChanges2();" name = "email" id = "email" value="{{ $admin_session->email }}" required>
                                    @else
                                        <input type="email" class="form-control" oninput="checkFormChanges2();" name = "email" id = "email" value="{{ $admin_session->email }}" required readonly>
                                    @endif

                                <div class="invalid-feedback">
                                  Please fill in the email
                                </div>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Phone</label>

                                    @if(session('UserVerified'))
                                        <input type="tel" class="form-control" oninput="checkFormChanges2();" name = "phone_no" id = "phone_no" maxlength = "10" value="{{ $admin_session->phone_no }}" required>
                                    @else
                                        <input type="tel" class="form-control" oninput="checkFormChanges2();" name = "phone_no" id = "phone_no" maxlength = "10" value="{{ $admin_session->phone_no }}" required readonly>
                                    @endif
                              </div>
                            </div>

                            <div class="row">
                              <div class="form-group col-md-12 col-12">
                                <label>Profile pic</label>
                                <div class="custom-file">

                                    @if(session('UserVerified'))
                                        <input type="file" class="custom-file-input" onchange="showFileName(this); checkFormChanges2();" name = "profile_pic" id="profile_pic" style = "cursor : pointer;">
                                    @else
                                        <input type="file" class="custom-file-input" onchange="showFileName(this); checkFormChanges2();" name = "profile_pic" id="profile_pic" style = "cursor : pointer;" disabled>
                                    @endif

                                  <label class="custom-file-label" for="profile_pic">Choose image</label>
                                  <div id="fileName"></div>
                                </div>
                              </div>
                            </div>

                          </div>

                          <div class="card-footer text-right">
                            <button class="btn btn-primary customer_account_save_changes disabled_due_to_same_data" id = "id_for_enable_desable_save_changes_btn2">Save Changes</button>
                          </div>
                        </form>

                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() 
        {
            const form = document.getElementById('updateForm');
            const initialData = {
                name: form.name.value,
                email: form.email.value,
                phone_no: form.phone_no.value,
                profile_pic: form.profile_pic.value
            };

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const currentData = {
                    name: form.name.value,
                    email: form.email.value,
                    phone_no: form.phone_no.value,
                    profile_pic: form.profile_pic.value
                };

                if (currentData.email !== initialData.email || currentData.phone_no !== initialData.phone_no) {
                    form.action = '/updating_admin_details';
                } else if ((currentData.name !== initialData.name || currentData.profile_pic !== initialData.profile_pic) && (currentData.email === initialData.email && currentData.phone_no === initialData.phone_no)) {
                    form.action = '/updating_admin_details2';
                }

                form.submit();
            });
        });
    </script>

<script>
    function showFileName(input) {
        var fileNameElement = document.getElementById('fileName');
        if (input.files && input.files.length > 0) {
            var filename = input.files[0].name;
            var extensionIndex = filename.lastIndexOf('.');
            var filenameWithoutExtension = filename.substring(0, extensionIndex);
            var extension = filename.substring(extensionIndex + 1);
            var displayedName;
            if (filenameWithoutExtension.length > 35) {
                var firstPart = filenameWithoutExtension.substring(0, 35);
                var lastPart = filenameWithoutExtension.substring(filenameWithoutExtension.length - 10);
                displayedName = firstPart + '.....' + lastPart;
            } else {
                displayedName = filenameWithoutExtension;
            }
            fileNameElement.innerHTML = 'Selected File : "' + displayedName + '.' + extension + '"';
        } else {
            fileNameElement.innerHTML = '';
        }
    }
</script>
@endsection

@section('script')
  <script>
    let profile = document.getElementById("profile");
    profile.classList.add("active");
  </script>
@endsection