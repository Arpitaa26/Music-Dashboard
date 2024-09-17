<?php
$id = "";
$course_id = "";
$module_id = "";
$type = "";
$marks = "";
$name = "";
$hints = "";
$category = "";
$option = "";
$is_correct = "";
$q_status = "1";
$o_status = "1";
$action_url = base_url("question/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($data->id)) :
    $id = $data->id;
    $course_id = $data->course_id;
    $module_id = $data->module_id;
    $type = $data->type;
    $name = $data->name;
    $marks = $data->marks;
    $hints = $data->hints;
    $category = $data->category;
    $q_status = $data->status;
    $action_url = base_url("question/save/{$id}");
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;


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
                    <li class="breadcrumb-item"><a href="<?= base_url('question') ?>">Question</a></li>
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
                    <?= form_open_multipart($action_url, ['method' => "post", "id" => "question_form"]); ?>
                    <input type="hidden" value="<?= $module_id ?>" id="moduleId">
                    <div class="card-body append_place">

                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course" class="col-form-label-sm">Course</label>

                                    <?php
                                    $course_error = set_form_error('course_id', false);
                                    $courses = ["" => "Select"] + array_column($courses, "name", "id");
                                    ?>

                                    <?= form_dropdown('course_id', $courses, set_value('course_id', $course_id), "class='custom-select custom-select-sm {$course_error}' id='course_id'") ?>
                                    <?= set_form_error('course_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="module" class="col-form-label-sm">Module</label>

                                    <?php
                                    $module_error = set_form_error('module_id', false);
                                    $modules = ["" => "Select"];
                                    ?>

                                    <?= form_dropdown('module_id', $modules, set_value('module_id', $module_id), "class='custom-select custom-select-sm {$module_error}' id='module_id'") ?>
                                    <?= set_form_error('module_id'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class="col-form-label-sm">Question Type</label>
                                    <?php
                                    $type_error = set_form_error('type', false);
                                    $type_array =
                                        [
                                            '' => 'Select',
                                            'INPUT' => 'INPUT',
                                            'SINGLE_SELECT' => 'SINGLE_SELECT',
                                            'MULTI_SELECT' => 'MULTI_SELECT',
                                            'DATE' => 'DATE',
                                            'FILE' => 'FILE'
                                        ];
                                    ?>
                                    <?= form_dropdown('type', $type_array, set_value('type', $type), "id='type' class='custom-select custom-select-sm {$type_error}'") ?>
                                    <?= set_form_error('type'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label-sm">Marks</label>
                                    <input type="text" name="marks" value="<?= set_value('marks', $marks) ?>" class="form-control form-control-sm <?= set_form_error('marks', false); ?>" placeholder="Marks">
                                    <?= set_form_error('marks'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hints" class="col-form-label-sm">Hints</label>
                                    <input type="text" name="hints" value="<?= set_value('hints', $hints) ?>" class="form-control form-control-sm <?= set_form_error('hints', false); ?>" placeholder="Question Hints">
                                    <?= set_form_error('hints'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php $status_error = set_form_error('q_status', false); ?>
                                    <?= form_dropdown('q_status', ['' => 'Select', '1' => 'Active', '0' => 'Inactive'], set_value('q_status', $q_status), "class='custom-select custom-select-sm {$status_error}'") ?>
                                    <?= set_form_error('q_status'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Category</label>
                                    <?php $category_error = set_form_error('category', false); ?>
                                    <?= form_dropdown('category', ['' => 'Select', 'COURSE_MODULE' => 'COURSE_MODULE', 'BATCH' => 'BATCH', 'BATCH_STUDENT' => 'BATCH_STUDENT'], set_value('category', $category), "class='custom-select custom-select-sm {$category_error}' id='category'") ?>
                                    <?= set_form_error('category'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-form-label-sm">Question Name</label>
                                    <textarea type="text" name="name" rows="3" class="form-control form-control-sm <?= set_form_error('name', false); ?>" placeholder="Question Name"><?= set_value('name', $name) ?></textarea>
                                    <?= set_form_error('name'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row" id="addFile">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-form-label-sm">Question File</label>
                                    <input type="file" name="file"  accept=".png, .jpg, .jpeg, .gif, .svg,.pdf"/>  
                                    <!-- <input type="hidden" name="category_file" value="" class="form-control form-control-sm" id="category_file">
                                 -->
                                   
                                </div>
                            </div>

                        </div>
                        

                        <div class="options_table">
                            <?php //pp($data["question_option"]);
                            if (isset($data->question_option)) {
                                foreach ($data->question_option as $key => $row) :

                                    // pp($row);
                            ?>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="option" class="col-form-label-sm"> <span class="handle badge"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>
                                                    Option</label>

                                                <input type="hidden" value="<?= (isset($row->question_id) ? $row->question_id : '') ?>" class="question_id" data-id="<?= (isset($row->question_id) ? $row->question_id : '') ?>">

                                                <input type="hidden" class="s" name="option_id[]" id="<?= (isset($row->id) ? 'option_' . $row->id : '') ?>" value="<?= set_value('option_id[' . $key . ']', (isset($row->id) ? $row->id : '')) ?>" class="form-control form-control-sm">
                                                <input type="text" name="option[]" value="<?= set_value('option[' . $key . ']', $row->option) ?>" class="form-control form-control-sm <?= set_form_error('option[' . $key . ']', false); ?>" placeholder="Option">
                                                <?= set_form_error('option[' . $key . ']'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="is_correct" class="col-form-label-sm">Correct</label>
                                                <?php $is_correct_error = set_form_error('is_correct[' . $key . ']', false); ?>
                                                <?= form_dropdown('is_correct[' . $key . ']', ['' => 'Select', '1' => 'Yes', '0' => 'No'], set_value('is_correct[' . $key . ']', $row->is_correct), "class='custom-select custom-select-sm {$is_correct_error}'") ?>
                                                <?= set_form_error('is_correct[' . $key . ']'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="status" class="col-form-label-sm">Status</label>
                                                <?php $status_error = set_form_error('o_status[' . $key . ']', false); ?>
                                                <?= form_dropdown('o_status[]', ['' => 'Select', '1' => 'Active', '0' => 'Inactive'], set_value('o_status[' . $key . ']', $row->status), "class='custom-select custom-select-sm {$status_error}'") ?>
                                                <?= set_form_error('o_status[' . $key . ']'); ?>
                                            </div>
                                        </div>
                                        <?php
                                        if ($key != 0) {
                                        ?>
                                            <div class="col-md-1">
                                                <div class="form-group mt-4 pt-3">
                                                    <button type="button" id="<?= (isset($row->id) ? $row->id : '') ?>" class="btn btn-xs btn-danger remove_btn" title="Remove"><i class='fa fa-times'></i></button>
                                                </div>
                                            </div>
                                        <?php }; ?>
                                    </div>
                                <?php
                                endforeach;
                                ?>
                            <?php }  ?>
                        </div>


                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" class="btn btn-sm btn-primary float-left" id="addModule">Add New</button>

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


        var count = 0;
        $("#addModule").click(function() {
            count += 1;
            let html = `<div class="row addmodule">
            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="option" class="col-form-label-sm"> Option</label>
                                    <input type="text" name="option[` + count + `]" value="" class="form-control form-control-sm " placeholder="Option">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="is_correct" class="col-form-label-sm">Correct</label>
                                    <select name="is_correct[` + count + `]" class="custom-select custom-select-sm ">
                                        <option value="" selected="selected">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <select name="o_status[` + count + `]" class="custom-select custom-select-sm ">
                                        <option value="">Select</option>
                                        <option value="1" selected="selected">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group mt-4 pt-3">
                                    <button  type="button"  id="` + count + `"class="btn btn-xs btn-danger remove_btn" title="Remove"><i class='fa fa-times'></i></button>
                                </div>
                            </div>
                        </div>`;

            $(".append_place").append(html);
        });

        $("#question_form").on('click', ".remove_btn", function() {
            $(this).parent().parent().parent().remove();
            var id = $(this).attr('id');
            //alert(id);
            $.ajax({
                url: `<?= base_url("api/question_option/delete/") ?>${id}`,
                type: "get",
                dataType: "json",
                success: function(resp) {
                    // $('#message').html(' File has been successfully removed');


                }
            });
        });

        function get_module(course_id, module_id) {
            $.ajax({
                url: `<?= base_url("api/module/get_all") ?>?course_id=${course_id}`,
                type: "get",
                dataType: "json",
                success: function(resp) {
                    if (resp.code == 200) {
                        let options = resp.data.map((d) => {
                            var is_select = "";

                            if (module_id != "") {
                                d.id == module_id ? is_select = "selected" : "";
                            }
                            return `<option value="${d.id}" ${is_select}>${d.name}</option>`;
                        }).join("");

                        $("#module_id").html(`<option value=''>Select</option> ${options}`);
                    } else {
                        $("#module_id").html("<option value=''>Select</option>");
                    }
                }
            });
        }

        <?php
        if (!empty(set_value('course_id', $course_id))) {
            $c_id = set_value('course_id', $course_id);
            $m_id = set_value('module_id', $module_id);
        ?>
            get_module(<?= $c_id . "," . $m_id; ?>);
        <?php
        }
        ?>

        $("body").on("change", "#course_id", function() {
            let course_id = $(this).val();
            let module_id = $("#moduleId").val();

            if (course_id > 0) {
                get_module(course_id, module_id);
            } else {
                $("#module_id").html("<option value=''>Select</option>");
            }
        });
        // $('#type').change(function() {
        let type = $("#type").val();
        if (type == 'SINGLE_SELECT') {
            $("#addModule").show();
        } else if (type == 'MULTI_SELECT') {
            $("#addModule").show();
        }else if (type == 'FILE') {
            $("#addFile").show();
        } else {
            $("#addFile").hide();
            $("#addModule").hide();
            texts = $('.addmodule');
            // hide everything
            texts.each(function() {
                $(this).hide();
            });
        }
        $("body").on("change", "#type", function() {
            let type = $(this).val();

            
            $("#addFile").hide();
            $("#addModule").hide();
            $('.addmodule').remove();
            
            if (type == 'SINGLE_SELECT') {
                $("#addModule").show();
            } else if (type == 'MULTI_SELECT') {
                $("#addModule").show();
            } else if (type == 'FILE') {
                $("#addFile").show();
            }
        });
     


        $(function() {
            $(".options_table").sortable({
                revert: true,
                update: function(event, ui) {

                    var h = [];
                    $("input.s").each(function() {
                        h.push($(this).attr('id').substr(7));
                    });

                    var questions_id = $('.question_id').val();
                    //  alert(questions_id)

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('api/question_option/updateOption'); ?>",
                        data: {
                            ids: " " + h + ""
                        },
                        success: function() {
                            window.location.reload();
                        }
                    });
                }
            });

        });

    });
</script>