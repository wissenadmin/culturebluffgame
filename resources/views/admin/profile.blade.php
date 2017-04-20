<div class="page-content">
	<!-- /.ace-settings-container -->
	<div class="page-header">
		<h1>
			Admin
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				Profile
			</small>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<?php //$success =  Session::get('success');?>
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
			{!! Form::open(['role' => 'form','method'=>'post','class'=>'form-horizontal']) !!}
		      <div class='form-group'>
		          {!! Form::label('username', 'Username',['class' => 'col-sm-3 control-label no-padding-right']) !!}
		          <div class="col-sm-9">
		          	{!! Form::text('user_username', Auth::user()->user_username, ['placeholder' => 'Username', 'class' => 'col-xs-10 col-sm-5','readonly'=>'readonly']) !!}
		          </div>
		      </div>
		      <div class="space-4"></div>
		      <div class='form-group'>
		          {!! Form::label('email', 'Email' , ['class' => 'col-sm-3 control-label no-padding-right']) !!}
		          <div class="col-sm-9">
		          	{!!Form::text('email', Auth::user()->email, ['placeholder' => 'Last Name', 'class' => 'col-xs-10 col-sm-5','readonly'=>'readonly']) !!}
		          </div>
		      </div>
		   <div class="space-4"></div>
		      <div class='form-group'>
		          {!! Form::label('password', 'Password' , ['class' => 'col-sm-3 control-label no-padding-right']) !!}
		          <div class="col-sm-9">
		          	{!! Form::password('password', ['placeholder' => 'Password', 'class' => 'col-xs-10 col-sm-5']) !!}
		          </div>
		      </div>
		      <div class="space-4"></div>
		      <div class='form-group'>
		          {!! Form::label('password_confirmation', 'Password Confirm', ['class' => 'col-sm-3 control-label no-padding-right']) !!}
		          <div class="col-sm-9">
		          	{!! Form::password('password_confirmation', ['placeholder' => 'Password Confirm', 'class' => 'col-xs-10 col-sm-5']) !!}
		          </div>
		      </div>
		      <div class="space-4"></div>
		      <div class='col-md-offset-3 col-md-9'>
		          {!! Form::submit('Update Profile', ['class' => 'btn btn-primary']) !!}
		          {!! Form::reset('Reset', ['class' => 'btn']) !!}
		      </div>
		      
		    {!! Form::close() !!}

			<div class="hr hr-18 dotted hr-double"></div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
				