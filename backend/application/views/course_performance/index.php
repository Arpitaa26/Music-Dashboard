<style>
    .modal-header,
    h4,
    .close {
        background-color: #3f6791;
        color: white !important;
        text-align: center;
        font-size: 30px;
    }

    .modal-footer {
        background-color: #3f6791;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Course Performance</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active">Course Performance</li>
                </ol>

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Course Performance</h3>
                    </div>
                    <div class="card-body table-responsive p-2">
                        <table class="table text-center" id="batch_teacher_table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Batch</th>
                                    <th>Result Type</th>
                                    <th>Marks</th>
                                    <th>Course</th>
                                    <th>Course Level</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!-- Trigger the modal with a button -->

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="course_preview_modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Module" class="col-form-label-sm">Teacher</label>
                                    <input type="hidden" name="performance_id" id="performance_id" value="" class="form-control form-control-sm" placeholder="performance_id">
                                    <input type="text" name="user_id" id="user_id" value="" class="form-control form-control-sm" placeholder="user_id">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Module" class="col-form-label-sm">Module</label>

                                    <input type="text" name="module_id" id="module_id" value="" class="form-control form-control-sm" placeholder="module_id">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Module" class="col-form-label-sm">Batch</label>

                                    <input type="text" name="batch_id" id="batch_id" value="" class="form-control form-control-sm" placeholder="batch_id">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Module" class="col-form-label-sm">Result Type</label>

                                    <input type="text" name="result_type" id="result_type" value="" class="form-control form-control-sm" placeholder="result_type">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Module" class="col-form-label-sm">Marks</label>

                                    <input type="text" name="marks" id="marks" value="" class="form-control form-control-sm" placeholder="marks">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Module" class="col-form-label-sm">Status</label>

                                    <input type="text" name="status" id="status" value="" class="form-control form-control-sm" placeholder="status">

                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block"></span> save</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>

                </div>
            </div>

        </div>
    </div>
    </div>


    <a href="<?= base_url('course_performance/save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
</section>


<!-- /.content -->
<!-- Modal -->
<div id="courses_preview_modal" class="modal fade" role="dialog">
      <div class="modal-dialog modalwrapwidth modal-lg">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" onclick="stopvideo()">&times;</button>
            <div class="scroll-area">
              <div class="modal-body paddbtop">
                  <div class="row">
                    <div id="course_preview">

                    </div>
                  </div><!--./row-->
              </div><!--./modal-body-->
          </div>
        </div>
      </div>
    </div><!--#/coursedetailmodal-->
<!-- Button trigger modal -->

<script>
    $(document).ready(function() {

        var course_table = $("#batch_teacher_table").DataTable({
            responsive: true,
            autoWidth: false,
            serverSide: false,
            processing: true,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            ajax: {
                url: '<?= base_url("api/course_performance/get_all") ?>',
                type: 'GET',
                dataSrc: function(d) {
                    if (d.code == 200) {
                        return d.data.map((v, i) => {
                            let del_btn = true ? `<a href="<?= base_url("course_performance/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                            let course_b = `<a href="<?= base_url("course_performance/save/") ?>${v.id}" name="course_id" class="btn btn-xs btn-success" title="Add Result" data-toggle="tooltip"><i class="fa fa-plus"></i></a>`;
                            let course_d=` <a href="#" class="btn btn-primary btn-xs course_preview pull-right" data-id="53" data-backdrop="static"
                                              data-keyboard="false" data-toggle="modal" data-target="#courses_preview_modal"><i class="fa fa-plus"></i></a>`;
                                
                            let p_result = ` <a href="#" class="btn btn-primary btn-xs course_preview_id pull-right" data-id="${v.id}" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#course_preview_modal" data-original-title="" title=""><i class="fa fa-plus"></i></a>`;
                            let action = course_b +'&nbsp' + del_btn;
                            return [
                                `<a href="<?= base_url("course_performance/save/") ?>${v.id}">${v.user_fullname}</a>`,
                                v.batch_code,
                                v.result_type,
                                v.marks,
                                v.course_name,
                                v.level,
                                v.status == true ? `<span class="badge badge-success">Active</span>` : `<span class="badge badge-warning">Inactive</span>`,
                                action
                            ];
                        });
                    } else if (d.code == 203) {

                    }
                    return [];
                }
            },
        });



        $(document).on("click", ".course_preview_id", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                url: '<?php echo base_url() ?>course_performance/get/' + id,//batch_teacher
                method: 'get',
                data: {
                    id: id
                },
                dataType: "json",
                beforeSend: function() { //We add this before send to disable the button once we submit it so that we prevent the multiple click

                },
                success: function(data) {
                    // data = JSON.parse(response);
                    alert(data.data.id);
                    console.log(data);
                    $("input[name='batch_id']").val(data.data.id);
                    $("input[name='module_id']").val(data.data.course_id);
                    $("input[name='user_id']").val(data.data.course_id);
                    $("input[name='result_type']").val(data.data.course_id);
                    $("input[name='marks']").val(data.data.course_id);
                }
            });
        });
        $(document).on("click", ".course_preview_id", function() {
            var id = $(this).attr("data-id");

            $.ajax({
                url: '<?php echo base_url() ?>course_performance/save/' + id,
                method: 'post',
                data: {
                    id: id
                },
                dataType: "json",
                beforeSend: function() { //We add this before send to disable the button once we submit it so that we prevent the multiple click

                },
                success: function(data) {
                    console.log(data);
                    $("input[name='batch_id']").val(data.data.id);
                    $("input[name='module_id']").val(data.data.course_id);
                    $("input[name='user_id']").val(data.data.course_id);
                    $("input[name='result_type']").val(data.data.course_id);
                    $("input[name='marks']").val(data.data.course_id);
                }
            });
        });

    });
</script>
<script>
(function ($) {
 "use strict";

 $('.course_preview').click(function(){
    var courseID = $(this).attr('data-id');
   
	$('#course_preview').html('kkk');
    $.ajax({
     url  : "",
     type : 'post',
     data : {courseID:courseID},
     beforeSend: function () {
      $('#course_preview').html('Loading...  <i class="fa fa-spinner fa-spin"></i>');
     },

     success : function(response){

        var html=``;
       $('#course_preview').html(response);
     }
    });
  })
  
 } ( jQuery ) );
 </script>