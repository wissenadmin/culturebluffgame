<link rel="stylesheet" href="{{url('/resources/admin-html')}}/assets/css/sweetalert.css" />
<style type="text/css">
	.pad5{ 
			padding-top: 6px;
		}
</style>
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

			<!-- PAGE CONTENT BEGINS -->
			<form class="form-horizontal" role="form" method="post">
			<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Game Title <span style="color: red"> &nbsp; * </span> </label>
					<div class="col-sm-9">
						<input type="text" id="form-field-1" @if(!empty($data['oldData'])) value="{{$data['oldData']['game_title']}}" readonly="readonly" @else value="{{old('game_title')}}"  @endif placeholder="Game Title" name="game_title"  class="col-xs-10 col-sm-5" />
					</div>
				</div>
		        @if(!empty($data['oldData']))
			        <div class='form-group'>
					{!! Form::label('country_id', 'Assigned Country',['class' => 'col-sm-3 control-label no-padding-right']) !!}
					  <div class="col-sm-9">
					  	<!-- {!! Form::text('country_id','', ['placeholder' => 'country', 'class' => 'col-xs-10 col-sm-5']) !!} -->
					  	 	<select class="'col-xs-10 col-sm-5" name="country_id" required="required">
					  		@foreach($data['countryList'] as $key => $value)
					  			<option @if($data['oldData']['country_id'] == $value->country_id) selected="selected" @endif 
					  			value="{{$value->country_id}}">{{$value->country_name}}</option>
					  		@endforeach
					  	</select>
					  </div>
					</div>
				@else

				<div class='form-group'>
					{!! Form::label('country_id', 'Assigned Country',['class' => 'col-sm-3 control-label no-padding-right']) !!}
					  <div class="col-sm-9">
					  	<!-- {!! Form::text('country_id','', ['placeholder' => 'country', 'class' => 'col-xs-10 col-sm-5']) !!} -->
					  	 	<select class="'col-xs-10 col-sm-5" name="country_id" required="required">
					  		@foreach($data['countryList'] as $key => $value)
					  			<option value="{{$value->country_id}}">{{$value->country_name}}</option>
					  		@endforeach
					  	</select>
					  </div>
					</div>

				@endif

				<div class='form-group'>
					{!! Form::label('supertrial', 'Supertrial',['class' => 'col-sm-3 control-label no-padding-right']) !!}
					  <div class="col-sm-9 pad5">

					 <input type="radio" @if(!empty($data['oldData']) )
		              @if($data['oldData']['is_supertrial'] == 1)
		              checked="checked"
		              @endif
		                @else checked="checked" @endif class="supertrial"   name="is_supertrial" value="1">
		              Yes
		              <input @if(!empty($data['oldData']) )
		              @if($data['oldData']['is_supertrial'] == 0)
		             	checked="checked"
		              @endif
		                @else      @endif class="supertrial" type="radio"  name="is_supertrial" value="0">

		              No 
					  </div>
				</div>

				<div class='form-group'>
					{!! Form::label('is_trial', 'Trial',['class' => 'col-sm-3 control-label no-padding-right']) !!}
					  <div class="col-sm-9 pad5">

					 <input type="radio" @if(!empty($data['oldData']) )
		              @if($data['oldData']['is_trial'] == 1)
		              checked="checked"
		              @endif
		                @else  @endif name="is_trial" class="trial" value="1">
		              Yes
		              <input @if(!empty($data['oldData']) )
		              @if($data['oldData']['is_trial'] == 0)
		              checked="checked"
		              @endif
		                @else  @endif type="radio"  name="is_trial" value="0" class="trial">
		              No 
					  </div>
				</div>

				<div class="space-4"></div>
				<div class="form-group">
		            <label class="col-sm-3 control-label">Game Description <span style="color: red"> &nbsp; * </span> </label>
		            <div class="col-sm-9">
		            
		            <textarea name="game_description" rows="3" cols="12" class="col-xs-10 col-sm-5 textarea">
		            	@if(!empty($data['oldData'])) {{$data['oldData']['game_description']}} @else {{old('game_description')}} @endif 
		            	</textarea>
		              </div>
		        </div>
				<div class="space-4"></div>
				<div class="form-group">
		            <label class="col-sm-3 control-label">Status <span style="color: red"> &nbsp; * </span> </label>
		            <div class="col-sm-9">
		              <input type="radio" @if(!empty($data['oldData']) )
		              @if($data['oldData']['game_is_active'] == 1)
		              checked="checked"
		              @endif
		                @else checked="checked" @endif    name="game_is_active" value="1">
		              Active
		              <input @if(!empty($data['oldData']) )
		              @if($data['oldData']['game_is_active'] == 0)
		              checked="checked"
		              @endif
		                @else  @endif type="radio"  name="game_is_active" value="0">
		              Inactive </div>
		        </div>


				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-info" type="submit">
						<i class="ace-icon fa fa-check bigger-110"></i>
						Submit
					</button>

					&nbsp; &nbsp; &nbsp;
					<button onclick="redirect('{{url('admin/games')}}');" class="btn" type="reset">
						<i class="ace-icon fa fa-undo bigger-110"></i>
						Back
					</button>
				</div>
			</form>
			<div class="hr hr-18 dotted hr-double"></div>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
<div class="hide">
	<form id="supertrial">
		<input type="text" name="supertrial" value="1">
		<input type="text" name="trial" value="0">
		<input type="text" name="editFlag" @if(!empty($data['oldData'])) value="{{$data['oldData']['game_id']}}" @else value="0" @endif>
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

	</form>
	<form id="trial">
		<input type="text" name="supertrial" value="0">
		<input type="text" name="trial" value="1">
		<input type="text" name="editFlag" @if(!empty($data['oldData'])) value="{{$data['oldData']['game_id']}}" @else value="0" @endif>
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
	</form>
</div>

<script src="{{url('/resources/admin-html')}}/assets/js/sweetalert.min.js"></script>

<script type="text/javascript">
	$('.trial').change( function(){
       checkd = $(this).val();
       var element = this;
        var datastring = $("#trial").serialize();
        if(checkd == 1){
	        $.ajax({
	            url: '<?php echo url('admin/checktrial'); ?>',
	            type: 'post',
	            data:datastring,
	            dataType: 'json',
	            success: function(data){
	                if(data.avilable != 1){
	                	swal("", "A game is already assigned as a Trial.", "error");
	                	element.checked = false;  
	                	return false;
	                }
	            }
	        });
    	}
    });

    $('.supertrial').change( function(){
        checkd = $(this).val();
        var element = this;
        var datastring = $("#supertrial").serialize();
        if(checkd == 1){
	        $.ajax({
	            url: '<?php echo url('admin/checktrial'); ?>',
	            type: 'post',
	            data:datastring,
	            dataType: 'json',
	            success: function(data){
	            	if(data.avilable != 1){
		                swal("", "A game is already assigned as a SuperTrial", "error");
		                //$(this).attr("checked","false");
		                element.checked = false;
		                return false;
	            	}
	            }
	        });
    	}
    });

</script>
<script src="{{url()}}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="{{url()}}/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>
    $('.textarea').ckeditor();
    // $('.textarea').ckeditor(); // if class is prefered.
</script>