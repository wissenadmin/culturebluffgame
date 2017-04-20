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
				{!! Form::label('Username', 'Username',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('user_username',$data['oldData']['user_username'], ['placeholder' => 'Username', 'class' => 'col-xs-10 col-sm-5','readonly'=> 'readonly' ]) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('Email', 'Email',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('email',$data['oldData']['email'], ['placeholder' => 'Email', 'class' => 'col-xs-10 col-sm-5', 'readonly'=> 'readonly']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('first_name', 'first name',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('first_name',$data['oldData']['users_infos']['first_name'], ['placeholder' => 'first name', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>


				<div class='form-group'>
				{!! Form::label('middle_name', 'Middle name',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('middle_name',$data['oldData']['users_infos']['middle_name'], ['placeholder' => 'Middle name', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('last_name', 'Last name',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('last_name',$data['oldData']['users_infos']['last_name'], ['placeholder' => 'Last name', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('company_name', 'Company name',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('company_name',$data['oldData']['users_infos']['company_name'], ['placeholder' => 'Company name', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('designation', 'Designation',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('designation',$data['oldData']['users_infos']['designation'], ['placeholder' => 'Designation', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('sector', 'Sector',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('sector',$data['oldData']['users_infos']['sector'], ['placeholder' => 'Sector', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				<!-- <div class='form-group'>
				{!! Form::label('country_id', 'Country',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('country_id',$data['oldData']['users_infos']['country_id'], ['placeholder' => 'country', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div> -->
				<div class='form-group'>
				{!! Form::label('country_id', 'Country',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	<!-- {!! Form::text('country_id','', ['placeholder' => 'country', 'class' => 'col-xs-10 col-sm-5']) !!} -->
				  	 	<select class="'col-xs-10 col-sm-5" name="country_id" required="required">
				  		@foreach($data['countryList'] as $key => $value)
				  			<option @if($value->country_id == $data['oldData']['users_infos']['country_id'])
				  			selected="select"
				  			  @endif value="{{$value->country_id}}">{{$value->country_name}}</option>
				  		@endforeach
				  	</select>
				  </div>
				</div>

				<div class='form-group'>
				{!! Form::label('company_website', 'Company Website',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('company_website',$data['oldData']['users_infos']['company_website'], ['placeholder' => 'company_website', 'class' => 'col-xs-10 col-sm-5']) !!}
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
				  <button onclick="redirect('{{url("admin/".$data['returnurl']."")}}');" class="btn" type="reset">
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
<script>
    $('.textarea').ckeditor();
    // $('.textarea').ckeditor(); // if class is prefered.
</script>
