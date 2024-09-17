            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Teacher's course</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Teacher's course</li>
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
                                    <table class="table text-center" id="course_teacher_table">
                                        <thead>
                                            <tr>
                                                <th>Teacher</th>
                                                <th>Course</th>
                                                <th>Is accepted</th>
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
                <a href="<?= base_url('course_teacher/save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {

                    var course_table = $("#course_teacher_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: '<?= base_url("api/course_teacher/get_all") ?>',
                            type: 'GET',
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("course_teacher/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        return [
                                            `<a href="<?= base_url("course_teacher/save/") ?>${v.id}">${v.user_fullname}</a>`,
                                            v.course_name,
                                            v.is_accepted_for_course == true ? `<span class="badge badge-success"> Yes </span>` : `<span class="badge badge-warning"> No </span>`,
                                            v.status == true ? `<span class="badge badge-success">Active</span>` : `<span class="badge badge-warning">Inactive</span>`,
                                            del_btn
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