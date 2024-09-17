            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Course</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Course</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Courses</h3>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="course_table">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <!-- <th>Price</th> -->
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
                <a href="<?= base_url('course/save') ?>" class="btn btn-danger pop_fix_btn" title="New Course"><i class="fa fa-plus"></i></a>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {

                    // $("#example1").DataTable({
                    //     "responsive": true,
                    //     "lengthChange": false,
                    //     "autoWidth": false,
                    //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                    // $('#example2').DataTable({
                    //     "paging": true,
                    //     "lengthChange": false,
                    //     "searching": false,
                    //     "ordering": true,
                    //     "info": true,
                    //     "autoWidth": false,
                    //     "responsive": true,
                    // });

                    var course_table = $("#course_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: '<?= base_url("api/course/get_all") ?>',
                            type: 'GET',
                            data: function(d) {
                                d.course_id = $("#course_id").val();
                            },
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("course/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        let module_b = `<a href="<?= base_url("module") ?>?course_id=${v.id}" name="course_id" class="btn btn-xs btn-primary" title="Module" data-toggle="tooltip">Module</a>`;
                                        let pricing_b = `<a href="<?= base_url("price") ?>?course_id=${v.id}" name="course_id" class="btn btn-xs btn-primary" title="Pricing" data-toggle="tooltip">Pricing</a>`;
                                        let question_b = `<a href="<?= base_url("question") ?>?course_id=${v.id}" name="course_id" class="btn btn-xs btn-success" title="Question" data-toggle="tooltip">Question</a>`;

                                        let action = module_b + '&nbsp' + question_b + '&nbsp' + pricing_b + '&nbsp' + del_btn;
                                        return [
                                            v.code,
                                            `<a href="<?= base_url("course/save/") ?>${v.id}">${v.name}</a>`,
                                            v.role,
                                           // v.price,
                                            v.status == true ? `<span class="badge badge-success">Active</span>` : `<span class="badge badge-warning">Inactive</span>`,
                                            action
                                        ];
                                    });
                                } else if (d.code == 203) {
                                    // page_redirect(d.response);
                                }
                                return [];
                            }
                        },
                        // "initComplete": function(settings, json) {
                        //     // alert('DataTables has finished its initialisation.');
                        // }
                    });
                    course_table.buttons().container().appendTo('#course_table_wrapper .col-md-6:eq(0)');

                    // course_table.buttons().container().appendTo($('.col-sm-6:eq(0)', course_table.table().container()));


                    // new $.fn.dataTable.Buttons(course_table, {
                    //     buttons: [
                    //         'copy', 'excel', 'pdf'
                    //     ]
                    // });

                    // course_table.buttons().container()
                    //     .appendTo($('.col-sm-6:eq(0)', course_table.table().container()));
                });
            </script>