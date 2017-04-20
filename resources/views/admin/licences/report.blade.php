<link rel="stylesheet" href="{{url('/resources/admin-html')}}/assets/css/sweetalert.css" />

<div class="page-content">
    <div class="row">
      <div class="col-xs-12">
        <h3 class="header smaller lighter blue">{{$data['page_title']}} Manager</h3>

        <div class="clearfix">
          <div class="pull-right tableTools-container"></div>
        </div>
        <!-- div.dataTables_borderWrap -->
        <div>
        <?php $success =  Session::get('success');?>
          @if(!empty($success))
          <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {{ $success }}
          </div>
          @endif
          <div class="row">
          <div class="col-sm-12">
          <a href="{{url('admin/licences/manual-generation')}}">
            <button type="submit" class="btn btn-info">
                Generate Manual License    
            </button>
            </a>
          </div>
          </div>
          <div class="space-4"></div>
          
          <table id="simple-table" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                 <th class="center">License Title</th> 
                <th class="center">Username</th>
                <th class="center">User Type</th>
                
                <th class="center">License Type</th>
                <th class="center">Purchased Via</th>
                <th class="center"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>License Start  Date</th>
                <th class="text-center center">
                  License Duration
                </th>
                <th class="hidden-480 text-center center">Status</th>
                <th class="center">Action</th>
              </tr>
            </thead>
            <?php $multipleFlag = 0; ?>
            @foreach($data['licenceData'] as $key => $value)
                <tr>
                    <td class="center">
                    <?php $licencess =  explode(",", $value->licence_type);
                        
                        //pr($licencess);
                       // if(!empty($licencess[1]) && $value->user_type == 2){
                    if(!empty($licencess[1])  || ($value->user_type == 2 && $value->is_count != 0) && $value->user_parrent_id !=1){

                            $multipleFlag = 1;
                            echo "Multiple";
                        }else{
                            $multipleFlag = 0;
                            echo str_replace(",",", ",ucfirst($value->licence_type)); //ucfirst($value->licence_type);
                        }
                     ?> 
                    <!-- {{ str_replace(",",", ",ucfirst($value->licence_type)) }} --></td>
                    <td class="center">
                      <a href="{{url('/admin/users/edit',$value->user_id)}}" class="blue" title="View Info">
                    {{$value->user_username}}
                    </a>
                    </td>
                    <td class="center">@if($value->user_type == 1 && $value->user_parrent_id == 0 ) Individual @else Corporate @endif</td>
                    
                    <td class="center">  @if($value->game_licence == 1) SuperTrial @elseif($value->game_licence == 2 && $multipleFlag != 1) Trial @elseif($value->user_type != 1 || $multipleFlag == 1 ) <a href="{{url('admin/licences-view',$value->user_id)}}" > Purchased </a> @else Purchased @endif</td>



                    <td class="center">@if($value->purchase_type == 1) Web @elseif($value->purchase_type == 2) Manual  @else NA @endif</td>
                    <td class="center"></i>{{changeDateFormat($value->created_at)}}</td>
                    <td class="text-center">
                        <?php //if(!empty($licencess[1]) && $value->user_type == 2)  ?>
                        @if(!empty($licencess[1]) || ($value->user_type == 2 && $value->is_count != 0) )
                           
                        @else
                        @if($value->game_licence == 1  ) @elseif($value->game_licence == 2) 5 Days @elseif(!empty($value->licence_period)) {{$value->licence_period}} days @endif  
                        @endif 
                    </td>

                    <!-- <td class="hidden-480 text-center">@if($value->user_is_active == 1) <i  class="ace-icon fa fa-check-square bigger-130 "></i> @else  <i  class="ace-icon fa fa-ban bigger-130 "></i> @endif </td> -->

                    @if($value->user_is_active == 1)
                        <td class="hidden-480 center">
                          <span class="statusClass_{{$value->user_id}} label label-sm label-info arrowed arrowed-righ">Active</span>
                        </td>
                        @else
                        <td class="hidden-480 center">
                          <span class="statusClass_{{$value->user_id}} label label-sm label-inverse arrowed-in">Inactive</span>
                        </td>
                    @endif


                    <td class="center">
                        <div class="hidden-sm hidden-xs action-buttons">
                        

                        <a class="blue" title="change-status">
                        @if($value->user_is_active)  
                            <i data-url="{{url()}}/admin/users/status/{{$value->user_id}}" data-id="{{$value->user_id}}" data-status="1" class="ace-icon fa fa-check-square bigger-130 deactiveRecord"></i>
                        @else
                        <i data-url="{{url()}}/admin/users/status/{{$value->user_id}}" data-id="{{$value->user_id}}" data-status="1" class="ace-icon fa fa-ban bigger-130 deactiveRecord"></i>

                        @endif

                         </a>


                        <a href="{{url('/admin/users/edit',$value->user_id)}}" class="green" title="change-password">
                          <i class="ace-icon fa fa-pencil bigger-130"></i>
                        </a>
                      </div>
                  </td>
                </tr>
            @endforeach    

            <tbody>
            
            </tbody>
          </table>
         

        </div>
      </div>
      {!! $data['licenceData']->render() !!}
    </div>         
</div>
<script src="{{url('/resources/admin-html')}}/assets/js/jquery.dataTables.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/dataTables.tableTools.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/dataTables.colVis.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/sweetalert.min.js"></script>

<script type="text/javascript">
jQuery(function($) {
  //initiate dataTables plugin
  var oTable =   $('#dynamic-table').dataTable();
   

    $(".deactiveRecord").click(function(){
        var url = $(this).attr("data-url");    
        var status = jQuery(this).attr('status');
        var button=jQuery(this);
        var id = $(this).attr("data-id");
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function(data){
               if(data.newstatus == 1){
                    button.removeClass('fa fa-ban').addClass('fa fa-check-square');
                    button.attr('title','Inactive');
                    $(".statusClass_"+id).removeClass('label label-sm label-inverse').addClass('label label-sm label-info');
                    $(".statusClass_"+id).html('Active');
                    swal("", "License  activated successfully.", "success");
                }else{
                    button.removeClass('fa fa-check-square').addClass('fa fa-ban');
                    button.attr('title','Active');
                    $(".statusClass_"+id).removeClass('label label-sm label-info').addClass('label label-sm label-inverse');
                    $(".statusClass_"+id).html('Inactive');
                    swal("", "License  deactivated successfully.", "success");
                }
            },
            error: function(){
                swal("warning", "dont have permision to change Status of License .", "error");
            }
        });
    });



});
</script>