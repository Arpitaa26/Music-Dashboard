            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Attendance</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Attendance</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Attendance</h3>
                                </div>
                                <div class="col-md-12">

                                    <form action="<?= base_url('user_attendance'); ?>" method="GET">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="course" class="col-form-label-sm">From</label>
                                                    <input type="date" name="from" id="from" value="<?= set_value('from', $from) ?>" class="form-control form-control-sm ">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="course_level" class="col-form-label-sm">To</label>
                                                    <input type="date" name="to" id="to" value="<?= set_value('to', $to) ?>" class="form-control form-control-sm ">
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
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label for="course_level" class="col-form-label-sm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                                </div>
                                            </div>

                                        </div>

                                    </form>

                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="attendance_table">
                                        <thead>
                                            <tr>
                                                <th>Batch Code</th>
                                                <th>Student Number</th>
                                                <th>Start Class</th>
                                                <th>End Class</th>
                                                <th>Left Class</th>
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
                    var from = $("#from").val();
                    var to = $("#to").val();
                    var attendance_table = $("#attendance_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: `<?= base_url("api/user/attendance/get_all?from=") ?>${from}&to=${to}`,
                            type: 'GET',
                            data: function(d) {
                                d.batch_id = $("#batch_id").val();
                                d.user_id = $("#user_id").val();
                            },
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("user_attendance/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        // let course_b = `<a href="<?= base_url("user_attendance/create/") ?>${v.class_id}" name="batch_id" class="btn btn-xs btn-success" title="Techers Batch" data-toggle="tooltip">BTeacher</a>`;
                                        let action = del_btn;
                                        const d = new Date(v.left_on);
                                        return [
                                            v.batch_code,
                                            v.user_full_name,
                                            v.class_start_time,
                                            v.class_end_time,
                                            `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`,
                                            v.status == 'ATTENDED' ? `<span class="badge badge-success">ATTENDED</span>` : `<span class="badge badge-warning">ABSENTS</span>`,
                                            action
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