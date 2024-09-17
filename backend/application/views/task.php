<?php
$id = "";
$user_id = "";
$task_title = "";
$status = "0";
$role= "SUPPORT";
$task_date="";
$task_type="";
$description = "";
$action_url = base_url("create");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";

if (isset($task->id)) :
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
    $id = $task->id;
    $task_title = $task->task_title;
    $task_type = $task->$task_type;
    $user_id = $task->user_id;
    $status = $task->status;
    $description = $task->description;
    $action_url = base_url("task/save/{$user_id}");

endif;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The SVP Academy</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/fontawesome-free/css/all.min.css") ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css") ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url("assets/dist/css/adminlte.min.css") ?>">
</head>
<body>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tasks <?= $label ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('task') ?>">Task</a></li>
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
                        <?= get_message() ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Task" class="col-form-label-sm">Task Title</label>
                                    <input type="hidden" name="role" id="role" value="<?= set_value('role', $role) ?>" class="form-control form-control-sm <?= set_form_error('task_title', false); ?>" placeholder="Task name">
                                    <input type="text" name="task_title" id="task_title" value="<?= set_value('task_title', $task_title) ?>" class="form-control form-control-sm <?= set_form_error('task_title', false); ?>" placeholder="Task name">
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
                           
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="assign_name" class="col-form-label-sm">Assign</label>
                               <?php
                                    $user_error = set_form_error('user_id', false);
                                    $users = ["" => "Select"] + array_column($users, "full_name", "id");
                                    ?>
                                    <?= form_dropdown('user_id',  $users, set_value('user_id', $user_id), "class='custom-select custom-select-sm {$user_error}'") ?>
                                    <?= set_form_error('user_id'); ?>
                                  

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="task_type" class="col-form-label-sm">Task Type</label>
                                        <?php $task_type_error = set_form_error('task_type', false); ?>
                                        <?= form_dropdown('task_type', ['SUPPORT' => 'SUPPORT'], set_value('task_type', $task_type), "class='custom-select custom-select-sm {$task_type_error}'") ?>
                                        <?= set_form_error('task_type'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date" class="col-form-label-sm">Task Date</label>
                                        <?php $task_date_error = set_form_error('task_date', false); ?>
                                        <input type="date" name="task_date" id="task_date" value="<?= set_value('task_date', $task_date) ?>" class="form-control form-control-sm <?= set_form_error('task_date', false); ?>" placeholder="Task Date">
                                        <?= set_form_error('task_date'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label-sm">Status</label>
                                        <?php $status_error = set_form_error('status', false); ?>
                                        <?= form_dropdown('status', ['' => 'Select', '0' => 'Incompleted', '1' => 'Completed'], set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
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

    <!-- jQuery -->
    <script src="<?= base_url("assets/plugins/jquery/jquery.min.js") ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url("assets/dist/js/adminlte.min.js") ?>"></script>
</body>
</html>