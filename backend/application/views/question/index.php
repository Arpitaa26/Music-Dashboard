            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Question</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Question</li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Question</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <form action="<?= base_url('question'); ?>" method="GET">
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

                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="module" class="col-form-label-sm">Module</label>

                                                        <?php

                                                        $modules_options = ["" => "Select"];
                                                        
                                                        if ($modules) {
                                                            $modules_options = array_reduce($modules, function ($s, $d) {
                                                                return ($s + [$d->id => $d->name]);
                                                            }, $modules_options);
                                                        }
                                                        ?>


                                                        <?= form_dropdown('module_id', $modules_options, set_value('module_id', $module_id), "class='custom-select custom-select-sm' name='module_id' id='module_id'") ?>

                                                    </div>

                                                </div>
                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="tutorial" class="col-form-label-sm">Tutorial</label>

                                                        <?php
                                                        $tutorials_options = ["" => "Select"];
                                                        if ($tutorials) {
                                                            $tutorials_options = array_reduce($tutorials, function ($s, $d) {
                                                                return ($s + [$d->id => $d->title]);
                                                            }, $tutorials_options);
                                                        }
                                                        ?>
                                                        <?= form_dropdown('tutorial_id', $tutorials_options, set_value('tutorial_id', $tutorial_id), "class='custom-select custom-select-sm' name='tutorial_id' id='tutorial_id'") ?>

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
                                    <table class="table text-center" id="question_table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th></th>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Course</th>
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
                <a href="<?= base_url('question/save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
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
                                get_questions();
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

                        get_questions();
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

                    var question_table;
                   
                    
                     
                
                  
                    function get_questions() {

                        if ($.fn.dataTable.isDataTable('#question_table')) {
                            question_table.destroy();
                        }
                        course_id = $("#course_id").val();
                        module_id = $("#moduleId").val();
                        question_table = $("#question_table").DataTable({
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
                                url: '<?= base_url("api/question/get_all") ?>',
                                type: 'GET',
                                data: function(d) {
                                    d.course_id = $("#course_id").val();
                                    // debugger;
                                    d.module_id = $("#module_id").val();
                                    d.tutorial_id = $("#tutorial_id").val();
                                },
                                dataSrc: function(d) {
                                    if (d.code == 200) {

                                        return d.data.map((v, i) => {
                                            let del_btn = true ? `<a href="<?= base_url("question/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                            let sort = course_id > 0 ? (module_id > 0 ? `<span class="handle badge"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>` : '') : '';

                                            return [
                                                v.order,
                                                v.id,
                                                sort,
                                                `<a href="<?= base_url("question/save/") ?>${v.id}">${v.name}</a>`,
                                                v.course_name,
                                                v.module_name,
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
  

                        //data table reorder
                        if ((course_id > 0) && (module_id > 0)) {
                            question_table.on('row-reordered', function(e, diff, edit) {

                                updatedtorder(question_table, diff, "<?php echo base_url('api/question/updateOrder'); ?>")
                            });
                        }
                        //

                    }



                });
            </script>