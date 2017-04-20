<link rel="stylesheet" href="{{url('/resources/admin-html')}}/assets/css/sweetalert.css" />
<script src="{{url('/resources/admin-html')}}/assets/js/sweetalert.min.js"></script>


<div class="right-sec bg-white">
    <div class="edt-wrap">
        

        <h3 class="page-header"><b>Edit Profile</b></h3>
        

        @if(!empty(Session::get('success')))
        <script type="text/javascript">
            swal("", "", "success");  
          </script>
        @endif


        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</div>
            @endforeach
        @endif
    <form enctype="multipart/form-data" id="trialrequestform" method="post" >
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">First name <span style="color: red"> &nbsp; * </span></label>
                        <input type="text" class="form-control" value="{{$data['userData']['users_infos']->first_name}}"  name="first_name">
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Last name <span style="color: red"> &nbsp; * </span></label>
                        <input type="text" class="form-control"  value="{{$data['userData']['users_infos']->last_name}}"  name="last_name">
                    </div>
                </div>
                @if(Auth::user()->user_type == 2)
                <div class="col-md-6">
                    <div class="form-group">
                            <label for="">Company Name</label>
                            <input type="text" value="{{$data['userData']['users_infos']->company_name}}"  class="form-control"  name="company_name">
                    </div>  
                </div>  

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Designation</label>
                        <input type="text" class="form-control"  value="{{$data['userData']['users_infos']->designation}}"  name="designation">
                    </div>
                    
                </div>
              

                 <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Sector</label>
                        <input type="text" class="form-control"  value="{{$data['userData']['users_infos']->sector}}" name="sector">
                    </div>
                </div>    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Company Website @if(Auth::user()->user_type == 2) <span style="color: red"> &nbsp; * </span>  @endif</label>
                        <input type="text" class="form-control" value="{{$data['userData']['users_infos']->company_website}}"  name="company_website">
                    </div>
                </div>

                @endif
                

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Country <span style="color: red"> &nbsp; * </span></label>
                        <select class="form-control" name="country_id"  >
                        {{getCountryOptionSrt($data['userData']['users_infos']->country_id)}}
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">User Name </label>
                        <input type="text"  class="form-control" readonly="readonly"  value="{{$data['userData']->user_username}}"  name="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Email address</label>
                        <input type="email"  class="form-control"  value="{{$data['userData']->email}}"  readonly="readonly" name="">
                    </div>
                </div>
                </div>
            <button style="margin-right:20px" class="btn btn-grn pull-right submittrial" type="submit" >Update </button>
                </form>
      </div>