            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Batches</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Batches</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Batches</h3>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="batch_table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Batch Code</th>
                                                <th>Course Name</th>
                                                <th>Course Level</th>
                                                <th>Student Number</th>
                                                <th>Start Date</th>
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
                    get_batch();

                    function get_batch() {

                        if ($.fn.dataTable.isDataTable('#batch_table')) {
                            batch_table.destroy();
                        }
                        var batch_table = $("#batch_table").DataTable({
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
                                url: '<?= base_url("api/batch/get_all") ?>',
                                type: 'GET',
                                dataSrc: function(d) {
                                    if (d.code == 200) {
                                        return d.data.map((v, i) => {
                                            let del_btn = true ? `<a href="<?= base_url("batch/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                            let course_b = `<a href="<?= base_url("batch_teacher/save/") ?>${v.id}" name="batch_id" class="btn btn-xs btn-success" title="Techers Batch" data-toggle="tooltip">BTeacher</a>`;
                                            var batch_a = `<a href="<?= base_url("user_attendance?batch_id=") ?>${v.id}" name="batch_id" class="btn btn-xs btn-success" title="Teacher Availability" data-toggle="tooltip">BA</a>`;
                                            var batch_s = `<a href="<?= base_url("course_enrollment?batch_id=") ?>${v.id}" name="batch_id" class="btn btn-xs btn-success" title="Batch Student" data-toggle="tooltip">BS</a>`;
                                            let sort = `<span class="handle badge"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>`;

                                            let action = course_b + '&nbsp' + batch_a + '&nbsp' + batch_s + '&nbsp' + del_btn;
                                            const d = new Date(v.start_date);
                                            return [
                                                v.order,
                                                v.id,
                                                sort,
                                                `<a href="<?= base_url("batch/save/") ?>${v.id}">${v.code}</a>`,
                                                v.course_name,
                                                v.level,
                                                v.no_of_students_allowed,
                                                `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`,
                                                v.status == true ? `<span class="badge badge-success">Incomplete</span>` : `<span class="badge badge-warning">Complete</span>`,
                                                action
                                            ];
                                        });
                                    } else if (d.code == 203) {

                                    }
                                    return [];
                                }
                            },
                        });

                        //data table reorder
                        batch_table.on('row-reordered', function(e, diff, edit) {

                            updatedtorder(batch_table, diff, "<?php echo base_url('api/batch/updateOrder'); ?>")
                        });

                        //
                    }
                });
            </script>
            