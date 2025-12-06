@extends('customer_dashboard_layout')

@section('title')
<title>Customer Dashboard | Profile</title>
@endsection

@section('style')
<style>
  #anjali-file {
      width: 100%;
      margin : auto;
    }
</style>
@endsection

@section('body')

  @if(isset($customer_address_data))
    <script>
        function checkFormChanges(){
            let country = "{{ $customer_address_data->country }}";
            let state = "{{ $customer_address_data->state }}";
            let city = "{{ $customer_address_data->city }}";
            let area_or_village = "{{ $customer_address_data->area_or_village }}";
            let pincode = "{{ $customer_address_data->pincode }}";
            let landmark = "{{ $customer_address_data->landmark }}";
            let full_address = "{{ $customer_address_data->full_address }}";

            let input_country = document.getElementById('country').value;
            let input_state = document.getElementById('state').value;
            let input_city = document.getElementById('city').value;
            let input_area_or_village = document.getElementById('area_or_village').value;
            let input_pincode = document.getElementById('pincode').value;
            let input_landmark = document.getElementById('landmark').value;
            let input_full_address = document.getElementById('full_address').value;

            let save_changes_btn_slot = document.getElementById('id_for_enable_desable_save_changes_btn');

            if(input_country === country && input_state === state &&  input_city === city &&  input_area_or_village === area_or_village && input_pincode === pincode && input_landmark === landmark && input_full_address === full_address) {
                console.log("Badhu Barabar chhe");
                save_changes_btn_slot.classList.add("disabled_due_to_same_data");
            }
            else {
                console.log("Kasu barabar nathi");
                save_changes_btn_slot.classList.remove("disabled_due_to_same_data");
            }
        }
    </script>
  @endif

  <script>
      function checkFormChanges2(){
          let name = "{{ $customer_session->name }}";
          let email = "{{ $customer_session->email }}";
          let phone_no = "{{ $customer_session->phone_no }}";
          let original_profile_pic = "{{ $customer_session->profile_pic }}";

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
                      <img alt="image" src="{{ asset('storage/' . $customer_session->profile_pic)}}" class="rounded-circle author-box-picture">
                      <div class="clearfix"></div>
                      <div class="author-box-name">
                        <p class = "mt-2" style = " color : #454545; font-weight : 650; ">{{ $customer_session->name }}</p>
                      </div>
                      <div class="author-box-job">Welcome back, dear customer !</div>
                      <div class="author-box-job">stay safe, stay happy, and enjoy shopping &#10084;</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-12 col-lg-8">

                            @if (Session::has('success'))
                              <div class="alert show showAlert" style = "margin-bottom : 3%;">
                                <div>
                                  <span class="fas fa-exclamation-circle"></span>
                                  <span class="msg">{{ Session::get('success') }}</span>
                                  <div class="close-btn-anjali">
                                      <span class="fas fa-times"></span>
                                  </div>
                                </div>
                              </div>
                            @endif

                            @if (Session::has('addressError'))
                              <div  id = "msg_notification">
                                <div style="background: #ff5f80; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #ab0023; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                  <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                  <span style="flex-grow: 1;">{{ Session::get('addressError') }}</span>
                                  <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notification'); box.style.display = 'none';" id = "close--btn2"></i>
                                </div><br>
                              </div>
                            @endif

                            @if (Session::has('PhoneError'))
                              <div  id = "msg_notificationPhone">
                                <div style="background: #ff5f80; color: white; padding: 5px 10px; font-size: 1rem; border-left: 6px solid #ab0023; border-radius: 4px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                  <i class="fa-solid fa-circle-exclamation" style="margin-right: 10px;"></i>
                                  <span style="flex-grow: 1;">{{ Session::get('PhoneError') }}</span>
                                  <i class="fa-solid fa-xmark" style="cursor: pointer;" onclick = "let box = document.getElementById('msg_notificationPhone'); box.style.display = 'none';" id = "close--btn2"></i>
                                </div><br>
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
                          aria-selected="true">About</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#Profile" role="tab"
                          aria-selected="false">Profile</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#Address" role="tab"
                          aria-selected="false">Address</a>
                      </li>

                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                        <div class="row">
                          <div class="col-md-3 col-12 b-r">
                            <strong>Full Name</strong>
                            <br>
                            <p class="text-muted">{{ $customer_session->name }}</p>
                          </div>
                          <div class="col-md-3 col-12 b-r">
                            <strong>Mobile</strong>
                            <br>
                            <p class="text-muted">
                              @if($customer_session->phone_no !== NULL)
                                {{$customer_session->phone_no}}
                              @else
                                <span id = "fileName3">Not added yet !</span>
                              @endif
                            </p>
                          </div>
                          <div class="col-md-6 col-12 b-r">
                            <strong>Email</strong>
                            <br>
                            <p class="text-muted">{{ $customer_session->email }}</p>
                          </div>

                        </div>

                        <div class="row">
                          <div class="col-md-12 col-12 b-r">
                            <strong>Address</strong>
                            <br>
                            @if(isset($customer_address_data))
                              <p class="text-muted">{{ $customer_address_data->full_address }}</p>
                            @else
                              <div id="fileName2">No any address added yet !</div>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="tab-pane fade" id="Profile" role="tabpanel" aria-labelledby="profile-tab2">
                        <form method="post" action = "" id="updateForm" class="needs-validation"  enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" value="{{$customer_session->id}}" name = "customer_id">
                          <div class="card-header">
                            <h4>Edit Profile</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-md-12 col-12">
                                <label>Full Name</label>
                                <input type="text" class="form-control" oninput="checkFormChanges2();" name = "name" id = "name" value="{{ $customer_session->name }}" required>
                                <div class="invalid-feedback">
                                  Please fill in the Full name
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Email</label>
                                <input type="email" class="form-control" oninput="checkFormChanges2();" name = "email" id = "email" value="{{ $customer_session->email }}" required>
                                <div class="invalid-feedback">
                                  Please fill in the email
                                </div>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Phone</label>
                                <input type="tel" class="form-control" oninput="checkFormChanges2();" name = "phone_no" id = "phone_no" maxlength = "10" value="{{ $customer_session->phone_no !== NULL ? $customer_session->phone_no : 'Not Added Yet !' }}" required>
                              </div>
                            </div>

                            <div class="row">
                              <div class="form-group col-md-12 col-12">
                                <label>Profile pic</label>
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" onchange="showFileName(this); checkFormChanges2();" name = "profile_pic" id="profile_pic" style = "cursor : pointer;">
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

                      <div class="tab-pane fade" id="Address" role="tabpanel" aria-labelledby="profile-tab3">

                        @if(isset($customer_address_data))
                          <form action = "{{ route('updating_address') }}" method="post" class="needs-validation">
                            @csrf
                            <input type="hidden" value="{{$customer_session->id}}" name = "customer_id">
                            <div class="card-header">
                              <h4>Edit Address</h4>
                            </div>
                            <div class="card-body">

                              <div class="row">
                                <div class="form-group col-md-6 col-12">
                                  <label>Country</label>
                                  <input type="text" class="form-control" oninput="checkFormChanges();" placeholder = "Enter country name" id = "country" name = "country" value="{{ $customer_address_data->country }}" required>
                                  <div class="invalid-feedback">
                                    Please fill in the country
                                  </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                  <label>State</label>
                                  <input type="text" class="form-control" oninput="checkFormChanges();" value="{{ $customer_address_data->state }}" id = "state" name = "state" placeholder = "Enter state name" required>
                                  <div class="invalid-feedback">
                                    Please fill in the state
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-6 col-12">
                                  <label>City</label>
                                  <input type="text" class="form-control" oninput="checkFormChanges();" value="{{ $customer_address_data->city }}" id = "city" name = "city" placeholder = "Enter city name" required>
                                  <div class="invalid-feedback">
                                    Please fill in the city
                                  </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                  <label>Area/Village</label>
                                  <input type="text" class="form-control" oninput="checkFormChanges();" value="{{ $customer_address_data->area_or_village }}" name = "area_or_village" id = "area_or_village" placeholder = "Enter area/village name" required>
                                  <div class="invalid-feedback">
                                    Please fill in the area/village
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-6 col-12">
                                  <label>Pincode</label>
                                  <input type="number" class="form-control" oninput="checkFormChanges();" value="{{ $customer_address_data->pincode }}" id = "pincode" name = "pincode" placeholder = "Enter your pincode" required>
                                  <div class="invalid-feedback">
                                    Please fill in the pincode
                                  </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                  <label>Landmark</label>
                                  <input type="text" class="form-control" oninput="checkFormChanges();" value="{{ $customer_address_data->landmark }}" name = "landmark" id = "landmark" placeholder = "Enter any landmark" required>
                                  <div class="invalid-feedback">
                                    Please fill in the landmark
                                  </div>
                                </div>
                              </div>

                              <div class="form-group">
                                <label>Full Address</label>
                                <textarea class="form-control" oninput="checkFormChanges();" placeholder = "Enter Full Address" name = "full_address" id = "full_address" required>{{ $customer_address_data->full_address }}</textarea>
                              </div>

                            </div>
                            <div class="card-footer text-right">
                              <button class="btn btn-primary customer_account_save_changes disabled_due_to_same_data" id = "id_for_enable_desable_save_changes_btn">Save Changes</button>
                            </div>
                          </form>
                        @else

                            <div style = "text-align : center; margin : 4% 0 3% 0;">

                              <a class="btn btn-primary" id="profile-tab4" data-toggle="tab" href="#AddAddress" role="tab" aria-selected="false">Add Address</a>

                            </div>
                        @endif

                      </div>

                      <div class="tab-pane fade" id="AddAddress" role="tabpanel" aria-labelledby="profile-tab4">

                          <form action = "{{ route('adding_address') }}" method="post" class="needs-validation">
                            @csrf
                            <input type="hidden" value="{{$customer_session->id}}" name = "customer_id">

                            <div class="card-header">
                              <h4>Add Address</h4>
                            </div>

                            <div class="card-body">

                              <div class="row">
                                <div class="form-group col-md-6 col-12">
                                  <label>Country</label>
                                  <input type="text" class="form-control" name = "country" placeholder = "Enter country name" value="" required>
                                  <div class="invalid-feedback">
                                    Please fill in the country
                                  </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                  <label>State</label>
                                  <input type="text" class="form-control" name = "state" placeholder = "Enter state name" value="" required>
                                  <div class="invalid-feedback">
                                    Please fill in the state
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-6 col-12">
                                  <label>City</label>
                                  <input type="text" class="form-control" name = "city" value="" placeholder = "Enter city name" required>
                                  <div class="invalid-feedback">
                                    Please fill in the city
                                  </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                  <label>Area/Village</label>
                                  <input type="text" class="form-control" name = "area_or_village" value="" placeholder = "Enter area/village name" required>
                                  <div class="invalid-feedback">
                                    Please fill in the area/village
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="form-group col-md-6 col-12">
                                  <label>Pincode</label>
                                  <input type="number" class="form-control" name = "pincode" value="" placeholder = "Enter your pincode" required>
                                  <div class="invalid-feedback">
                                    Please fill in the pincode
                                  </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                  <label>Landmark</label>
                                  <input type="text" class="form-control" name = "landmark" value="" placeholder = "Enter any landmark" required>
                                  <div class="invalid-feedback">
                                    Please fill in the landmark
                                  </div>
                                </div>
                              </div>

                              <div class="form-group">
                                <label>Full Address</label>
                                <textarea class="form-control" name = "full_address" placeholder = "Enter Full Address" required></textarea>
                              </div>

                            </div>
                            <div class="card-footer text-right" style = "display: flex; justify-content: flex-end; gap: 1rem;">
                              <button onclick="location.reload();" type = "button" class="btn btn-primary">Exit</button>
                              <button class="btn btn-primary">Add Address</button>
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
                    form.action = '/updating_profile';
                } else if ((currentData.name !== initialData.name || currentData.profile_pic !== initialData.profile_pic) && (currentData.email === initialData.email && currentData.phone_no === initialData.phone_no)) {
                    form.action = '/updating_profile2';
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