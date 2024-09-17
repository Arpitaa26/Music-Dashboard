            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Country</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Country</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp;Country</h3>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="country_table">
                                        <thead>
                                            <tr>
                                                <th>Country Code</th>
                                                <th>Country</th>
                                                <th>Currency</th>
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
                <a href="<?= base_url('country/save') ?>" class="btn btn-danger pop_fix_btn" title="New Country"><i class="fa fa-plus"></i></a>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {

                    var country_table = $("#country_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: '<?= base_url("api/country/get_country") ?>',
                            type: 'GET',
                           
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("country/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        let action = del_btn;
                                        return [
                                            `<a href="<?= base_url("country/save/") ?>${v.id}">${v.country_code}</a>`,
                                            v.country_name,
                                            v.course_currency,
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
                    course_table.buttons().container().appendTo('#course_table_wrapper .col-md-6:eq(0)');

                  
                });
            </script>