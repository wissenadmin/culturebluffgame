<link rel="stylesheet" href="{{url('/resources/admin-html')}}/assets/css/sweetalert.css" />
<script src="{{url('/resources/admin-html')}}/assets/js/sweetalert.min.js"></script>

<div class="page-content">
    <div class="row">
      <div class="col-xs-12">
        <h3 class="header smaller lighter blue">{{$data['page_title']}} Manager</h3>

        <div class="clearfix">
          <div class="pull-right tableTools-container"></div>
        </div>
        <!-- div.dataTables_borderWrap -->
        <div>
        <?php $success_add =  Session::get('success_add');?>
          @if(!empty($success_add))
            <script type="text/javascript">
            swal("", "Static page added successfully.", "success");
          </script>
          @endif

          @if(!empty(Session::get('success_update')))
          <script type="text/javascript">
            swal("", "Static page updated successfully.", "success");
          </script>
          @endif

          <div class="row">
          <div class="col-sm-12">
          <a href="{{url('admin/static-page/add')}}">
            <button type="submit" class="btn btn-info">
                Add Page    
            </button>
            </a>
          </div>
          </div>
          <div class="space-4"></div>
          
          <table id="simple-table" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="center">SR Number</th>
                <th class="center">Page Title</th>
                <th class="center">Page Slug</th>
                <th class="center">
                  <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                  Created Date
                </th>
                <th class="hidden-480">Status</th>

                <th class="center">Action</th>
              </tr>
            </thead>

            <tbody>
            @if(!empty($data['static_pages']))
             @foreach($data['static_pages'] as $key => $value)
              <tr class="rowclass_{{$value->page_id}}">
                <td class="center">
                  {{$key+1}}
                </td>
                <td class="center">
                  <a href="{{url('admin/static-page/edit',$value->page_id)}}">{{$value->page_title}}</a>
                </td>
                
                <td class="hidden-480">{{$value->page_slug}}</td>
                <td class="center">{{changeDateFormat($value->created_at)}}</td>

                @if($value->page_is_active)
                <td class="hidden-480 center">
                  <span class="statusClass_{{$value->page_id}} label label-sm label-info arrowed arrowed-righ">Active</span>
                </td>
                @else
                <td class="hidden-480 center">
                  <span class="statusClass_{{$value->page_id}} label label-sm label-inverse arrowed-in">Inactive</span>
                </td>
                @endif


                <td class="center">
                  <div class="hidden-sm hidden-xs action-buttons">
                    <a class="blue "  >
                        @if($value->page_is_active)  
                            <i class="ace-icon fa fa-check-square bigger-130 deactiveRecord" data-status="{{$value->page_is_active}}" data-id="{{$value->page_id}}" data-url="{{url('admin/static-page/status',$value->page_id)}}"></i>
                        @else
                        
                        <i class="ace-icon fa fa fa-ban bigger-130 deactiveRecord" data-id="{{$value->page_id}}" data-status="{{$value->page_is_active}}" data-url="{{url('admin/static-page/status',$value->page_id)}}"></i>
                        @endif
                    </a>

                    <a class="green" href="{{url('admin/static-page/edit',$value->page_id)}}">
                      <i class="ace-icon fa fa-pencil bigger-130"></i>
                    </a>

                    <!-- <a class="red" class="delete"  >
                      <i class="ace-icon fa fa-trash-o bigger-130 delete" data-id="{{$value->page_id}}" data-url="{{url('admin/static-page/delete',$value->page_id)}}"></i>
                    </a> -->
                  </div>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
          <div class="pull-right pagination">
          <?php $pages = $data['static_pages'];  ?>
          {!! str_replace('/?', '?', $pages->render()) !!}
          </div>

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
          text: "You will not be able to recover this Page!",
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
                        swal("warning", "dont have permision to actived Page.", "error");
                    }
                });
          } else {
                swal("Cancelled", "Your Page is safe :)", "error");
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
                    swal("", "Static page activated successfully", "success");
                }else{
                    button.removeClass('fa fa-check-square').addClass('fa fa-ban');
                    button.attr('title','Active');
                    $(".statusClass_"+id).removeClass('label label-sm label-info').addClass('label label-sm label-inverse');
                    $(".statusClass_"+id).html('inactive');
                    swal("", "Static page deactived successfully", "success");
                }
            },
            error: function(){
                swal("warning", "dont have permision to change Status of Page.", "error");
            }
        });
    });



});
</script>