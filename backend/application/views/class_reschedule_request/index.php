            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Class Rescheduled Request</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Class Rescheduled Request</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Class Rescheduled Request</h3>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <form action="<?= base_url('class_reschedule_request'); ?>" method="GET">
                                                <div class="row">
                                                    
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
                                                            <label for="course_level" class="col-form-label-sm">&nbsp;</label>
                                                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                                        </div>
                                                    </div>

                                                </div>

                                            </form>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="class_reschedule_request">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Type</th>
                                                <th>Date</th>
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
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {
                    var course_table = $("#class_reschedule_request").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: '<?= base_url("api/class_reschedule_request/get_all") ?>',
                            type: 'GET',
                            data: function(d) {
                                d.user_id = $("#user_id").val();
                               
                            },
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("class_reschedule_request/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        let approved_btn = true ? `<a href="<?= base_url("class_reschedule_request/approved_status/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-success" title="Approved" data-toggle="tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>` : '';
                                        let Reject_btn = true ? `<a href="<?= base_url("class_reschedule_request/approved_status/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Rejected" data-toggle="tooltip"><i class="fa fa-ban" aria-hidden="true"></i></a>` : '';
                                        let class_status=approved_btn+'&nbsp'+Reject_btn;
                                        return [
                                            `<a href="#">${v.user_fullname}</a>`,
                                            v.user_type,
                                            v.rescheduled_date,
                                            v.status == 0 ? `<span class="badge badge-success">Pending</span>`:v.status == 1 ?  `<span class="badge badge-warning">Approved</span>`: `<span class="badge badge-warning">Rejected</span>`,
                                            del_btn+'&nbsp'+class_status
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