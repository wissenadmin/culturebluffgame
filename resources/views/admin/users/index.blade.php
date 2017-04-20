<style type="text/css">
  .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    white-space: normal;
  }

  .table-scorle {
    overflow-x: auto;
    overflow-y: hidden;
}
</style>
<link rel="stylesheet" href="{{url('/resources/admin-html')}}/assets/css/sweetalert.css" />
<script src="{{url('/resources/admin-html')}}/assets/js/sweetalert.min.js"></script>
<div class="page-content">
    <div class="row">
      <div class="col-xs-12 table-scorle">
        <h3 class="header smaller lighter blue">Users</h3>

        <div class="clearfix">
          <div class="pull-right tableTools-container"></div>
        </div>
        <!-- div.dataTables_borderWrap -->
        <?php $success_add =  Session::get('success_add');?>
          @if(!empty($success_add))
            <script type="text/javascript">
            swal("", "User added successfully.", "success");
          </script>
          @endif

          @if(!empty(Session::get('success_update')))
          <script type="text/javascript">
            swal("", "User updated successfully.", "success");
          </script>
          @endif


          @if(empty($data['is_user']))
          <div class="row">
          <div class="col-sm-12">
            <a href="{{url('admin/add-super-trial')}}">
              <button type="submit" class="btn btn-info">
                  Add Super Trial     
              </button>
            </a> 
          </div>
          </div>
          @endif
          <div class="space-4"></div>
          <table id="dynamic-table" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="center">
                  SR Number
                </th>
                <th class="center">Name</th>
                <th class="center">Email</th>
                <th class="center">Company</th>
                <th class="center">User Type</th>
                <th class="center">Purchased Via</th>
                <th class="center">License Type</th>
                <th class="center">License Title</th>
                <!-- @if($data['is_child'] == 1)<th class="center">Game Title</th>@endif -->
                <th class="center">
                  <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                  License Start Date
                </th>
                <th class="center">
                  <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                  License End Date
                </th>
                
                <th class="hidden-480">Status</th>

                <th class="center">Action</th>
              </tr>
            </thead>

            
            <tbody>
            @if(!empty($data['userData']))
            
             @foreach($data['userData'] as $key => $value)
              <?php $value = json_decode(json_encode($value),true); // prd($value); ?>
              <tr class="rowclass_{{$value['user_id']}}">
                <td class="center">
                  {{$key+1}}
                </td>
                <td class="center">
                @if($value['user_type'] == 2 && $data['is_user'] != 0)
                  <a href="{{url('admin/users/view',$value['user_id'])}}">{{$value['first_name']}} {{$value['middle_name']}} {{$value['last_name']}}</a>
                @else
                    {{$value['first_name']}} {{$value['middle_name']}} {{$value['last_name']}}
                @endif  

                </td>
                
                <td class="hidden-480 center" >{{$value['email']}}</td>
                <td class="hidden-480 center">{{$value['company_name']}}</td>
                @if(empty($data['viewFlag']))
                  @if($value['user_type'] == 1)
                      <td class="hidden-480 center">Individual </td>
                  @else
                      <td class="hidden-480 center">Corporate</td>
                  @endif
                @else 
                  <td class="hidden-480 center">Corporate Child User</td>
                @endif

                <!-- <td class="center">
                @if($value['purchase_type'] == 1)
                    Web
                @else
                    Manual
                @endif
                </td> -->
                <td class="center"> @if($value['purchase_type'] == 1) Web @elseif($value['purchase_type'] == 2) Manual  @else NA @endif</td>
                <td class="center">@if($value['game_licence'] == 1) SuperTrial @elseif($value['game_licence'] == 2) Trial @else Purchased @endif</td>

                <td class="center">
                    <?php $licencess =  explode(",", $value['licence_type']);
                        //pr($licencess);
                        if(!empty($licencess[1]) || ($value['user_type'] == 2 && $value['is_count'] != 0)  && $value['user_parrent_id'] !=1 ){
                            echo "Multiple";
                        }else{
                            echo ucfirst($value['licence_type']);
                        }
                     ?> 
                </td>

              <!-- @if($data['is_child'] == 1)  <td class="center">
                  
             {{str_replace(",",", ",$value['game_title'])}}   </td> @endif -->


                <td class="center">{{changeDateFormat($value['updated_at'])}}</td>

                <td class="center">
                @if(!empty($licencess[1]) || ($value['user_type'] == 2 && $value['is_count'] != 0))					 {{changeDateFormat($value['licence_valid_till'])}}
                @else

                {{changeDateFormat($value['licence_valid_till'])}}
                @endif
                </td>


                @if($value['user_is_active'] == 1)
                <td class="hidden-480 center">
                  <span class="statusClass_{{$value['user_id']}} label label-sm label-info arrowed arrowed-righ">Active</span>
                </td>
                @else
                <td class="hidden-480 center">
                  <span class="statusClass_{{$value['user_id']}} label label-sm label-inverse arrowed-in">Inactive</span>
                </td>
                @endif


                <td class="center">
                  <div class="hidden-sm hidden-xs action-buttons">
                    <a class="blue "  >
                        @if($value['user_is_active'])  
                            <i class="ace-icon fa fa-check-square bigger-130 deactiveRecord" data-status="{{$value['user_is_active']}}" data-id="{{$value['user_id']}}" data-url="{{url('admin/users/status',$value['user_id'])}}"></i>
                        @else
                        
                        <i class="ace-icon fa fa fa-ban bigger-130 deactiveRecord" data-id="{{$value['user_id']}}" data-status="{{$value['user_is_active']}}" data-url="{{url('admin/users/status',$value['user_id'])}}"></i>
                        @endif
                    </a>

                    <a class="green" href="{{url('admin/users/edit',$value['user_id'])}}">
                      <i class="ace-icon fa fa-pencil bigger-130"></i>
                    </a>

                    <!-- <a class="red" class="delete"  >
                      <i class="ace-icon fa fa-trash-o bigger-130 delete" data-id="{{$value['user_id']}}" data-url="{{url('admin/users/delete',$value['user_id'])}}"></i>
                    </a> -->
                  </div>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
            
          </table>
        </div>
      </div>
      {!! $data['userData']->render() !!}
    </div>

