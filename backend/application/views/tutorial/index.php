
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tutorial</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active">Tutorial</li>
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
                        <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Tutorial</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <form action="<?= base_url('tutorial'); ?>" method="GET">
                                <input type="hidden" value="<?= $module_id ?>" id="moduleId">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="course" class="col-form-label-sm">Course</label>
                                            <?php
                                            $courses_options = ["" => "Select"];
                                            if ($courses) {
                                                $courses_options = array_reduce($courses, function ($s, $d) {
                                                    return ($s + [$d->id => $d->name]);
                                                }, $courses_options);
                                            }
                                            ?>
                                            <?= form_dropdown('course_id', $courses_options, set_value('course_id', $course_id), "class='custom-select custom-select-sm filter_btn' name='course_id' id='course_id'") ?>
                                        </div>
                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="module" class="col-form-label-sm">Module</label>

                                            <?php

                                            $modules = ["" => "Select"];
                                            ?>


                                            <?= form_dropdown('module_id', $modules, set_value('module_id', $module_id), "class='custom-select custom-select-sm' name='module_id' id='module_id'") ?>

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
                        <table class="table text-center pagin-table" id="tutorial_table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Tutorial Name</th>
                                    <th>Module</th>
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
    <a href="<?= base_url('tutorial/save') ?>" class="btn btn-danger pop_fix_btn" title="New tutorial"><i class="fa fa-plus"></i></a>
</section>
<!-- /.content -->


<script>
    $(document).ready(function() {

        function get_module(course_id, module_id) {
            $.ajax({
                url: `<?= base_url("api/module/get_all") ?>?course_id=${course_id}`,
                type: "get",
                dataType: "json",
                success: function(resp) {
                    if (resp.code == 200) {
                        let options = resp.data.map((d) => {
                            var is_select = "";

                            if (module_id != "") {
                                d.id == module_id ? is_select = "selected" : "";
                            }
                            return `<option value="${d.id}" ${is_select}>${d.name}</option>`;
                        }).join("");

                        $("#module_id").html(`<option value=''>Select</option> ${options}`);
                    } else {
                        $("#module_id").html("<option value=''>Select</option>");
                    }
                    get_tutorial();
                }

            });

        }
        //  run();
        <?php
        if (!empty(set_value('course_id', $course_id))) {
            $c_id = set_value('course_id', $course_id);
            $m_id = set_value('module_id', $module_id);
        ?>
            get_module(<?= $c_id . "," . $m_id; ?>);
        <?php
        } else {
        ?>

            get_tutorial();
        <?php
        }
        ?>

        $("body").on("change", "#course_id", function() {
            let course_id = $(this).val();
            let module_id = $("#moduleId").val();
           
            if (course_id > 0) {
                get_module(course_id, module_id);
            } else {
                $("#module_id").html("<option value=''>Select</option>");
            }
        });
        var tutorial_table;

        function get_tutorial() {

            if ($.fn.dataTable.isDataTable('#tutorial_table')) {
                tutorial_table.destroy();
            }
            module_id = $("#module_id").val()
            course_id = $("#course_id").val();
            var tutorial_table = $("#tutorial_table").DataTable({
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
                },
                {
                    targets: 2,
                    visible: false
                }
            ],
                autoWidth: false,
                serverSide: false,
                processing: true,
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                ajax: {
                    url: '<?= base_url("api/tutorial/get_all") ?>',
                    type: 'GET',
                    data: function(d) {
                        d.module_id = $("#module_id").val();
                        d.course_id = $("#course_id").val();
                    },
                    dataSrc: function(d) {
                        if (d.code == 200) {
                            return d.data.map((v, i) => {
                                let del_btn = true ? `<a href="<?= base_url("tutorial/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                let tutorial_b = `<a href="<?= base_url("question") ?>?tutorial_id=${v.id}" name="tutorial_id" class="btn btn-xs btn-success" title="Question" data-toggle="tooltip">Question</a>`;
                                let sort = course_id > 0 ? (module_id > 0 ? `<span class="handle badge"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>` : '') : '';
                           
                               // let sort =module_id>0? `<span class="handle badge"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>`:'';
                                const d = new Date(v.created_on);
                                let action = tutorial_b + '&nbsp' + del_btn;
                                return [
                                    v.order,
                                    v.id,
                                    v.course_id,
                                    sort,
                                    `<a href="<?= base_url("tutorial/save/") ?>${v.id}">${v.title}</a>`,
                                    v.module_name,
                                    `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`,
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
            //data table reorder
            if (module_id > 0) {
            tutorial_table.on('row-reordered', function(e, diff, edit) {

                updatedtorder(tutorial_table, diff, "<?php echo base_url('api/tutorial/tutorialOrder'); ?>")
            });
        }
            //

        }
    });
</script>