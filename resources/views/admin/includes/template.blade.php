@include('admin.includes.header')
@include('admin.includes.left')
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs" id="breadcrumbs">
			<script type="text/javascript">
				try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
			</script>

			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="{{url('admin')}}">Home</a>
				</li>
				<!--  -->
				@foreach($data['breadcrumb'] as $key =>$value)
				<li>
					<a href="#">{{$value}}</a>
				</li>
				@endforeach
				
			</ul>

			<!-- <div class="nav-search" id="nav-search">
				<form class="form-search">
					<span class="input-icon">
						<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
						<i class="ace-icon fa fa-search nav-search-icon"></i>
					</span>
				</form>
			</div> --><!-- /.nav-search -->
		</div>
		<?php 

		/*$users = User::where('id',1)->first();
		print_r($users);*/
		 $content = $data['main_content'];
				$content = "admin.$content"; ?>
 				@include("{$content}")
	</div>
</div>


@include('admin.includes.footer')



