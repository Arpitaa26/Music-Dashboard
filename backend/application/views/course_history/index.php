            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Course History</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Course History</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Course History</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <form action="<?= base_url('course_history'); ?>" method="GET">
                                                <div class="row">
                                                    <!-- <div class="col-md-2">
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
                                                    </div> -->
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
                                                            <label for="module" class="col-form-label-sm">Module</label>
                                                            <?php $module_error = set_form_error('module_id', false);
                                                            $modules_options = ["" => "Select"];
                                                            if ($modules) {
                                                                $modules_options = array_reduce($modules, function ($s, $d) {
                                                                    return ($s + [$d->id => $d->name]);
                                                                }, $modules_options);
                                                            }
                                                            ?>
                                                            <?= form_dropdown('module_id', $modules_options, set_value('module_id', $module_id), "class='custom-select custom-select-sm {$module_error}' id='module_id'") ?>
                                                            <?= set_form_error('module_id'); ?>
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
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="course_history_table">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Course Name</th>
                                                <th>Course Level</th>
                                                <th>Module Name</th>
                                                <th>Batch Code</th>
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
                <a href="<?= base_url('batch/save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {
                    var course_history_table = $("#course_history_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: '<?= base_url("api/course_history/get_all") ?>',
                            type: 'GET',
                            data: function(d) {
                                d.user_id = $("#user_id").val();
                                d.course_id = $("#course_id").val();
                                d.course_level_id = $("#course_level_id").val();
                                d.status = $("#status").val();
                                d.batch_id = $("#batch_id").val();
                                d.module_id = $("#module_id").val();
                               
                            },
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("batch/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        let course_b = `<a href="<?= base_url("batch_teacher/save/") ?>${v.id}" name="batch_id" class="btn btn-xs btn-success" title="Techers Batch" data-toggle="tooltip">BTeacher</a>`;
                                        var batch_id= `<a href="<?= base_url("user_attendance?batch_id=") ?>${v.id}" name="batch_id" class="btn btn-xs btn-success" title="Teacher Availability" data-toggle="tooltip">BA</a>`;
                                        let complete=`<a href="<?= base_url("course_history/module_complete/") ?>${v.batch_id}/complete" onclick="return confirm('Are you sure Complete ?')" name="batch_id" class="btn btn-xs btn-success" title="Module Complete" data-toggle="tooltip">Complete</a>`;
                                        let action =  del_btn;
                                        const d = new Date(v.start_date);
                                        return [
                                            `<a href="<?= base_url("batch/save/") ?>${v.id}">${v.user_fullname}</a>`,
                                            v.course_name,
                                            v.course_level,
                                            v.module_name,
                                            v.batch_code,
                                            v.status ==0 ? `<span class="badge badge-warning">Process</span>` :(v.status ==-1)? `<span class="badge badge-success">Complete</span>`:`<span class="badge badge-danger">Incomplete</span>`,
                                            v.status !=-1?action+'&nbsp;'+complete:action
                                        ];
                                    });
                                } else if (d.code == 203) {

                                }
                                return [];
                            }
                        },
                    });
                });
            </script>