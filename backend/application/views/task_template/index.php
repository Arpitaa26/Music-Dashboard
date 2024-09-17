            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Task Template</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Task Template</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp;Tasks Template</h3>
                                </div>
                              
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="task_template_table">
                                        <thead>
                                            <tr>
                                                <th>Titele</th>
                                                <th>Delta Time</th>
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
                <a href="<?= base_url('task_template/save') ?>" class="btn btn-danger pop_fix_btn" title="New Task"><i class="fa fa-plus"></i></a>
                <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="taskModalLabel">New Task</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="task">
                                    <div class="form-group">
                                        <h4 class="title"></h4>
                                        <p class="assign"></p>
                                        <p class="desc"></p>


                                        <!-- <label for="recipient-name" class="col-form-label">Recipient:</label> -->
                                       
                                    </div>
                                    <div class="form-group">
                                       
                                        <input type="text" value="" name="task_title" id="task_title" class="form-control" id="status">
                                        <input type="text" value="" name="user_id" id="user_id" class="form-control" id="status">
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal">Close</button>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {


                    var Task_table = $("#task_template_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: '<?= base_url("api/task_template/get_all") ?>',
                            type: 'GET',
                           
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {
                                        let del_btn = true ? `<a href="<?= base_url("task_template/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        let action = del_btn ;
                                        return [

                                            `<a href="<?= base_url("task_template/save/") ?>${v.id}">${v.title}</a>`,
                                            v.delta_time,
                                            v.status == true ? `<span class="badge badge-success">Active</span>` : `<span class="badge badge-warning">InActive</span>`,
                                            action
                                        ];
                                    });
                                } else if (d.code == 203) {
                                    // page_redirect(d.response);
                                }
                                return [];
                            }
                        },

                    });
                    Task_table.buttons().container().appendTo('#Task_table_wrapper .col-md-6:eq(0)');


                });

                $('#taskModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var user_id = button.data('whatever')
                    var id = button.data('id')
                    var modal = $(this)
                    $.ajax({
                        url: '<?= base_url("api/task/get_all") ?>',
                        type: 'get',
                        data: {
                            user_id: user_id,
                            id: id
                        },
                        success: function(response) {
                            $('.modal-body').html('<h5>'+response.data[0].task_title + '</h5><br/>  <div class="alert direct-chat-primary" role="alert">' + response.data[0].description + '</div><br/>' + response.data[0].full_name);
                            $('#taskModal').modal('show');
                        }
                    });

                  
 
                    // modal.find('.modal-title').text('New Task' + recipient)
                    // modal.find('.modal-body input').val(recipient)

                })
                $(document).ready(function() {
                    $('#task').on('submit', function(e) {
                        e.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: "<?= base_url("api/task_template/save") ?>",
                            data: $('#task').serialize(),
                            success: function(response) {
                                console.log(response)
                                $('#studentaddmodal').modal('hide')
                                alert("data saved");
                            },
                            error: function(error) {
                                console.log(error)
                                alert("Data not saved");
                            }
                        });
                    });
                });
            </script>