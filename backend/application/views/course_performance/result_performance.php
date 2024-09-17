<?php
$certificate_file='';
$performance_id ='';
$id = "";
$marks = "";
$status = "1";
$result_type = "";
$action_url = base_url("course_performance/save/");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($performance->id)) :
    $performance_id = $performance->id;
    $action_url = base_url("course_performance/save/{$performance_id}");
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;

?>


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Teacher's Batches</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('batch_teacher') ?>">Teacher's Batches</a></li>
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
                    <?= form_open_multipart($action_url, ['method' => "post", "id" => "moduleForm"]); ?>
                    <div class="card-body append_place">

                        <div class="row ">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user" class="col-form-label-sm">Teacher</label>
                                    <?php $user_error = set_form_error('user_id', false);
                                    if ($teachers) {
                                        $teachers = ["" => "Select"] + array_column($teachers, "full_name", "id");
                                    }
                                    ?>
                                    <?= form_dropdown(
                                        'user_id',
                                        $teachers,
                                        set_value('user_id', $user_id),
                                        "class='custom-select custom-select-sm {$user_error}'"
                                    ) ?>
                                    <?= set_form_error('user_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Module" class="col-form-label-sm">Modules</label>
                                    <?php $user_error = set_form_error('module_id', false);
                                    if ($modules) {
                                        $modules = ["" => "Select"] + array_column($modules, "name", "id");
                                    }
                                    ?>
                                    <?= form_dropdown(
                                        'module_id',
                                        $modules,
                                        set_value('module_id', $module_id),
                                        "class='custom-select custom-select-sm {$user_error}'"
                                    ) ?>
                                    <?= set_form_error('module_id'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user" class="col-form-label-sm">Batches</label>
                                    <?php $user_error = set_form_error('batch_id', false);
                                    if ($batches) {
                                        $batches = ["" => "Select"] + array_column($batches, "code", "id");
                                    }
                                    ?>
                                    <?= form_dropdown(
                                        'batch_id',
                                        $batches,
                                        set_value('batch_id', $batch_id),
                                        "class='custom-select custom-select-sm {$user_error}'"
                                    ) ?>
                                    <?= set_form_error('batch_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Module" class="col-form-label-sm">Result type</label>
                                    <?php $result_type_error = set_form_error('result_type', false); ?>
                                    <?= form_dropdown('result_type', ['CWA' => 'CWA', 'COA' => 'COA'], set_value('result_type', $result_type), "class='custom-select custom-select-sm {$result_type_error}'") ?>
                                    <?= set_form_error('result_type'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="marks" class="col-form-label-sm">Marks</label>
                                    <input type="number" name="marks" value="<?= set_value('marks', $marks) ?>" class="form-control form-control-sm <?= set_form_error('marks', false); ?>">
                                    <?= set_form_error('marks'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="certificate_file" class="col-form-label-sm">Certificate File</label>
                                    <input type="file" name="certificate_file" value="<?= set_value('certificate_file', $certificate_file) ?>" class="<?= set_form_error('Certificate_file', false); ?>">
                                    <?= set_form_error('certificate_file'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php $status_error = set_form_error('status', false); ?>
                                    <?= form_dropdown('status', ['1' => 'Active', '0' => 'Inactive'], set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
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