<?php
$id = "";
$user_id = "";
$status = "1";
$form = "";
$to = "";
$user_fullname = "";
$action_url = base_url("user_availability/edit");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($teacher->id)) :
    $id = $teacher->id;
    $action_url = base_url("user_availability/edit/{$id}");
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";

endif;

?>


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Teacher's Availability</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('user_availability/edit/'.$id) ?>">Teacher's Availability</a></li>
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
                    <?= form_open($action_url, ['method' => "post", "id" => "user_availability"]); ?>
                    <div class="card-body append_place">

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user" class="col-form-label-sm">Teacher</label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row" id="teacher">
                            <?php
                            if (isset($teacher)) {
                               
                            ?>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Form" class="col-form-label-sm">Form</label>
                                                <input type="hidden" name="status" value="1" class="form-control form-control-sm">
                                                <input type="text" name="from" value="<?= set_value('from', $teacher->from) ?>" class="form-control form-control-sm <?= set_form_error('form', false); ?>">
                                                <?= set_form_error('from'); ?>

                                            </div>
                                        </div>

                                        <div class="col-md-6" id="teachers">
                                            <div class="form-group">
                                                <label for="user_id" class="col-form-label-sm">To</label>

                                                <input type="text" name="to" value="<?= set_value('to',$teacher->to) ?>" class="form-control form-control-sm <?= set_form_error('to', false); ?>">
                                                <?= set_form_error('to'); ?>

                                            </div>
                                        </div>
                                       
                            <?php
                                   
                            }
                            ?>

                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      
                        <button type="submit" class="btn btn-sm btn-primary float-right save"><i class="fa fa-save"></i> Save Changes</button>
                    </div>
                    <?= form_close() ?>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->