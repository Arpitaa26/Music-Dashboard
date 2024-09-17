            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>User</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">User</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; User</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <form action="<?= base_url('user'); ?>" method="GET">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="user_type" class="col-form-label-sm">User Type</label>
                                                        <?php
                                                        $user_type = ["" => "Select"];
                                                        if ($user_types) {
                                                            $user_type = array_reduce($user_types, function ($s, $d) {
                                                                return ($s + [$d->id => $d->type]);
                                                            }, $user_type);
                                                        }
                                                        ?>
                                                        <?= form_dropdown('user_type_id', $user_type, set_value('user_type_id', $user_type_id), "class='custom-select custom-select-sm filter_btn' name='user_type_id' id='user_type_id'") ?>
                                                    </div>
                                                </div>


                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="course_level" class="col-form-label-sm">&nbsp;</label>
                                                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="user_table">
                                        <thead>
                                            <tr>
                                                <th>Fullname</th>
                                                <th>User Type</th>
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
                <a href="<?= base_url('user/save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
                <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="userModalLabel">Other Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- <form id="task">
                                    <div class="form-group">
                                        <h4 class="title"></h4>
                                        <p class="assign"></p>
                                        <p class="desc"></p>


                                       
                                    </div>
                                    <div class="form-group">
                                       
                                        <input type="text" value="" name="task_title" id="task_title" class="form-control" id="status">
                                        <input type="text" value="" name="user_id" id="user_id" class="form-control" id="status">
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                    </div>
                                </form> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal">Close</button>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {

                    var course_table = $("#user_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: '<?= base_url("api/user/get_all") ?>',
                            type: 'GET',
                            data: function(d) {
                                d.user_type_id = $("#user_type_id").val();
                            },
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("user/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        var course_enrollment = `<a href="<?= base_url("course_enrollment") ?>?user_id=${v.id}" name="user_id" class="btn btn-xs btn-success" title="Course Enrollment" data-toggle="tooltip">CE</a>`;
                                        var extra = `<a href="" name="" class="btn btn-xs btn-primary" title="" data-toggle="tooltip"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a>`;
                                       // var availability= `<a href="<?= base_url("user_availability/save/") ?>${v.id}" name="user_id" class="btn btn-xs btn-success" title="Teacher Availability" data-toggle="tooltip">TA</a>`;
                                        var availability_t= `<a href="<?= base_url("user_availability/availability/") ?>${v.id}" name="user_id" class="btn btn-xs btn-success" title="Teacher Availability" data-toggle="tooltip">TA</a>`;
                                        var audio_archive= `<a href="<?= base_url("file?category=AUDIO_ARCHIVE") ?>" name="category" class="btn btn-xs btn-success" title="AUDIO ARCHIVE" data-toggle="tooltip">AA</a>`;
                                        var attendance= `<a href="<?= base_url("user_attendance?") ?>user_id=${v.id}" name="user_id" class="btn btn-xs btn-success" title="Attendance" data-toggle="tooltip">A</a>`;
                                        var course_b = `<a href="<?= base_url("course_teacher/save/") ?>${v.id}" name="course_id" class="btn btn-xs btn-primary" title="Course" data-toggle="tooltip">TC</a>`;
                                        var task_b = `<a href="<?= base_url("task") ?>?user_id=${v.id}" name="user_id" class="btn btn-xs btn-primary" title="Task" data-toggle="tooltip">T</a>`;
                                        var reschedule_request= `<a href="<?= base_url("class_reschedule_request?") ?>user_id=${v.id}" name="user_id" class="btn btn-xs btn-success" title="Rescheduled Request" data-toggle="tooltip">CRR</a>`;
                                        //var all_course_b = `<a href="<?= base_url("course_enrollment") ?>?user_id=${v.id}" name="user_id" class="btn btn-xs btn-primary" title="ALL Course" data-toggle="tooltip"><i class="fa fa-flag" aria-hidden="true"></i></a>`;
                                        let modal = `&nbsp<div type="submit" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#userModal" data-id="${v.id}" data-whatever="${v.id}"><i class="fa fa-eye"></i> </div> `;
                                        // let action = course_enrollment + '||' + course_b + '||' + del_btn;
                                        var course_history= `<a href="<?= base_url("course_history?") ?>user_id=${v.id}" name="user_id" class="btn btn-xs btn-success" title="Course History" data-toggle="tooltip">CH</a>`;
                                        
                                       if(v.user_type_id==4){
                                        var action = course_b +'&nbsp'+modal+'&nbsp'+ '&nbsp'+attendance+'&nbsp' +reschedule_request+ '&nbsp'+availability_t+'&nbsp'+ del_btn;
                                       }
                                      else if(v.user_type_id==5){
                                        var action = course_enrollment + '&nbsp'+audio_archive +'&nbsp'+course_history+ '&nbsp'+task_b+'&nbsp' +reschedule_request+'&nbsp'+attendance+'&nbsp'+ del_btn;
                                       }else{
                                        var action =extra+ '&nbsp'+ del_btn;
                                       }
                                      
                                        return [
                                            `<a href="<?= base_url("user/save/") ?>${v.id}">${v.full_name}</a>`,
                                            v.type,
                                            v.status == "active" ? `<span class="badge badge-success">Active</span>` : `<span class="badge badge-warning">${v.status}</span>`,
                                            action
                                        ];
                                    });
                                } else if (d.code == 203) {

                                }
                                return [];
                            }
                        },
                    });

                    $('#userModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var user_id = button.data('whatever')
                    var id = button.data('id')
                    var modal = $(this)
                    $.ajax({
                        url: '<?= base_url("api/user/get/") ?>'+ id,
                        type: 'get',
                        data: {
                            user_id:user_id,
                            id: id
                        },
                        success: function(response) {
                        // alert(JSON.stringify(response));
                         //alert(response.data.other_details.file_id);
                            $('.modal-body').html('<h5>'+response.data.full_name + '</h5><br/>  <div class="alert direct-chat-primary" role="alert">' +response.data.full_name + '</div><br/>' + response.data.full_name);
                            $('#userModal').modal('show');
                        }
                    });

                  
 
                    // modal.find('.modal-title').text('New Task' + recipient)
                    // modal.find('.modal-body input').val(recipient)

                })


                });
            </script>