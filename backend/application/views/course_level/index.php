            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Course Level</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Course Level</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp;Course Levels</h3>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="course_level_table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>level</th>
                                                <th>Description</th>
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
                <a href="<?= base_url('course_level/save') ?>" class="btn btn-danger pop_fix_btn" title="New Course Level"><i class="fa fa-plus"></i></a>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {
                    get_course_level();
                    function get_course_level() {

                        if ($.fn.dataTable.isDataTable('#course_level_table')) {
                            course_level_table.destroy();
                        }
                        var course_level_table = $("#course_level_table").DataTable({
                            responsive: true,
                            rowReorder: {
                                selector: 'tr'
                            },
                            columnDefs: [{
                                targets: 0,
                                visible: false
                            }, {
                                targets: 1,
                                visible: false
                            }],
                            autoWidth: false,
                            serverSide: false,
                            processing: true,
                            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                            ajax: {
                                url: '<?= base_url("api/course_level/get_all") ?>',
                                type: 'GET',
                                data: function(d) {
                                    d.course_id = $("#course_level_id").val();
                                },
                                dataSrc: function(d) {
                                    if (d.code == 200) {
                                        return d.data.map((v, i) => {
                                            let del_btn = true ? `<a href="<?= base_url("course_level/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                            let sort = `<span class="handle badge"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>`;

                                            let action = del_btn;
                                            return [
                                                v.order,
                                                v.id,
                                                sort,
                                                `<a href="<?= base_url("course_level/save/") ?>${v.id}">${v.level}</a>`,
                                                v.description,
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
                        course_level_table.buttons().container().appendTo('#course_table_wrapper .col-md-6:eq(0)');
                       
                        //data table reorder
                        course_level_table.on('row-reordered', function(e, diff, edit) {

                            updatedtorder(course_level_table, diff, "<?php echo base_url('api/course_level/updateOrder'); ?>")
                        });

                        //
                    }
                });
            </script>