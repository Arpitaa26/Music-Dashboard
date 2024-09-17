<?php
$id = "";
$status = "1";
$country_code = "";
$country_name = "";
$country_currency = "";
$action_url = base_url("country/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($country->id)) :
    $id = $country->id;
    $country_name= $country->country_name;
    $country_code= $country->country_code;
    $country_currency= $country->course_currency;
    $action_url = base_url("country/save/{$id}");
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";

endif;

?>


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Country</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('country/save/' . $id) ?>">Country</a></li>
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
                    <?= form_open($action_url, ['method' => "post", "id" => "question_option_form"]); ?>
                    <div class="card-body append_place">

                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Country Code" class="col-form-label-sm">Country Code</label>

                                    <input type="text" name="country_code" value="<?= set_value('country_code', $country_code) ?>" class="form-control form-control-sm <?= set_form_error('country_code', false); ?>">
                                    <?= set_form_error('country_code'); ?>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Country Name" class="col-form-label-sm">Country Name</label>
                                    <input type="text" name="country_name" value="<?= set_value('country_name', $country_name) ?>" class="form-control form-control-sm <?= set_form_error('country_name', false); ?>">
                                    <?= set_form_error('country_name'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Country Currency" class="col-form-label-sm">Country Currency</label>
                                    <input type="text" name="course_currency" value="<?= set_value('course_currency', $country_currency) ?>" class="form-control form-control-sm <?= set_form_error('course_currency', false); ?>">
                                    <?= set_form_error('course_currency'); ?>
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