<?php
$id = "";
$course_id = "";
$course_level_id = "";
$code = "";
$no_of_students_allowed = "";
$start_date = "";
$description = "";
$status = "1";
$action_url = base_url("batch/save");
$label = "Create";
$icon="<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($batch->id)) :
    $id = $batch->id;
    $course_id = $batch->course_id;
    $course_level_id=$batch->course_level_id;
    $code = $batch->code;
    $no_of_students_allowed = $batch->no_of_students_allowed;
    $start_date = $batch->start_date;
    $description = $batch->description;
    $status = $batch->status;
    $action_url = base_url("batch/save/{$id}");
    $label = "Edit";
    $icon="<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Batch
                    <?= $label ?>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('question') ?>">Batch</a></li>
                    <li class="breadcrumb-item active">
                        <?= $label ?>
                    </li>
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
                        <h3 class="card-title font-weight-bold">
                            <?= $icon ?>
                        </h3>
                    </div>
                    <?= form_open($action_url, ['method' => "post", "id" => "question_option_form"]); ?>
                    <div class="card-body append_place">

                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Course" class="col-form-label-sm">Course</label>

                                    <?php
                                    $course_error = set_form_error('course_id', false);
                                    $courses = ["" => "Select"] + array_column($courses, "name", "id");
                                    ?>

                                    <?= form_dropdown('course_id', $courses, set_value('course_id', $course_id), "class='custom-select custom-select-sm {$course_error}' name='course_id' id='course_id'") ?>
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
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label for="code" class="col-form-label-sm">Batch Code</label>
                                    <input type="text" name="code" value="<?= set_value('code', $code) ?>" class="form-control form-control-sm <?= set_form_error('code', false); ?>" placeholder="Code">
                                    <?= set_form_error('code'); ?>
                                </div>
                            </div> -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="code" class="col-form-label-sm">No of Students Allow</label>
                                    <input type="text" name="no_of_students_allowed" value="<?= set_value('no_of_students_allowed', $no_of_students_allowed) ?>" class="form-control form-control-sm <?= set_form_error('no_of_students_allowed', false); ?>" placeholder="Sudent Number">
                                    <?= set_form_error('no_of_students_allowed'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date" class="col-form-label-sm">Start Date</label>
                                    <input type="date" name="start_date" value="<?= set_value('start_date', $start_date) ?>" class="form-control form-control-sm <?= set_form_error('start_date', false); ?>">
                                    <?= set_form_error('start_date'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php $status_error = set_form_error('status', false); ?>
                                    <?= form_dropdown('status', ['' => 'Select', '1' => 'Active', '0' => 'Inactive'], set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
                                    <?= set_form_error('status'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="col-form-label-sm">Description</label>
                                    <textarea name="description" class="form-control form-control-sm <?= set_form_error('description', false); ?>" rows="5" placeholder="Description"><?= set_value('description', $description) ?></textarea>
                                    <?= set_form_error('description'); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fa fa-save"></i> Save
                            Changes</button>
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

  /*  
$(document).ready(function() {
        function get_course_level(course_id, course_level_id) {
          
                        $.ajax({
                            url: `<?= base_url("api/batch/get_all") ?>?course_id=${course_id}`,
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
                                        return `<option value="${d.course_level_id}" ${is_select}>${d.level}</option>`;
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