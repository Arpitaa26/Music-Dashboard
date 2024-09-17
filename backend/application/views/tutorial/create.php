<?php
$id = "";
$module_id = "";
$title = "";
$description = "";
$status = "1";
$action_url = base_url("tutorial/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($tutorial->id)) :
    $id = $tutorial->id;
    $module_id = $tutorial->module_id;
    $title = $tutorial->title;
    $description = $tutorial->description;
    $status = $tutorial->status;
    $action_url = base_url("tutorial/save/{$id}");
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <!-- dropzone css -->

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tutorial
                    <?= $label ?>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('tutorial') ?>">Tutorial</a></li>
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
                    <?= form_open($action_url, ['method' => "post", "id" => "tutorial_form"]); ?>
                    <div class="card-body append_place">

                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="module_id" class="col-form-label-sm">Module</label>
                                    <?php
                                    $module_error = set_form_error('module_id', false);
                                    $modules = ["" => "Select"] + array_column($modules, "name", "id");
                                    ?>
                                    <?= form_dropdown('module_id', $modules, set_value('module_id', $module_id), "class='custom-select custom-select-sm {$module_error}'") ?>
                                    <?= set_form_error('module_id'); ?>
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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title" class="col-form-label-sm">Tutorial Title</label>
                                    <input type="text" name="title" value="<?= set_value('title', $title) ?>" class="form-control form-control-sm <?= set_form_error('title', false); ?>" placeholder="Tutorial Title">
                                    <?= set_form_error('title'); ?>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="col-form-label-sm">Description</label>
                                    <textarea name="description" id="description" class="form-control form-control-sm <?= set_form_error('description', false); ?>" rows="5" placeholder="Description"><?= set_value('description', $description) ?></textarea>
                                    <?= set_form_error('description'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="boatAddForm" class="final-info">

                                    </div>
                                    <input type="hidden" name="ids" id="img" value="" class="form-control form-control-sm" placeholder="title">


                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- /.card-body -->

                    <?= form_close() ?>
                    <!-- upload -->
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <form action="<?php echo base_url(); ?>api/file/upload" enctype="multipart/form-data" class="dropzone" id="image-upload">
                                <input type="hidden" name="category" value="TUTORIAL" class="form-control form-control-sm <?= set_form_error('category', false); ?>" placeholder="title">
                            </form>
                        </div>
                    </div>
                   
                    <div class="card-footer">
                        <button type="submit" id="save_tutorial" class="btn btn-sm btn-primary float-right"><i class="fa fa-save"></i> Save
                            Changes</button>
                    </div>
              
                    <!-- /.card -->
                </div>
            </div>
        </div>

        <!-- upload -->
        <div class="row container">
            <div class="col-md-12">
                <div id="body">
                    <!--<form action="<?php echo base_url(); ?>api/file/upload" onsubmit="return false" enctype="multipart/form-data" class="dropzone" id="myAwesomeDropzone">-->
                    <!--    <input type="hidden" name="category" value="TUTORIAL" class="form-control form-control-sm <?= set_form_error('category', false); ?>" placeholder="title">-->

                    <!--    <button type="button" class="btn btn-primary btn-sm" id="submit_dropzone_form">Upload</button>-->
                    <!--</form>-->


                    <!-- <button id="uploadFile">Upload Files</button> -->

                </div>
            </div>
            <!-- display -->
            <div class="container">
                <a href="javascript:void(0);" class="reorder_link" id="saveReorder">reorder photos</a>
                <div id="reorderHelper" class="light_box" style="display:none;"></div>
                <div class="gallery final-info">
                    <?php
                    if (isset($tutorial->id)) {

                    ?>

                        <ul class="reorder_ul reorder-photos-list" id="live_data">




                        </ul>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- /.content -->



<!-- /.content -->


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>  -->

<script>
    $(document).ready(function() {
        $("#save_tutorial").click(function(e) {
            e.preventDefault();
            var form = $("#tutorial_form");
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: form.serialize(),
                success: function(result) {
                    window.location.reload();
                },
                error: function(result) {
                    alert('error');
                }
            });
        });

        $(document).on('click', '.thrash', function() {
            var file = $(this).attr('data-call');
            var id = $(this).attr('id');
          
            $.ajax({
                url: "<?= base_url('api/tutorial/delete_file') ?>",
                type: "POST",
                data: {
                    'name': file,
                    'id': id
                },
                success: function(data) {

                    $('#live_data').html(data + ' File has been successfully removed');
                    
                   setInterval('refreshPage()', 1000);
                    window.location.reload();
                   

                }
            });
        });

        function refreshPage() {
            location.reload(true);
        }
        //display 
        function fetch_gallery(id) {
            $.ajax({
                url: "<?= base_url('api/tutorial/fetch_gallerys') ?>?tutorial_id=" + id,
                method: "GET",
                success: function(data) {
                     debugger;
                    var html = '';
                    for (var i = 0; i < data.data.length; i++) {
                        var file_name = data.data[i].file_name;
                        var original_name = data.data[i].original_name;
                        var slug = data.data[i].slug;
                        var file_id = data.data[i].file_id;
                        html += '<li id="image_li_' + file_id + '" class="col-md-1 my-1 text-center ui-sortable-handle"> <a href="javascript:void(0);" style="float:none;" class="image_link"><img src="' + '<?= base_url() ?>' + 'file/open/' + slug + '" alt="" class="uploaded_img img-thumbnail"></a><span style="color:#1f2d3d;font-size: .50rem;">'+original_name+'</span><button class=" btn-xs btn-danger thrash" id="' + file_id + '" data-call="' + file_name + '"><i class="fa fa-trash"></i></button></li>';

                    }
                    $('#live_data').html(html);
                }
            });
        }
        <?php if (isset($tutorial)) { ?>
            fetch_gallery(<?= $tutorial->id ?>);
        <?php } ?>

        $(function() {
            $("#live_data").sortable();
        });

        function getIdsOfImages() {
            var values = [];
            $('.listitemClass').each(function(index) {
                values.push($(this).attr("id")
                    .replace("imageNo", ""));
            });
            $('#outputvalues').val(values);
        }

        $('.reorder_link').on('click', function() {

            $("ul.reorder-photos-list").sortable({
                tolerance: 'pointer'
            });
            $('.reorder_link').html('save reordering');
            $('.reorder_link').attr("id", "saveReorder");
            $('#reorderHelper').slideDown('slow');
            $('.image_link').attr("href", "javascript:void(0);");
            $('.image_link').css("cursor", "move");

            $("#saveReorder").click(function(e) {

                if (!$("#saveReorder i").length) {
                    // $(this).html('').prepend('<img src="images/refresh-animated.gif"/>');
                    $("ul.reorder-photos-list").sortable('destroy');
                    $("#reorderHelper").html("Reordering Photos").removeClass('light_box').addClass('notice notice_error');

                    var h = [];
                    $("ul.reorder-photos-list li").each(function() {
                        h.push($(this).attr('id').substr(9));
                    });

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('api/tutorial/updateOrder') ?>",
                        data: {
                            ids: " " + h + ""
                        },
                        success: function(data) {
                            console.log(data);
                            window.location.reload();
                            // $("#reorderHelper").html(data);
                        }
                    });
                    return false;
                }
                e.preventDefault();
            });
        });
    });

    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone(".dropzone", {

        acceptedFiles: "image/*",
        autoProcessQueue: true, //if this is "false" then the below #submit_dropzone_form will work.
        uploadMultiple: false,
        parallelUploads: 10,
        dictDefaultMessage: "Drag and drop image files here",
        addRemoveLinks: true,
        dictUploadCanceled: true,
        success: function(data, response) {
            var oldname = $('#img').attr('name');
            $("#img").attr("name", 'gb');
            $("#boatAddForm").append('<input type="hidden" name="ids[]" value="' + response.data.id + '">');
            $("#img").val(response.data.id)
            $(".dz-remove").show();
            $(".dz-message span").html("Click save Changes Button .");
            $(".dz-message").show();


        },
    });

    $('#uploadFile').click(function() {
        myDropzone.processQueue();
    });
</script>