<div class="right-sec bg-white">
  <div class="edt-wrap">
    <h3 class="page-header text-center">{{$data['userData']['user_username']}}  Reset Password</h3>
  <div class="row">
   <div class="col-md-12"> 
    <!-- <form method="post" class="reset-pass clearfix">
      <div class="form-group">
        <label for="">Old Password</label><br>
        <input type="password" name="old_password" value="" class="form-control" required="">
      </div> -->
      @if(!empty(Session::get('success')))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get('success')}}
        </div>
        @endif
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</div>
            @endforeach
        @endif
    <form enctype="multipart/form-data" class="reset-pass clearfix" id="" method="post" >
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
      
      <div class="form-group">
        <label for="">Username <span style="color: red"> &nbsp; * </span></label><br>
        <input type="text" name="" readonly="readonly" value="{{$data['userData']['user_username']}}" class="form-control" required="">
      </div>

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