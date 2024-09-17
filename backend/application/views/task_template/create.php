<?php
$id = "";
$user_id = "";
$task_title = "";
$status = "1";
$category="";
$description = "";
$delta_time="";
$action_url = base_url("task_template/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";

if (isset($task->id)) :
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
    $id = $task->id;
    $task_title = $task->title;
    $delta_time = $task->delta_time;
    $status = $task->status;
    $category=$task->category;
    $description = $task->description;
    $action_url = base_url("task_template/save/{$id}");

endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tasks Template <?= $label ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('task_tamplate') ?>">Task Template</a></li>
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
                    <?= form_open($action_url, ['method' => "post"]); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Title" class="col-form-label-sm">Title</label>
                                    <input type="text" name="task_title" id="task_title" value="<?= set_value('task_title', $task_title) ?>" class="form-control form-control-sm <?= set_form_error('task_title', false); ?>" placeholder="Title">
                                    <?= set_form_error('task_title'); ?>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="col-form-label-sm">Description</label>
                                    <textarea id="description" name="description" class="form-control form-control-sm <?= set_form_error('description', false); ?>" rows="6" placeholder="Description"><?= set_value('description', $description) ?></textarea>
                                    <?= set_form_error('description'); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Delta Time" class="col-form-label-sm">Delta Time</label>
                                    <input type="text" name="delta_time" id="delta_time" value="<?= set_value('delta_time', $delta_time) ?>" class="form-control form-control-sm <?= set_form_error('delta_time', false); ?>" placeholder="Delta Time ">
                                    <?= set_form_error('delta_time'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="assign_name" class="col-form-label-sm">Category</label>
                                    <?= set_form_error('category'); ?>
                                    <?php $category_error = set_form_error('category', false); ?>
                                    <?= form_dropdown('category', ['' => 'Select', 'CLASS_CREATE' => 'CLASS_CREATE', 'LOGIN' => 'LOGIN', 'REGISTER' => 'REGISTER', 'CLASS_START' => 'CLASS_START'], set_value('category', $category), "class='custom-select custom-select-sm {$category_error}'") ?>
                                    <?= set_form_error('category'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php $status_error = set_form_error('status', false); ?>
                                    <?= form_dropdown('status', ['' => 'Select', '1' => 'Active', '0' => 'InActive'], set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
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