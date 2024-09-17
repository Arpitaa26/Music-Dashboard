            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Course Enrollment</h1>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Course Enrollment</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Course Enrollment</h3>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <form action="<?= base_url('course_enrollment'); ?>" method="GET">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="course" class="col-form-label-sm">Course</label>
                                                            <?php
                                                            $courses_options = ["" => "Select"];
                                                            if ($courses) {
                                                                $courses_options = array_reduce($courses, function ($s, $d) {
                                                                    return ($s + [$d->id => $d->name]);
                                                                }, $courses_options);
                                                            }
                                                            ?>
                                                            <?= form_dropdown('course_id', $courses_options, set_value('course_id', $course_id), "class='custom-select custom-select-sm filter_btn' name='course_id' id='course_id'") ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Course Level" class="col-form-label-sm">Course Level</label>
                                                            <?php
                                                            $courses_level_options = ["" => "Select"];
                                                            if ($course_levels) {
                                                                $courses_level_options = array_reduce($course_levels, function ($s, $d) {
                                                                    return ($s + [$d->id => $d->level]);
                                                                }, $courses_level_options);
                                                            }
                                                            ?>
                                                            <?= form_dropdown('course_level_id', $courses_level_options, set_value('course_level_id', $course_level_id), "class='custom-select custom-select-sm filter_btn' name='course_level_id' id='course_level_id'") ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="course_level" class="col-form-label-sm">Users</label>
                                                            <?php
                                                            $users_options = ["" => "Select"];
                                                            if ($users) {
                                                                $users_options = array_reduce($users, function ($s, $d) {
                                                                    return ($s + [$d->id => $d->username]);
                                                                }, $users_options);
                                                            }
                                                            ?>
                                                            <?= form_dropdown('user_id', $users_options, set_value('user_id', $user_id), "class='custom-select custom-select-sm filter_btn' name='user_id' id='user_id'") ?>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="course" class="col-form-label-sm">Batch</label>
                                                    <?php $batch_error = set_form_error('batch_id', false);
                                                    $batches_options = ["" => "Select"];
                                                    if ($batches) {
                                                        $batches_options = array_reduce($batches, function ($s, $d) {
                                                            return ($s + [$d->id => $d->code]);
                                                        }, $batches_options);
                                                    }
                                                    ?>
                                                    <?= form_dropdown('batch_id', $batches_options, set_value('batch_id', $batch_id), "class='custom-select custom-select-sm {$batch_error}' id='batch_id'") ?>
                                                    <?= set_form_error('batch_id'); ?>
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
                                        <div class="col-md-4">
                                            <form action="<?= base_url('course_enrollment'); ?>" method="GET">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group" id="display_hide">
                                                            <label for="status" class="col-form-label-sm">Status</label>
                                                           
                                                            <input type="text" name="status" id="status" value="<?= set_value('status', $status) ?>" class="form-control form-control-sm" placeholder="Course name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label for="course_level" class="col-form-label-sm">&nbsp;</label>
                                                            <button type="submit" class="btn btn-primary btn-sm all" data-id="0">ALL</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="batch_teacher_table">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Course</th>
                                                <th>Course Level</th>
                                                <th>Batch</th>
                                                <th>Enroll Date</th>
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
                <a href="<?= base_url('course_enrollment/save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {

                    var course_table = $("#batch_teacher_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: '<?= base_url("api/course_enrollment/get_all") ?>',
                            type: 'GET',
                            data: function(d) {
                                d.user_id = $("#user_id").val();
                                d.course_id = $("#course_id").val();
                                d.course_level_id = $("#course_level_id").val();
                                d.status = $("#status").val();
                                d.batch_id = $("#batch_id").val();
                               
                            },
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("course_enrollment/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        var scheduled_class= `<a href="<?= base_url("scheduled_class?batch_id=") ?>${v.batch_id}" name="batch_id" class="btn btn-xs btn-success" title="Scheduled Class" data-toggle="tooltip">SC</a>`;
                                        const d = new Date(v.created_on);
                                        var action= scheduled_class +'&nbsp'+del_btn;
                                        return [
                                            `<a href="<?= base_url("course_enrollment/save/") ?>${v.id}">${v.user_fullname}</a>`,
                                            v.course_name,
                                            v.level,
                                            v.batch_code,
                                            `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`,
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

                    $("#display_hide").hide() //enrollment status active by default hidden filter

                    $(".all").click(function(){
                        var status=$(this).data("id");
                    
                        $('#status').val(<?= set_value('status',0) ?>);
                       
                    });
                   
                });
            </script>