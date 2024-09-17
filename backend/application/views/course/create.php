<?php
$id = "";
$name = "";
$code = "";
$role = "";
$price = "";
$status = "1";
$description = "";
$short_description = "";
$action_url = base_url("course/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($course->id)) :
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
    $id = $course->id;
    $name = $course->name;
    $code = $course->code;
    $role = $course->role;
    $price = $course->price;
    $status = $course->status;
    $description = $course->description;
    $short_description = $course->short_description;
    $action_url = base_url("course/save/{$id}");

endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Course <?= $label ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('course') ?>">Course</a></li>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label-sm">Name</label>
                                    <input type="text" name="name" id="name" value="<?= set_value('name', $name) ?>" class="form-control form-control-sm <?= set_form_error('name', false); ?>" placeholder="Course name">
                                    <?= set_form_error('name'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code" class="col-form-label-sm">Code</label>
                                    <input type="text" name="code" id="code" value="<?= set_value('code', $code) ?>" class="form-control form-control-sm <?= set_form_error('code', false); ?>" placeholder="Course code">
                                    <?= set_form_error('code'); ?>
                                </div>
                            </div>

                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php $status_error = set_form_error('status', false); ?>
                                    <?= form_dropdown('status', ['' => 'Select', '1' => 'Active', '0' => 'Inactive'], set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
                                    <?= set_form_error('status'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="col-form-label-sm">Role</label>
                                    <?php $role_error = set_form_error('role', false); ?>
                                    <?= form_dropdown('role', ['' => 'Select', 'paid' => 'Paid', 'free' => 'Free'], set_value('role', $role), "class='custom-select custom-select-sm {$role_error}' id='role'") ?>
                                    <?= set_form_error('role'); ?>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="col-form-label-sm">Price</label>
                                    <input type="number" name="price" id="price" value="<?= set_value('price', $price) ?>" class="form-control form-control-sm <?= set_form_error('price', false); ?>" placeholder="Course price">
                                    <?= set_form_error('price'); ?>
                                </div>
                            </div> -->
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="short_description" class="col-form-label-sm">Short Description</label>
                                    <textarea id="short_description" name="short_description" class="form-control form-control-sm <?= set_form_error('short_description', false); ?>" rows="4" placeholder="Short Description"><?= set_value('short_description', $short_description) ?></textarea>
                                    <?= set_form_error('description'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="col-form-label-sm">Description</label>
                                    <textarea id="description" name="description" class="form-control form-control-sm <?= set_form_error('description', false); ?>" rows="4" placeholder="Description"><?= set_value('description', $description) ?></textarea>
                                    <?= set_form_error('description'); ?>
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
<script>
    $(document).ready(function() {
        $("body").on("change", "#role", function() {
            let type = $(this).val();
            if(type == "free") {
            $("#price").attr('readonly', 'readonly');
            $('#price').val('00');
        } else {
            $('#price').val(<?= set_value('price', $price) ?>);
           
            $("#price").removeAttr('readonly', 'readonly'); 
        }
        });
       

    });
</script>
