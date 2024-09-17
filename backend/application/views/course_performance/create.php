<?php
$id = "";

$batch_id = "";
$user_id = "";
$status = "1";
$description = "";
$action_url = base_url("batch_teacher/save");
$label = "Create";
$icon="<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($batches->id)) :
    $batch_id = $batches->id;
    $action_url = base_url("batch_teacher/save/{$batch_id}");
    $label = "Edit";
    $icon="<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
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
                    <?= form_open($action_url, ['method' => "post", "id" => "moduleForm"]); ?>
                    <div class="card-body append_place">

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="batch" class="col-form-label-sm">Batch</label>

                                    <input type="hidden" name="batch_id" value="<?= set_value('batch_id', $batches->id) ?>" class="form-control form-control-sm">
                                    <input type="text" name="batch" value="<?= set_value('batch_id', $batches->code) ?>" class="form-control form-control-sm <?= set_form_error('batch_id', false); ?>" readonly>
                                    <?= set_form_error('batch_id'); ?>


                                </div>
                            </div>
                        </div>
                        <div class="row" id="modules">
                            <?php
                            if (isset($modules)) {
                                foreach ($modules as $key => $row) :

                            ?>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Module" class="col-form-label-sm">Module</label>
                                            <input type="hidden" name="status[<?= $key ?>]" value="1" class="form-control form-control-sm">

                                            <input type="hidden" name="module_id[]" value="<?= set_value('module_id[' . $key . ']', $row->id) ?>" class="form-control form-control-sm" placeholder="module_id">

                                            <input type="text" name="module" value="<?= set_value('module_id[' . $key . ']', $row->name) ?>" class="form-control form-control-sm <?= set_form_error('module_id[' . $key . ']', false); ?>" readonly>
                                            <?= set_form_error('module_id[' . $key . ']'); ?>

                                        </div>
                                    </div>

                                    <div class="col-md-6" id="teachers">
                                        <div class="form-group">
                                            <label for="user_id" class="col-form-label-sm">Teachers</label>

                                            <?php
                                            if (isset($teachers)) {
                                                $teachers_options = ["" => "Select"] + array_column($teachers, "user_fullname", "user_id");
                                            } else {
                                                $teachers_options = ["" => "Select"];
                                            }
                                            $mapped_teacher_for_module = isset($batch_teacher[$row->id]) ? $batch_teacher[$row->id] : $user_id;

                                            ?>
                                            <?= form_dropdown(
                                                'user_id[' . $key . ']',
                                                $teachers_options,
                                                set_value('user_id[' . $key . ']', $mapped_teacher_for_module),
                                                "class='custom-select custom-select-sm'"
                                            ) ?>


                                        </div>
                                    </div>
                            <?php
                                endforeach;
                            }
                            ?>

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