</div>

<script src="{{url('/resources/admin-html')}}/assets/js/jquery.dataTables.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/dataTables.tableTools.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/dataTables.colVis.min.js"></script>


<script type="text/javascript">
jQuery(function($) {
  //initiate dataTables plugin
  //var oTable =   $('#dynamic-table').dataTable();
    $(".delete").click(function(){
        var url = $(this).attr("data-url");
        row_id  = $(this).attr("data-id");
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this User!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel plz!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    success: function(data){
                        swal("Deleted", "Selected data has been deleted.", "success");
                        bResetDisplay = false;
                        oTable.fnDraw();
                        bResetDisplay = true;
                        $(".rowclass_"+row_id).remove();
                    },
                    error: function(){
                        swal("warning", "dont have permision to actived User.", "error");
                    }
                });
          } else {
                swal("Cancelled", "Your User is safe :)", "error");
          }
        });
    });

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
                    swal("", "User activated successfully.", "success");
                }else if(data.newstatus == 0){
                    button.removeClass('fa fa-check-square').addClass('fa fa-ban');
                    button.attr('title','Active');
                    $(".statusClass_"+id).removeClass('label label-sm label-info').addClass('label label-sm label-inverse');
                    $(".statusClass_"+id).html('inactive');
                    swal("", "User deactived successfully.", "success");
                }else{
                  swal("", "Cannot activate license as Parent is still inactive", "error");
                }
            },
            error: function(){
                swal("warning", "dont have permision to change Status of User.", "error");
            }
        });
    });



});
</script>