<?php
$id = "";
$user_id = "";
$course_id = "";
$is_accepted_for_course = "";
$status = "";
$action_url = base_url("course_teacher/save");
$label = "Create";

if (isset( $teachers->id)) :
    $id =  $teachers->id;
    $user_id =  $teachers->user_id;
    $course_id =  $teachers->course_id;
    $is_accepted_for_course =  $teachers->is_accepted_for_course;
    $status =  $teachers->status;
    $action_url = base_url("course_teacher/save/{$user_id}");
    $label = "Edit";
    $icon="<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
endif;

if (isset($course_teacher_map)) :
    $action_url = base_url("course_teacher/save/{$user_id}");
    $label = "Edit";
    $icon="<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Teacher's Course</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('course_teacher') ?>">Teacher's Course</a></li>
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
                                    <label for="user" class="col-form-label-sm">Teacher</label>
                                    
                                    <input type="hidden" name="user_id" value="<?= set_value('user_id', $course_teacher[0]->user_id) ?>" class="form-control form-control-sm">
                                    <input type="text" name="user" value="<?= set_value('user_id', $course_teacher[0]->user_fullname) ?>" class="form-control form-control-sm <?= set_form_error('user_id', false); ?>" readonly>
                                    <?=set_form_error('user_id'); ?>
                                 
                                  
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_id" class="col-form-label-sm">Course</label>
                                    <?php $course_error = set_form_error('course_id[]', false);
                                    if (isset($courses)) {
                                        
                                        $courses_options = ["" => "Select"] +array_column($courses, "name", "id");
                                      
                                    }
                                    else {
                                        $courses_options =["" => "Select"];;
                                    }
                                    ?>
                                    <?= form_dropdown('course_id[]', $courses_options,set_value('course_id[]', isset($course_teacher_map)?array_column($course_teacher_map, "course_id"):$course_id), "class='select2 {$course_error}' multiple='multiple'  id='course_id' style='width: 100%;'") ?>
                                    <?= set_form_error('course_id[]'); ?>

                                   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_accepted_for_course" class="col-form-label-sm">Is Accepted</label>
                                    <?php $is_accepted_error = set_form_error('is_accepted_for_course', false); ?>
                                    <?= form_dropdown('is_accepted_for_course', ['' => 'Select', '1' => 'Yes', '0' => 'No'], set_value('is_accepted_for_course', $is_accepted_for_course), "class='custom-select custom-select-sm {$is_accepted_error}'") ?>
                                    <?= set_form_error('is_accepted_for_course'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php $status_error = set_form_error('status', false); ?>
                                    <?= form_dropdown('status', ['' => 'Select', '1' => 'Active', '0' => 'Inactive'], set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
                                    <?= set_form_error('status'); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
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

