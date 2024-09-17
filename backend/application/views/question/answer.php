<?php
$id = "";
$user_id = "";
$question_id = "";
$answer = "";

$action_url = base_url("question_answer/save/11");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";

?>

<!-- Loading dropzone.css -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Question <?= $label ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('question_answer') ?>">question_answer</a></li>
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
                    <?= form_open_multipart($action_url, ['method' => "post", "id" => "ans_form"]); ?>
                 
                    <div class="card-body append_place">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <input type="hidden" name="user_id" value="11" id="user_id">
                                    <label for="course_id" class="col-form-label-sm">Question_id</label>
                                    <input type="text" name="question_id[]" value="<?= set_value('question_id[]', $question_id) ?>" class="form-control form-control-sm <?= set_form_error('question_id[]', false); ?>" placeholder="Question Hints">
                                    <?= set_form_error('question_id[]'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="answer" class="col-form-label-sm">answer</label>
                                    <input type="text" name="answer[]" value="<?= set_value('answer[]', $answer) ?>" class="form-control form-control-sm <?= set_form_error('answer[]', false); ?>" placeholder="Question answer">
                                    <?= set_form_error('answer[]'); ?>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <input type="hidden" value="11" id="user_id">
                                    <label for="course_id" class="col-form-label-sm">Question_id</label>
                                    <input type="text" name="question_id[]" value="<?= set_value('question_id[]', $question_id) ?>" class="form-control form-control-sm <?= set_form_error('question_id[]', false); ?>" placeholder="Question Hints">
                                    <?= set_form_error('question_id[]'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="answer" class="col-form-label-sm">answer</label>
                                    <input type="text" name="answer[]" value="<?= set_value('answer[]', $answer) ?>" class="form-control form-control-sm <?= set_form_error('answer[]', false); ?>" placeholder="Question answer">
                                    <?= set_form_error('answer[]'); ?>
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

