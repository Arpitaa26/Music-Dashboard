<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Module</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active">Module</li>
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
                        <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Module</h3>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <form action="<?= base_url('module'); ?>" method="GET">
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
                                            <label for="course_level" class="col-form-label-sm">Course levels</label>
                                            <?php
                                            $course_levels_options = ["" => "Select"];
                                            // if ($course_levels) {
                                            //     $course_levels_options = array_reduce($course_levels, function ($s, $d) {
                                            //         return ($s + [$d->id => $d->level]);
                                            //     }, $course_levels_options);
                                            // }
                                            ?>
                                            <?= form_dropdown('course_level_id', $course_levels_options, set_value('course_level_id', $course_level_id), "class='custom-select custom-select-sm filter_btn' name='course_level_id' id='course_level_id'") ?>
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
                        <table class="table text-center" id="module_table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Course</th>
                                    <th>Course Level</th>
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
    <a href="<?= base_url('module/save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
</section>
<!-- /.content -->


<script>
    $(document).ready(function() {
        function get_course_level(course_id, course_level_id) {
            $.ajax({
                url: `<?= base_url("api/module/get_all") ?>?course_id=${course_id}`,
                type: "get",
                dataType: "json",
                success: function(resp) {
                    if (resp.code == 200) {
                        var levellist = [];
                        let options = resp.data.map((d) => {
                            if ((levellist[d.course_level_id]) == undefined) {

                                levellist[d.course_level_id] = d.course_level_id;
                                var is_select = "";

                                if (course_level_id != "") {
                                    d.course_level_id == course_level_id ? is_select = "selected" : "";
                                }
                                return `<option value="${d.course_level_id}" ${is_select}>${d.course_level}</option>`;
                            }
                        }).join("");

                        $("#course_level_id").html(`<option value=''>Select</option> ${options}`);
                    } else {
                        $("#course_level_id").html("<option value=''>Select</option>");
                    }
                    get_module();
                }

            });

        }
        //  run();
        <?php
        if (!empty(set_value('course_id', $course_id))) {
            $c_id = set_value('course_id', $course_id);
            $c_l_id = set_value('course_level_id', $course_level_id);

        ?>

            get_course_level(<?= $c_id . "," . $c_l_id; ?>);
        <?php
        } else {
        ?>

            get_module();
        <?php
        }
        ?>

        $("body").on("change", "#course_id", function() {
            let course_id = $(this).val();

            let course_level_id = $("#course_level_id").val();

            if (course_id > 0) {
                get_course_level(course_id, course_level_id);

            } else {
                $("#course_level_id").html("<option value=''>Select</option>");
            }
        });



        function get_module() {

            if ($.fn.dataTable.isDataTable('#course_table')) {
                course_table.destroy();
            }
            var course_id = $("#course_id").val();

            var course_level_id = $("#course_level_id").val();

            var course_table = $("#module_table").DataTable({
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
                    url: '<?= base_url("api/module/get_all") ?>',
                    type: 'GET',
                    data: function(d) {
                        d.course_id = $("#course_id").val();
                        d.course_level_id = $("#course_level_id").val();
                    },
                    dataSrc: function(d) {
                        if (d.code == 200) {
                            return d.data.map((v, i) => {
                                let del_btn = true ? `<a href="<?= base_url("module/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                let sort = course_id > 0 ? (course_level_id > 0 ? `<span class="handle badge"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>` : '') : '';
                                let module_b = `<a href="<?= base_url("question") ?>?module_id=${v.id}" name="module_id" class="btn btn-xs btn-success" title="Question" data-toggle="tooltip">Question</a>`;

                                let action = module_b + '&nbsp' + del_btn;

                                return [
                                    v.order,
                                    v.id,
                                    sort,
                                    `<a href="<?= base_url("module/save/") ?>${v.id}">${v.name}</a>`,
                                    v.course_name,
                                    v.course_level,
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

            if ((course_id > 0) && (course_level_id > 0)) {
                course_table.on('row-reordered', function(e, diff, edit) {

                    updatedtorder(course_table, diff, "<?php echo base_url('api/module/updateOrder'); ?>")
                });
            }
            //
        }
    });
</script>