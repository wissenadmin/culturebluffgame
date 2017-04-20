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
				@if(!empty($data['oldData']))

				{!! Form::label('LicenceTitle', 'License Title',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('licence_type',$data['oldData']['licence_type'], ['placeholder' => 'License Title', 'class' => 'col-xs-10 col-sm-5','readonly'=>'readonly']) !!}
				  </div>
				

				@else
				  {!! Form::label('LicenceTitle', 'License Title',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::text('licence_type','', ['placeholder' => 'License Title', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				
				@endif
				</div>
				<div class='form-group'>
				@if(!empty($data['oldData']))

				{!! Form::label('licence_period', 'License Period (Days)',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::number('licence_period',$data['oldData']['licence_period'], ['placeholder' => 'License Period', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				

				@else
				  {!! Form::label('licence_period', 'License Period (Days)',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::number('licence_period','', ['placeholder' => 'License Period', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				
				@endif
				</div>

				<div class='form-group'>
				@if(!empty($data['oldData']))

				{!! Form::label('licence_price', 'License Unit Price (GBP)',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::number('licence_price',$data['oldData']['licence_price'], ['placeholder' => 'License Price', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				

				@else
				  {!! Form::label('licence_price', 'License Unit Price (GBP)',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	{!! Form::number('licence_price','', ['placeholder' => 'License Price', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				
				@endif
				</div>

				<div class='form-group'>
				@if(!empty($data['oldData']))
					{!! Form::label('Select Game', 'Game Title',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  
				  	<!-- {!! Form::number('licence_price','', ['placeholder' => 'License Price', 'class' => 'col-xs-10 col-sm-5']) !!} -->
				  	<select class="col-xs-10 col-sm-5" name="game_id">
				  		@foreach($data['games'] as $key => $value)
				  		<option @if($data['oldData']['game_id'] == $value->game_id) selected="selected" @endif  value="{{$value->game_id}}"> {{$value->game_title}} </option>
				  		@endforeach
				  	</select>
				  </div>

				@else
				  {!! Form::label('Select Game', 'Game Title',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	<!-- {!! Form::number('licence_price','', ['placeholder' => 'License Price', 'class' => 'col-xs-10 col-sm-5']) !!} -->
				  	<select class="col-xs-10 col-sm-5" name="game_id">
				  		@foreach($data['games'] as $key => $value)

				  		<option  
		               value="{{$value->game_id}}"> {{$value->game_title}} </option>
				  		@endforeach
				  	</select>
				  </div>
				@endif
				</div>



				<div class='form-group'>
				  {!! Form::label('licence_text', 'License Description',['class' => 'col-sm-3 control-label no-padding-right']) !!}
				  <div class="col-sm-9">
				  	@if(!empty($data['oldData']['licence_text']))
				  		{!! Form::textarea('licence_text',$data['oldData']['licence_text'], ['class' => 'col-xs-10 col-sm-5 textarea']) !!}
				  	@else
				  		{!! Form::textarea('licence_text','', ['class' => 'col-xs-10 col-sm-5 textarea']) !!}
				  	@endif	
				  </div>
				</div>

				<div class="form-group">
		            {!! Form::label('status', 'Status',['class' => 'col-sm-3 control-label no-padding-right']) !!}
		            <div class="col-sm-9">
		              <input type="radio" @if(!empty($data['oldData']) )
		              @if($data['oldData']['licence_is_active'] == 1)
		              checked="checked"
		              @endif
		                @else checked="checked" @endif    name="licence_is_active" value="1">
		              Active
		              <input @if(!empty($data['oldData']) )
		              @if($data['oldData']['licence_is_active'] == 0)
		              checked="checked"
		              @endif
		                @else  @endif type="radio"  name="licence_is_active" value="0">
		              Inactive 
		            </div>
		        </div>

				<div class="space-4"></div>
				<div class='col-md-offset-3 col-md-9'>
				  {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
				  <button onclick="redirect('{{url('admin/licences')}}');" class="btn" type="reset">
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
