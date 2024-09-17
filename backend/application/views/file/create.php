<?php
$id = "";
$file_name = "";
$slug = "";
$category = "";
$created_on = "";
$description = "";
$status = "1";
$action_url = base_url("file/file_save");
$label = "Create";
$icon="<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if(isset($file->id)) :
    $id = $file->id;
    $file_name= $file->file_name;
    $slug = $file->slug;
    $category = $file->category;
    $created_on = $file->created_on;
    $path = $file->path;
    $status = $file->status;
    $action_url = base_url("file/file_save/{$id}");
    $label = "Edit";
    $icon="<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <?= $label ?>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('file') ?>">file</a></li>
                    <li class="breadcrumb-item active">
                        <?= $label ?>
                    </li>
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
                        <h3 class="card-title font-weight-bold">
                            <?= $icon ?>
                        </h3>
                    </div>
                    <?= form_open_multipart($action_url, ['method' => "post", "id" => "file", "enctype" => "multipart/form-data"]); ?>
                    <div class="card-body append_place">

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Upload" class="col-form-label-sm">Upload</label>

                                   
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category" class="col-form-label-sm"> category</label>
                                    <!-- <input type="text" name="category" value="<?= set_value('category', $category) ?>" class="form-control form-control-sm <?= set_form_error('category', false); ?>" placeholder="category">
                                    -->
                                    <?= set_form_error('category'); ?>
                                    <?php $category_error = set_form_error('category', false); ?>
                                    <?= form_dropdown('category', ['' => 'Select', 'document' => 'document', 'image' => 'image'], set_value('category', $category), "class='custom-select custom-select-sm {$category_error}'") ?>
                                    <?= set_form_error('category'); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php $status_error = set_form_error('status', false); ?>
                                    <?= form_dropdown('status', ['' => 'Select', '1' => 'Active', '0' => 'Inactive'], set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
                                    <?= set_form_error('status'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="file_name" class="col-form-label-sm">file_name</label>
                                    <input type="file" id="file_name" name="file_name" class="form-control form-control-sm <?= set_form_error('file_name', false); ?>" rows="5" placeholder="file_name"><?=set_value('file_name', $file_name)?>
                                    <input type="hidden" name="file_edit" value="<?=set_value('file_name', $file_name)?>" class="form-control form-control-sm" >
                                    
                                    <?= set_form_error('file_name'); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" id="upload" class="btn btn-sm btn-primary float-right"><i class="fa fa-save"></i> Save
                            Changes</button>
                    </div>
                    <?= form_close() ?>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

