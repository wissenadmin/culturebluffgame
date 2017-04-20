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

				<!-- {!! Form::label('PageTitle', 'Page Title',['class' => 'col-sm-3 control-label no-padding-right']) !!} -->
				<div class="col-sm-3 control-label no-padding-right"> 
					<label for="">Page Title <span style="color: red"> &nbsp; * </span></label>
				</div>
				  <div class="col-sm-9">
				  	{!! Form::text('page_title',$data['oldData']['page_title'], ['placeholder' => 'Page title', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>

				@else
				  <!-- {!! Form::label('PageTitle', 'Page Title',['class' => 'col-sm-3 control-label no-padding-right']) !!} -->
				<div class="col-sm-3 control-label no-padding-right"> 
					<label for="">Page Title <span style="color: red"> &nbsp; * </span></label>
				</div>
				  <div class="col-sm-9">
				  	{!! Form::text('page_title','', ['placeholder' => 'Page title', 'class' => 'col-xs-10 col-sm-5']) !!}
				  </div>
				</div>
				@endif
				@if(!empty($data['oldData']))
				<div class='form-group'>
				  <!-- {!! Form::label('PageSlug', 'Page Slug',['class' => 'col-sm-3 control-label no-padding-right']) !!} -->

				<div class="col-sm-3 control-label no-padding-right"> 
					<label for="">Page Slug <span style="color: red"> &nbsp; * </span></label>
				</div>

				  <div class="col-sm-9">
				  	{!! Form::text('page_slug',$data['oldData']['page_slug'], ['placeholder' => 'Page Slug', 'class' => 'col-xs-10 col-sm-5','disabled'=>'true']) !!}
				  </div>
				</div>
				@endif

				<div class='form-group'>
				  <!-- {!! Form::label('page_description', 'Page Description',['class' => 'col-sm-3 control-label no-padding-right']) !!} -->

				<div class="col-sm-3 control-label no-padding-right"> 
					<label for="">Page Description <span style="color: red"> &nbsp; * </span></label>
				</div>

				  <div class="col-sm-9">
				  	@if(!empty($data['oldData']['page_description']))
				  		{!! Form::textarea('page_description',$data['oldData']['page_description'], ['class' => 'col-xs-10 col-sm-5 textarea']) !!}
				  	@else
				  		{!! Form::textarea('page_description','', ['class' => 'col-xs-10 col-sm-5 textarea']) !!}
				  	@endif	
				  </div>
				</div>

				<div class="form-group">
		            <!-- {!! Form::label('status', 'Status',['class' => 'col-sm-3 control-label no-padding-right']) !!} -->
		            <div class="col-sm-3 control-label no-padding-right"> 
					<label for="">Status <span style="color: red"> &nbsp; * </span></label>
				</div>
		            
		            <div class="col-sm-9">
		              <input type="radio" @if(!empty($data['oldData']) )
		              @if($data['oldData']['page_is_active'] == 1)
		              checked="checked"
		              @endif
		                @else checked="checked" @endif    name="page_is_active" value="1">
		              Active
		              <input @if(!empty($data['oldData']) )
		              @if($data['oldData']['page_is_active'] == 0)
		              checked="checked"
		              @endif
		                @else  @endif type="radio"  name="page_is_active" value="0">
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
<script>
$('.textarea').ckeditor( {allowedContent: 'a[!href]; ul; li{text-align}; img[src]; div; h1;h2;h3;h4;h5;h6; table;tr;td;th;tbody'});
/*    editor.config.extraAllowedContent = 'div(*)';*/

    /*CKEDITOR.replace('.textarea',);*/

    // $('.textarea').ckeditor(); // if class is prefered.
</script>
