<link rel="stylesheet" href="{{url('/resources/admin-html')}}/assets/css/sweetalert.css" />
<script src="{{url('/resources/admin-html')}}/assets/js/sweetalert.min.js"></script>

<div class="right-sec bg-white">
  <div class="edt-wrap">
    <h3 class="page-header"><b>Reset Password</b></h3>
  <div class="row">
   <div class="col-md-12"> 
    <!-- <form method="post" class="reset-pass clearfix">
      <div class="form-group">
        <label for="">Old Password</label><br>
        <input type="password" name="old_password" value="" class="form-control" required="">
      </div> -->
        
         @if(!empty(Session::get('success')))
        <script type="text/javascript">					swal({						title: '',						text: 'Password was successfully updated.',						imageUrl: 'http://181.224.157.105/~hirepeop/host1/codebackup/resources/assets/front/images/CB.jpg',						imageWidth: 400,						imageHeight: 120,						animation: false						});
           
          </script>
        @endif


        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</div>
            @endforeach
        @endif
    <form enctype="multipart/form-data" class="reset-pass clearfix" id="" method="post" >
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
      <div class="form-group">
        <label for="">New Password <span style="color: red"> &nbsp; * </span></label><br>
        <input type="password" name="password" value="" class="form-control" required="">
      </div>
      <div class="form-group">
        <label for="">Confirm New Password <span style="color: red"> &nbsp; * </span></label><br>
        <input type="password" name="password_confirmation" value="" class="form-control" required="">
      </div>
      
      <div class="pull-right">
        <button type="submit" class="btn btn-grn">Change Password</button>
      </div>
    </form>
    </div>
    </div>
                  
  </div>
</div>