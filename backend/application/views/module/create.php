<?php
$id = "";
$course_id = "";
$course_level_id = "";
$name = "";
$status = "1";
$description = "";
$action_url = base_url("module/save");
$label = "Create";
$icon="<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($module->id)) :
    $id = $module->id;
    $name = $module->name;
    $status = $module->status;
    $description = $module->description;
    $course_id = $module->course_id;
    $course_level_id = $module->course_level_id;
    $action_url = base_url("module/save/{$id}");
    $label = "Edit";
    $icon="<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Module <?= $label ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('module') ?>">Module</a></li>
                    <li class="breadcrumb-item active"><?= $label ?></li>
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
                        <h3 class="card-title font-weight-bold"> <?= $icon ?></h3>
                    </div>
                    <?= form_open($action_url, ['method' => "post", "id" => "moduleForm"]); ?>
                    <div class="card-body append_place">

                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course" class="col-form-label-sm">Course</label>
                                    <?php $course_error = set_form_error('course_id', false);
                                    $courses_options = ["" => "Select"];
                                    if ($courses) {
                                        $courses_options = array_reduce($courses, function ($s, $d) {
                                            return ($s + [$d->id => $d->name]);
                                        }, $courses_options);
                                    }
                                    ?>
                                    <?= form_dropdown('course_id', $courses_options, set_value('course_id', $course_id), "class='custom-select custom-select-sm {$course_error}' name='course_id' id='course_id'") ?>
                                    <?= set_form_error('course_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_level" class="col-form-label-sm">Course levels</label>
                                    <?php $course_level_error = set_form_error('course_level_id', false);
                                    $course_levels_options = ["" => "Select"];
                                    if ($course_levels) {
                                        $course_levels_options = array_reduce($course_levels, function ($s, $d) {
                                            return ($s + [$d->id => $d->level]);
                                        }, $course_levels_options);
                                    }
                                    ?>
                                    <?= form_dropdown('course_level_id', $course_levels_options, set_value('course_level_id', $course_level_id), "class='custom-select custom-select-sm {$course_level_error}' name='course_level_id' id='course_level_id'") ?>
                                    <?= set_form_error('course_level_id'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price" class="col-form-label-sm">Name</label>
                                    <input type="text" name="name[]" value="<?= set_value('name[]', $name) ?>" class="form-control form-control-sm <?= set_form_error('name[]', false); ?>" placeholder="Module name">
                                    <?= set_form_error('name[]'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price" class="col-form-label-sm">Description</label>
                                    <textarea type="text" name="description[]" rows="2" class="form-control form-control-sm <?= set_form_error('description[]', false); ?>" placeholder="Description"><?= set_value('description[]', $description) ?></textarea>
                                    <?= set_form_error('description[]'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php $status_error = set_form_error('status[]', false); ?>
                                    <?= form_dropdown('status[]', ['' => 'Select', '1' => 'Active', '0' => 'Inactive'], set_value('status[]', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
                                    <?= set_form_error('status[]'); ?>
                                </div>
                            </div>

                        </div>



                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <?php if (empty($id)) : ?>
                            <!-- <button type="button" class="btn btn-sm btn-primary float-left" id="addModule">Add New</button> -->
                        <?php endif; ?>
                        <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fa fa-save"></i> Save Changes</button>
                    </div>
                    <?= form_close() ?>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<script>
    $(document).ready(function() {
        $("#addModule").click(function() {
            var html = `
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price" class="col-form-label-sm">Name</label>
                        <input type="text" name="name[]" value="" class="form-control form-control-sm" placeholder="Module name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="description" class="col-form-label-sm">Description</label>
                        <textarea type="text" name="description[]" value="" rows="2" class="form-control form-control-sm" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status" class="col-form-label-sm">Status</label>
                        <select name="status[]" class="custom-select custom-select-sm ">
                            <option value="" selected="selected">Select</option>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-1">
                    <div class="form-group">
                        <button  type="button" class="btn btn-xs btn-danger remove_btn" title="Remove"><i class='fa fa-times'></i></button>
                    </div>
                </div>
            </div>`;

            $(".append_place").append(html);
        });

        $("#moduleForm").on('click', ".remove_btn", function() {
            $(this).parent().parent().parent().remove();
        });

    });
    
   /* 
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
                                        
                                        if ((levellist[d.course_level_id])==undefined) {

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
                              //  get_module();
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

                  //  get_module();
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
 });
*/
</script>