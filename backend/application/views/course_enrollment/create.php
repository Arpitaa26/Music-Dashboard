<?php
$id = "0";
$user_id = "";
$batch_id = "";
$course_id = "";
$course_level_id = "";
$referral_code_used = "";
$modules_completed = "";
$attendance = "";
$category = "";
$classes_purchased = "";
$classes_used = "";
$status = "";
$action_url = base_url("course_enrollment/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($course_enrollment->id)) :
    $id = $course_enrollment->id;
    $user_id = $course_enrollment->user_id;
    $batch_id = $course_enrollment->batch_id;
    $course_id = $course_enrollment->course_id;
    $course_level_id = $course_enrollment->course_level_id;
    $referral_code_used = $course_enrollment->referral_code_used;
    $modules_completed = $course_enrollment->modules_completed;
    $attendance = $course_enrollment->attendance;
    $classes_purchased = $course_enrollment->classes_purchased;
    $category = $course_enrollment->category;
    $classes_used = $course_enrollment->classes_used;
    $status = $course_enrollment->status;
    $action_url = base_url("course_enrollment/save/{$id}");
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Course Enrollment</h1>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('course_enrollment') ?>">Course Enrollment</a></li>
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
                            <?php if (isset($course_enrollment->id)) { ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user" class="col-form-label-sm">Student</label>
                                        <?php $user_error = set_form_error('user_id', false);
                                        if ($users) {
                                            $users = ["" => "Select"] + array_column($users, "full_name", "id");
                                        }
                                        ?>
                                        <?= form_dropdown(
                                            'user_id',
                                            $users,
                                            set_value('user_id', $user_id),
                                            "class='custom-select custom-select-sm {$user_error}' readonly"
                                        ) ?>
                                        <?= set_form_error('user_id'); ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user" class="col-form-label-sm">Student</label>
                                         <?php $user_error = set_form_error('user_id', false);
                                        if ($users) {
                                            $users = ["" => "Select"] + array_column($users, "full_name", "id");
                                        }
                                        ?>
                                        <?= form_dropdown(
                                            'user_id',
                                            $users,
                                            set_value('user_id', $user_id),
                                            "class='custom-select custom-select-sm {$user_error}'"
                                        ) ?>
                                        <?= set_form_error('user_id'); ?>
                                    </div>
                                </div>

                            <?php } ?>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="course" class="col-form-label-sm">Course</label>
                                    <?php $course_error = set_form_error('course_id', false);
                                    if ($courses) {
                                        $courses = ["" => "Select"] + array_column($courses, "name", "id");
                                    }
                                    ?>
                                    <?= form_dropdown(
                                        'course_id',
                                        $courses,
                                        set_value('course_id', $course_id),
                                        "class='custom-select custom-select-sm {$course_error}' id='course_id'"
                                    ) ?>
                                    <?= set_form_error('course_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                    <?= form_dropdown('course_level_id', $course_levels_options, set_value('course_level_id', $course_level_id), "class='custom-select custom-select-sm {$course_level_error}' id='course_level_id'") ?>
                                    <?= set_form_error('course_level_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch" class="col-form-label-sm">Batch</label>
                                    <?php $batch_error = set_form_error('batch_id', false);
                                    $batches = ["" => "Select"];
                                    ?>
                                    <?= form_dropdown(
                                        'batch_id',
                                        $batches,
                                        set_value('batch_id', $batch_id),
                                        "class='custom-select custom-select-sm {$batch_error}' id='batch_id'"
                                    ) ?>
                                    <?= set_form_error('batch_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="referral_code_used" class="col-form-label-sm">Referal Code</label>
                                    <input type="text" name="referral_code_used" value="<?= set_value('referral_code_used', $referral_code_used) ?>" class="form-control form-control-sm <?= set_form_error('referral_code_used', false); ?>">
                                    <?= set_form_error('referral_code_used'); ?>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php $status_error = set_form_error('status', false); ?>
                                    <?= form_dropdown('status', ['1' => 'Active','0' => 'Inactive', '2' => 'Completed'], set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
                                    <?= set_form_error('status'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Category</label>
                                    <?php
                                    $session_error = set_form_error('category', false);
                                    $session_types = array_column($session_types, "type", "type");
                                    ?>
                                    <?= form_dropdown('category', $session_types, set_value('category', $category), "class='custom-select custom-select-sm {$session_error}'") ?>
                                    <?= set_form_error('category'); ?>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <?php
                        $session_error = set_form_error('id', false);
                        ?>
                        <input type="hidden" name="id" value="<?= $id ?>" />
                        <?= set_form_error('id'); ?>
                        <?php

                        echo validation_errors(); ?>
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

        function get_batches(course_id, course_level_id, batch_id) {
            $.ajax({
                url: `<?= base_url("api/batch/get_all") ?>?course_id=${course_id}&course_level_id=${course_level_id}`,
                type: "get",
                dataType: "json",
                success: function(resp) {
                    if (resp.code == 200) {
                        let options = resp.data.map((d) => {
                            var is_select = "";

                            if (batch_id != "") {
                                d.id == batch_id ? is_select = "selected" : "";
                            }
                            return `<option value="${d.id}" ${is_select}>${d.code}</option>`;
                        }).join("");

                        $("#batch_id").html(`<option value=''>Select</option> ${options}`);
                    } else {
                        $("#batch_id").html("<option value=''>Select</option>");
                    }
                }
            });
        }

        // ======== on load change ======== //
        <?php
        if (!empty(set_value('course_id', $course_id))) {
            $c_id = set_value('course_id', $course_id);
            $b_id = set_value('batch_id', $batch_id);
            $c_l_id = set_value('course_level_id', $course_level_id);
        ?>
            get_batches(<?= $c_id . "," . $c_l_id . "," . $b_id; ?>);
        <?php
        }
        ?>

        //*******  ajax call when changed event is fire *******//

        // $("body").on("change", "#course_id", function() {
        //     let course_id = $(this).val();
        //     let batch_id = $("#batch_id").val();

        //     if (course_id > 0) {
        //         get_batches(course_id, batch_id);
        //     } else {
        //         $("#batch_id").html("<option value=''>Select</option>");
        //     }
        // });
        $("body").on("change", "#course_level_id", function() {

            let course_level__id = $("#course_level_id").val();
            let course_id = $("#course_id").val();
            let batch_id = $("#batch_id").val();

            if (course_level__id > 0) {
                get_batches(course_id, course_level__id, batch_id);
            } else {
                $("#batch_id").html("<option value=''>Select</option>");
            }
        });
    });

    $('#user_id').css('pointer-events','none');
</script>