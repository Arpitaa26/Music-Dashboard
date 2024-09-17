            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Teacher's Batches</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Teacher's Batches</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Teacher's Batches</h3>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="batch_teacher_table">
                                        <thead>
                                            <tr>
                                                <th>Teacher</th>
                                                <th>Batch</th>
                                                <th>Module</th>
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
                <a href="<?= base_url('batch_teacher/save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
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
                            url: '<?= base_url("api/batch_teacher/get_all") ?>',
                            type: 'GET',
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("batch_teacher/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        let course_b = `<a href="<?= base_url("course_teacher/save/") ?>${v.user_id}" name="course_id" class="btn btn-xs btn-success" title="Course" data-toggle="tooltip"><i class="fa fa-external-link-alt"></i></a>`;

                                        let action = course_b + '&nbsp' + del_btn;
                                        return [
                                            `<a href="<?= base_url("batch_teacher/save/") ?>${v.id}">${v.user_fullname}</a>`,
                                            v.batch_code,
                                            v.module_name,
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
                });
            </script>