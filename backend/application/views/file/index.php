 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">

           <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Files</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Files</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Files</h3>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                                        <form action="<?= base_url('file'); ?>" method="GET">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="form-group" class="col-form-label-sm">Category</label>

                                                        <?= form_dropdown('category', ['' => 'Select', 'TUTORIAL' => 'TUTORIAL', 'HOMEWORK' => 'HOMEWORK', 'COURSE_MATERIAL' => 'COURSE_MATERIAL', 'COURSE_HOMEWORK' => 'COURSE_HOMEWORK', 'AUDIO_ARCHIVE' => 'AUDIO_ARCHIVE', 'PROFILE_PIC' => 'PROFILE_PIC'], set_value('category', $category), "class='custom-select custom-select-sm' name='category' id='category'") ?>
                                                        <?= set_form_error('category'); ?>

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
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="Files_table">
                                        <thead>
                                            <tr>
                                                <th>File Id</th>
                                                <th>File</th>
                                                <th>Description</th>
                                                <th>Category</th>
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
                <a href="<?= base_url('file/file_save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {
                    var batch_table = $("#Files_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: '<?= base_url("api/file/get_all") ?>',
                            type: 'GET',
                            data: function(d) {
                                d.category = "<?= isset($category) ? $category : ''; ?>"
                                d.user_id = "<?= isset($user_id) ? $user_id : ''; ?>"
                            },
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {

                                        let del_btn = true ? `<a href="<?= base_url("file/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';

                                        //const d = new Date(v.start_date);
                                        return [
                                            `<a href="<?= base_url("file/file_save/") ?>${v.id}">${v.id}</a>`,
                                            `<a href="<?= base_url("file/open/") ?>${v.slug}" data-lightbox="image-1" data-title="${v.description}"><img src="<?= base_url("file/open/") ?>${v.slug}" style="width:20px;height:20px;" alt="${v.file_name}"> </a>`,
                                            v.description,
                                            v.category,
                                            // `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`,
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.js"></script>
            <script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>