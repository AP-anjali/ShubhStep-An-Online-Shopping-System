@extends('admin_dashboard_layout')

@section('title')
<title>Contact Form Mails</title>
@endsection

@section('style')
<style>
   .gfg {
            border-collapse:separate;
            border-spacing:0 15px;
        }
</style>
@endsection

@section('body')
    <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                            
                <div class="card">
                  <div class="card-header">
                    <h4>Contact Form Mails</h4>
                  </div>
                  <div class="card-body">
                    
                    @if(isset($AllContactMails))
                        @if(count($AllContactMails) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped gfg" id="table-1" style = "text-align : center;">
                                    <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th style="vertical-align: middle;">Customer Name</th>
                                        <th style="vertical-align: middle;">E-Mail</th>
                                        <th style="vertical-align: middle;">Phone Number</th>
                                        <th style="vertical-align: middle;">Mail Message</th>
                                        <th style="vertical-align: middle;">Mail Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @php
                                        $srNo = 1; 
                                    @endphp

                                    @foreach($AllContactMails as $eachMail)

                                        <tr>
                                            <td style = "text-align : center;">{{ $srNo++ }}</td>
                                            <td style = "text-align : center;">{{ $eachMail->name }}</td>
                                            <td style = "text-align : center;">{{ $eachMail->email }}</td>
                                            <td style = "text-align : center;">{{ $eachMail->phone_no }}</td>
                                            <td style = "text-align : center;">{{ $eachMail->message }}</td>
                                            <td style = "text-align : center;">{{ $eachMail->date_time }}</td>
                                        </tr>
                                        
                                    @endforeach
                                
                                    </tbody>
                                </table>

                            </div>

                        @else
                            <div style = "text-align : center;">
                                <img src="{{ asset('img/images/no_data.jpg') }}" id = "nothing">
                            </div>
                        @endif
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
@endsection

@section('script')
  <script>
    let Contact_Mails = document.getElementById("Contact_Mails");
    Contact_Mails.classList.add("active");
  </script>
@endsection