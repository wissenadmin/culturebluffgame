<link rel="stylesheet" href="{{url('/resources/admin-html')}}/assets/css/sweetalert.css" />
<script src="{{url('/resources/admin-html')}}/assets/js/sweetalert.min.js"></script>

<div class="page-content">
    <div class="row">
      <div class="col-xs-12">
        <h3 class="header smaller lighter blue">License Master Manager</h3>

        <div class="clearfix">
          <div class="pull-right tableTools-container"></div>
        </div>
        <!-- div.dataTables_borderWrap -->
        <div>
        <!-- <?php $success =  Session::get('success');?>
          @if(!empty($success))
          <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {{ $success }}
          </div>
          <script type="text/javascript">
            swal("Success", "The license was updated sucessfully..", "success");
          </script>
          @endif -->

          <?php $success_add =  Session::get('success_add');?>
          @if(!empty($success_add))
            <script type="text/javascript">
            swal("", "License added successfully.", "success");
          </script>
          @endif

          @if(!empty(Session::get('success_update')))
          <script type="text/javascript">
            swal("", "License updated successfully.", "success");
          </script>
          @endif

          <div class="row">
          <div class="col-sm-12">
          <a href="{{url('admin/licences/add')}}">
            <button type="submit" class="btn btn-info">
                Add License    
            </button>
            </a>
          </div>
          </div>
          <div class="space-4"></div>
          
          <table id="simple-table" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="center">SR Number</th>
                <th class="center">License Title</th>
                <th class="center">License Period (Days)</th>
                <th class="center">License Unit Price (GBP)</th>
                <th class="center">Game Title</th>
                
                <th class="center">
                  <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                  Created Date
                </th>
                <th class="hidden-480 center">Status</th>

                <th class="center">Action</th>
              </tr>
            </thead>
            {{$data['licenceData']}}
            <tbody>
            @if(!empty($data['licenceData']))
             @foreach($data['licenceData'] as $key => $value)
              <tr class="rowclass_{{$value->licence_id}}">
                <td class="center">
                  {{$key+1}}
                </td>
                <td class="center">
                @if($value->licence_id != 1 && $value->licence_id != 2 )
                  <a href="{{url('admin/licences/edit',$value->licence_id)}}">{{$value->licence_type}}</a>
                @else
                   {{$value->licence_type}}
                @endif

                </td>

                <td class="center">
                @if($value->licence_id == 2)
                  5 days
                @elseif($value->licence_id == 1)
                  Unlimited
                @else
                {{$value->licence_period }}
                @endif
                </td>
                <td class="center">
                @if($value->licence_id == 2 || $value->licence_id == 1 )
                  No Price 
                @else
                <span class="fa fa-gbp"></span>  {{$value->licence_price}}
                @endif  
                </td>
                <td class="center">{{str_replace(" ","",$value->game_title)}}</td>
                <td class="center">{{changeDateFormat($value->created_at)}}</td>

                @if($value->licence_is_active)
                <td class="hidden-480 center">
                  <span class="statusClass_{{$value->licence_id}} label label-sm label-info arrowed arrowed-righ">Active</span>
                </td>
                @else
                <td class="hidden-480 center">
                  <span class="statusClass_{{$value->licence_id}} label label-sm label-inverse arrowed-in">Inactive</span>
                </td>
                @endif


                <td class="center">
                @if($value->licence_id != 2 && $value->licence_id != 1)
                  <div class="hidden-sm hidden-xs action-buttons">
                    <a class="blue "  >
                        @if($value->licence_is_active)  
                            <i class="ace-icon fa fa-check-square bigger-130 deactiveRecord" data-status="{{$value->licence_is_active}}" data-id="{{$value->licence_id}}" data-url="{{url('admin/licences/status',$value->licence_id)}}"></i>
                        @else
                        
                        <i class="ace-icon fa fa fa-ban bigger-130 deactiveRecord" data-id="{{$value->licence_id}}" data-status="{{$value->licence_is_active}}" data-url="{{url('admin/licences/status',$value->licence_id)}}"></i>
                        @endif
                    </a>

                    <a class="green" href="{{url('admin/licences/edit',$value->licence_id)}}">
                      <i class="ace-icon fa fa-pencil bigger-130"></i>
                    </a>

                    <!-- <a class="red" class="delete"  >
                      <i class="ace-icon fa fa-trash-o bigger-130 delete" data-id="{{$value->licence_id}}" data-url="{{url('admin/licences/delete',$value->licence_id)}}"></i>
                    </a> -->
                  </div>
                  @endif
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
         

        </div>
      </div>
    </div>         
</div>
<script src="{{url('/resources/admin-html')}}/assets/js/jquery.dataTables.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/dataTables.tableTools.min.js"></script>
<script src="{{url('/resources/admin-html')}}/assets/js/dataTables.colVis.min.js"></script>

<script type="text/javascript">
jQuery(function($) {
  //initiate dataTables plugin
  var oTable =   $('#dynamic-table').dataTable();
    $(".delete").click(function(){
        var url = $(this).attr("data-url");
        row_id  = $(this).attr("data-id");
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this License!",
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
                        swal("warning", "dont have permision to actived License.", "error");
                    }
                });
          } else {
                swal("Cancelled", "Your License is safe :)", "error");
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