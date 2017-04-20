<link rel="stylesheet" href="{{url('resources/admin-html')}}/assets/css/datepicker.min.css" />
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
	<div class="row">
		<div class="col-xs-12">
			@if (count($errors) > 0)
	            @foreach ($errors->all() as $error)
	                <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</div>
	            @endforeach
	        @endif

			{!! Form::open(['role' => 'form','method'=>'post','class'=>'form-horizontal']) !!}
				<div class='form-group'>
				{!! Form::label('first_name', 'First name',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('first_name','', ['placeholder' => 'first name', 'class' => 'col-xs-10 col-sm-5','value'=>old('first_name')]) !!}

				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('last_name', 'Last name',['class' => 'col-sm-3 control-label no-padding-right','value'=>old('last_name')]) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('last_name','', ['placeholder' => 'Last name', 'class' => 'col-xs-10 col-sm-5']) !!}
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
				{!! Form::label('UserType', 'User Type',['class' => 'col-sm-3 control-label no-padding-right']) !!}
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
				  	 {!! Form::text('company_name','', ['placeholder' => 'Company name', 'class' => 'col-xs-10 col-sm-5','value'=>old('company_name')]) !!} 
				 
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('designation', 'Designation',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('designation','', ['placeholder' => 'Designation', 'class' => 'col-xs-10 col-sm-5','value'=>old('designation')]) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('sector', 'Sector',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('sector','', ['placeholder' => 'Sector', 'class' => 'col-xs-10 col-sm-5','value'=>old('sector')]) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('country_id', 'Country',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	<!-- {!! Form::text('country_id','', ['placeholder' => 'country', 'class' => 'col-xs-10 col-sm-5']) !!} -->
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
				  	{!! Form::text('company_website','', ['placeholder' => 'company_website', 'class' => 'col-xs-10 col-sm-5','value'=>old('company_website')]) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('Username', 'Username',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	

				  	<input type="text" name="user_username" placeholder="Username" class="col-xs-10 col-sm-5" value="{{old('user_username')}}">
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('Email', 'Email',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('email','', ['placeholder' => 'Email', 'class' => 'col-xs-10 col-sm-5','value'=>old('email')]) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('Password', 'Password',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::password('password', [ 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('Password', 'Confirm Password',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::password('password_confirmation','', [ 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<!-- <div class='form-group'>
				{!! Form::label('expire date', 'Expire date',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('licence_valid_till','', [ 'class' => 'col-xs-10 col-sm-5 date']) !!}
				  	<input class="date-picker col-xs-10 col-sm-5" name="licence_valid_till" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy">
				  </div>
				</div> -->

				<div class="form-group">
		            {!! Form::label('status', 'Status',['class' => 'col-sm-3 control-label no-padding-right']) !!}
		            <div class="col-sm-9">
		              <input type="radio" @if(!empty($data['oldData']) )
		              @if($data['oldData']['user_is_active'] == 1)
		              checked="checked"
		              @endif
		                @else checked="checked" @endif    name="user_is_active" value="1">
		              Active
		              <input @if(!empty($data['oldData']) )
		              @if($data['oldData']['user_is_active'] == 0)
		              checked="checked"
		              @endif
		                @else  @endif type="radio"  name="user_is_active" value="0">
		              Inactive 
		            </div>
		        </div>

				<div class="space-4"></div>
				<div class='col-md-offset-3 col-md-9'>
				  {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
				  <button onclick="redirect('{{url('admin/static-page')}}');" class="btn" type="reset">
						<i class="ace-icon fa fa-undo bigger-110"></i>
						Back
					</button>
				  
				  <a href="">
				</div>
		      
		    {!! Form::close() !!}

			<div class="hr hr-18 dotted hr-double"></div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->

<script src="{{url()}}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="{{url()}}/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script src="{{url('resources/admin-html')}}/assets/js/bootstrap-datepicker.min.js"></script>
<script>
    $('.textarea').ckeditor();
    $('.date-picker').datepicker({
		autoclose: true,
		todayHighlight: true
	})
    // $('.textarea').ckeditor(); // if class is prefered.
</script>
