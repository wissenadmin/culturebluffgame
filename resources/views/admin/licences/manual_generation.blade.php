<div class="page-content">
	<!-- /.ace-settings-container -->
	<div class="page-header">
		<h1>
			Admin
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				{{$data['page_title']}}
			</small>
		</h1>
	</div><!-- /.page-header -->
	<div class="row ">
	<div class="col-xs-12 ">
	{!! Form::open(['role' => 'form','method'=>'post','class'=>'form-horizontal']) !!}
	<!-- <label>Select generation User Type</label> <br>-->
	<div class="col-sm-3"></div>
	<input type="radio" name="select_type" class="formtype" checked="checked" value="1"> &nbsp;
	<b>Create new user account </b> &nbsp;
	<input type="radio" class="formtype" name="select_type" value="0"> &nbsp;
	<b>Already registered user</b>
	</form>
	</div>
	</div>



	<div class="row" style="margin-top: 10px">

		@if (count($errors) > 0)
	            @foreach ($errors->all() as $error)
	                <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</div>
	            @endforeach
	        @endif

	<div class="col-xs-12 addform ">
			

			{!! Form::open(['role' => 'form','method'=>'post','class'=>'form-horizontal']) !!}
				<div class='form-group'>
				{!! Form::label('first_name', 'First name',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('first_name','', ['value'=>old('first_name'), 'placeholder' => 'first name', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('last_name', 'Last name',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('last_name','', ['value'=>old('last_name'), 'placeholder' => 'Last name', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<!-- <div class="form-group">
                    <label class="control-label col-lg-2" for="cname">Account Type <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <select name="user_type" class="form-control" >
                            <option value="1">Individual User</option>
                            <option value="2">Individual User</option>
                        </select>
                        
                    </div>
                </div> -->
                <div class='form-group'>
				{!! Form::label('AccountType', 'Account Type',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  		<select name="user_type" class="col-xs-10 col-sm-5" >
                            <option value="1">Individual </option>
                            <option value="2">Corporate </option>
                        </select>
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('company_name', 'Company name',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	 {!! Form::text('company_name','', ['value'=>old('company_name'), 'placeholder' => 'Company name', 'class' => 'col-xs-10 col-sm-5']) !!} 
				 
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('designation', 'Designation',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('designation','', ['value'=>'','placeholder' => 'Designation', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('sector', 'Sector',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('sector','', ['value'=>'', 'placeholder' => 'Sector', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('country_id', 'Country',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	<!-- {!! Form::text('country_id','', ['value'=>'', 'placeholder' => 'country', 'class' => 'col-xs-10 col-sm-5']) !!} -->
				  	 	<select class="'col-xs-10 col-sm-5" name="country_id" required="required">
				  		@foreach($data['countryList'] as $key => $value)
				  			<option value="{{$value->country_id}}">{{$value->country_name}}</option>
				  		@endforeach
				  	</select>
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('company_website', 'Company Website',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('company_website','', ['value'=>'', 'placeholder' => 'company_website', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('Username', 'Username',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('user_username','', ['value'=>'', 'placeholder' => 'Username', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('Email', 'Email',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('email','', ['value'=>'', 'placeholder' => 'Email', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('Password', 'Password',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::password('password','', [ 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('Password', 'Confirm Password',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::password('password_confirmation','', [ 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				
				<input type="hidden" name="types" value="1">
				<div class="space-4"></div>
				<div class='col-md-offset-3 col-md-9'>
				  {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
				  <button onclick="redirect('{{url('admin/licences-report')}}');" class="btn" type="reset">
						<i class="ace-icon fa fa-undo bigger-110"></i>
						Back
					</button>
				  
				  
				</div>
		      
		    {!! Form::close() !!}

			<div class="hr hr-18 dotted hr-double"></div>
		</div><!-- /.col -->
		<div class="col-xs-12 alreadyuser hide">
			{!! Form::open(['role' => 'form','method'=>'post','class'=>'form-horizontal']) !!}
				<div class='form-group'>
				{!! Form::label('Select User', 'Select User',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	<select class="form-control" name="user_id" required="required">
				  		@foreach($data['user_list'] as $key => $value)
				  			<option value="{{$value->user_id}}">{{$value->user_username}} @if($value->user_type == 1) - Individual @else - Corporate @endif </option>
				  		@endforeach
				  	</select>
				  </div>
				</div>
				<input type="hidden" name="types" value="0">
			<div class="space-4"></div>
				<div class='col-md-offset-3 col-md-9'>
				  {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
				  <button onclick="redirect('{{url('admin/licences-report')}}');" class="btn" type="reset">
						<i class="ace-icon fa fa-undo bigger-110"></i>
						Back
					</button>
				  
				  
				</div>
		      
		    {!! Form::close() !!}
		</div>

	</div><!-- /.row -->
</div><!-- /.page-content -->

<script src="{{url()}}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="{{url()}}/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>
    $('.textarea').ckeditor();
    $(".formtype").change(function(){
    	val = $(this).val();
    	if(val == 1){
    		$(".addform").removeClass("hide");
    		$(".alreadyuser").addClass("hide");

    	}else{
    		$(".alreadyuser").removeClass("hide");
    		$(".addform").addClass("hide");
    	}
   
    })

    // $('.textarea').ckeditor(); // if class is prefered.
</script>
