<?php
$id = "";
$batch_id = "";
$session_id = "";
$module_id = "";
$user_id = "";
$course_id = "";
$course_level_id = "";
$status = "";
$start_time = "";
$end_time = "";
$link = "";
$recorded_link = "";
$description = "";
$level = "";
//$status = "1";
$action_url = base_url("scheduled_class/save");
$label = "Create";
$icon="<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($scheduled_classes->id)) :
    $id = $scheduled_classes->id;
    $batch_id = $scheduled_classes->batch_id;
    $session_id = $scheduled_classes->session_id;
    $module_id = $scheduled_classes->module_id;
    $status = $scheduled_classes->status;
    $start_time = $scheduled_classes->start_time;
    $end_time = $scheduled_classes->end_time;
    $link = $scheduled_classes->link;
    $recorded_link = $scheduled_classes->recorded_link;
    $description = $scheduled_classes->description;
    $level = $scheduled_classes->level;
    //$status =  $scheduled_classes->status;
    $action_url = base_url("scheduled_class/save/{$id}");
    $label = "Edit";
    $icon="<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Class
                    <?= $label ?>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('question') ?>">Class</a></li>
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
                    <?= form_open($action_url, ['method' => "post", "id" => "question_option_form"]); ?>
                    <input type="hidden" value="<?= $module_id ?>" id="moduleId">
                    <div class="card-body append_place">
                        <div class="row" id="target" style="display:none;">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course" class="col-form-label-sm">Course</label>
                                    <?php $course_error = set_form_error('course_id', false);
                                    $courses_options = ["" => "Select"];
                                    if ($courses) {
                                        $courses_options = array_reduce($courses, function ($s, $d) {
                                            return ($s + [$d->id => $d->name]);
                                        }, $courses_options);
                                    }
                                    ?>
                                    <?= form_dropdown('course_id', $courses_options, set_value('course_id', $course_id), "class='custom-select custom-select-sm {$course_error}' id='course_id'") ?>
                                    <?= set_form_error('course_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course_level" class="col-form-label-sm">Course levels</label>
                                    <?php $course_level_error = set_form_error('course_level_id', false);
                                    $course_levels_options = ["" => "Select"];
                                    if ($course_levels) {
                                        $course_levels_options = array_reduce($course_levels, function ($s, $d) {
                                            return ($s + [$d->id => $d->level]);
                                        }, $course_levels_options);
                                    }
                                    ?>
                                    <?= form_dropdown('course_level_id', $course_levels_options, set_value('course_level_id', $course_level_id), "class='custom-select custom-select-sm {$course_level_error}' id='course_level_id'") ?>
                                    <?= set_form_error('course_level_id'); ?>
                                </div>

                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="batch" class="col-form-label-sm">Batch</label><span id="toggle-button" class="float-right badge bg-primary"><i class="fa fa-filter" aria-hidden="true"></i></span>
                                    <?php $batch_error = set_form_error('batch_id', false);
                                    $batches_options = ["" => "Select"];
                                    if ($batches) {
                                        $batches_options = array_reduce($batches, function ($s, $d) {
                                            return ($s + [$d->id => $d->code]);
                                        }, $batches_options);
                                    }
                                    ?>
                                    <?= form_dropdown('batch_id', $batches_options, set_value('batch_id', $course_id), "class='custom-select custom-select-sm {$batch_error}' id='batch_id'") ?>
                                    <?= set_form_error('batch_id'); ?>

                                    <!-- <?php $batch_error = set_form_error('batch_id', false);
                                            $batches = ["" => "Select"];
                                            ?>
                                    <?= form_dropdown(
                                        'batch_id',
                                        $batches,
                                        set_value('batch_id', $batch_id),
                                        "class='custom-select custom-select-sm {$batch_error}' id='batch_id'"
                                    ) ?>
                                    <?= set_form_error('batch_id'); ?> -->
                                </div>

                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="module_id" class="col-form-label-sm">Module</label>
                                    <?php
                                    $module_error = set_form_error('module_id', false);
                                    //$modules = ["" => "Select"] + array_column($modules, "name", "id");
                                    $modules = ["" => "Select"];
                                    ?>
                                    <?= form_dropdown('module_id', $modules, set_value('module_id', $module_id), "class='custom-select custom-select-sm {$module_error}' id='module_id'") ?>
                                    <?= set_form_error('module_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="session_id" class="col-form-label-sm">Session Type</label>
                                    <?php
                                    $session_error = set_form_error('session_id', false);
                                    $session_types =array_column($session_types, "type", "id");
                                    ?>
                                    <?= form_dropdown('session_id', $session_types, set_value('session_id', $session_id), "class='custom-select custom-select-sm {$session_error}'") ?>
                                    <?= set_form_error('session_id'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user" class="col-form-label-sm">Teacher</label>

                                    <?php
                                    $user_error = set_form_error('user_id', false);
                                    $teachers = ["" => "Select"];
                                    ?>
                                    <?= form_dropdown('user_id', $teachers, set_value('user_id', $user_id), "class='custom-select custom-select-sm {$user_error}' id='user_id'") ?>
                                    <?= set_form_error('user_id'); ?>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_time" class="col-form-label-sm">Start Time</label>

                                    <?php
                                    $start_error = set_form_error('start_time', false);
                                    $start_times = ["" => "Select"];
                                    ?>
                                    <?= form_dropdown('start_time', $start_times, set_value('start_time', $start_time), "class='custom-select custom-select-sm {$start_error}' id='start_time'") ?>
                                    <?= set_form_error('start_time'); ?>
                                   
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_time" class="col-form-label-sm">End Time</label>
                                    <input type="text" name="end_time" value="<?= set_value('end_time', $end_time) ?>" class="form-control form-control-sm <?= set_form_error('end_time', false); ?>" id='end_time' readonly>
                                    <?= set_form_error('end_time'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="link" class="col-form-label-sm">Link</label>
                                  
                                    <input type="text" name="link" value="<?= set_value('link', $link) ?>" class="form-control form-control-sm <?= set_form_error('link', false); ?>">
                                    <input type="hidden" name="availability_id" style="background:#fff;color:#000" value="" id="avail">
                                    <?= set_form_error('link'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="recorded_link" class="col-form-label-sm">Recorded Link</label>
                                    <input type="text" name="recorded_link" value="<?= set_value('recorded_link', $recorded_link) ?>" class="form-control form-control-sm <?= set_form_error('recorded_link', false); ?>">
                                    <?= set_form_error('recorded_link'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php
                                    $class_status_error = set_form_error('status', false);
                                    $class_status = [
                                        "NOT_STARTED" => "Not Started",
                                        "STARTED" => "Started",
                                        "ENDED" => "Ended",
                                        "CANCELLED" => "Cancelled",
                                        "RESCHEDULED" => "Rescheduled",
                                        "APPROVED" =>"APPROVED"
                                    ];
                                    ?>
                                    <?= form_dropdown('status', $class_status, set_value('status', $status), "class='custom-select custom-select-sm {$class_status_error}'") ?>
                                    <?= set_form_error('status'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="col-form-label-sm">Description</label>
                                    <textarea name="description" class="form-control form-control-sm <?= set_form_error('description', false); ?>" rows="5" placeholder="Description"><?= set_value('description', $description) ?></textarea>
                                    <?= set_form_error('description'); ?>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fa fa-save"></i> Save
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
<script>
    function get_batches(course_id, course_level_id, batch_id) {
        $.ajax({
            url: `<?= base_url("api/batch/get_all") ?>?course_id=${course_id}&course_level_id=${course_level_id}`,
            type: "get",
            dataType: "json",
            success: function(resp) {
                if (resp.code == 200) {
                    let options = resp.data.map((d) => {
                        var is_select = "";

                        if (batch_id != "") {
                            d.id == batch_id ? is_select = "selected" : "";
                        }
                        return `<option value="${d.id}" ${is_select}>${d.code}</option>`;
                    }).join("");

                    $("#batch_id").html(`<option value=''>Select</option> ${options}`);
                } else {
                    $("#batch_id").html("<option value=''>Select</option>");
                }
            }
        });
    }

    // ======== on load change ======== //
    <?php
    if (!empty(set_value('course_id', $course_id))) {
        $c_id = set_value('course_id', $course_id);
        $b_id = set_value('batch_id', $batch_id);
        $c_l_id = set_value('course_level_id', $course_level_id);
    ?>
        get_batches(<?= $c_id . "," . $c_l_id . "," . $b_id; ?>);
    <?php
    }
    ?>

    //*******  ajax call when changed event is fire *******//

    $("body").on("change", "#course_id", function() {
        let course_id = $(this).val();
        let batch_id = $("#batch_id").val();

        if (course_id > 0) {
            get_batches(course_id, batch_id);
        } else {
            $("#batch_id").html("<option value=''>Select</option>");
        }
    });
    $("body").on("change", "#course_level_id", function() {

        let course_level__id = $(this).val();
        let course_id = $("#course_id").val();
        let batch_id = $("#batch_id").val();

        if (course_level__id > 0) {
            get_batches(course_id, course_level__id, batch_id);
        } else {
            $("#batch_id").html("<option value=''>Select</option>");
        }
    });

    function get_modules(batch_id, module_id) {
        $.ajax({
            url: `<?= base_url("api/batch/get/") ?>${batch_id}`,
            type: "get",
            dataType: "json",
            success: function(resp) {
                if (resp.code == 200 && resp.data.id != "" && resp.data.id != null) {
                    $.ajax({
                        url: `<?= base_url("api/module/get_all") ?>?course_id=${resp.data.course_id}`,
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
                                $("#module_id").html("<option value='' selected='selected'>Select</option>");
                            }
                        }
                    });
                } else {
                    $("#module_id").html("<option value='' selected='selected'>Select</option>");
                }
            }
        });
    }
    //get teacher
    function get_teacher(batch_id,user_id) {
      
                    $.ajax({
                        url: `<?= base_url("api/batch_teacher/get_all") ?>?batch_id=${batch_id}`,
                        type: "get",
                        dataType: "json",
                        success: function(resp) {
                            if (resp.code == 200) {
                                var teacherlist = [];
                                let options = resp.data.map((d) => {

                                    if ((teacherlist[d.user_id])==undefined) {

                                        teacherlist[d.user_id] = d.user_id;

                                        
                                        var is_select = "";

                                        if (user_id != "") {
                                            d.user_id == user_id? is_select = "selected" : "";
                                        }
                                        return `<option value="${d.user_id}" ${is_select}>${d.user_fullname}</option>`;
                                    }
                                }).join("");

                                $("#user_id").html(`<option value=''>Select</option> ${options}`);
                            } else {
                                $("#user_id").html("<option value='' selected='selected'>Select</option>");
                            }
                        }
                    });
               
    }
      
    // ======== on load change ======== //
    <?php
    if (!empty(set_value('batch_id', $batch_id))) {
        $b_id = set_value('batch_id', $batch_id);
        $u_id = set_value('user_id', $user_id);
    ?>
        get_modules(<?= $b_id . "," . $u_id; ?>);
    <?php
    }
    ?>

    //*******  ajax call when changed event is fire *******//
//selected teacher then display start time
    $("body").on("change", "#batch_id", function() {
        let batch_id = $(this).val();
        let user_id = $("#user_id").val();
      

        if (batch_id > 0) {
            get_teacher(batch_id, user_id);
        } else {
            $("#user_id").html("<option value='' selected='selected'>Select</option>");
        }
    });
     //get availability
    function get_availability(user_id) {
        $.ajax({
            url: `<?= base_url("api/user/get/") ?>?id=${user_id}`,
            type: "get",
            dataType: "json",
            success: function(resp) {
                if (resp.code == 200 && resp.data.id != "" && resp.data.id != null) {

                    $.ajax({
                        url: `<?= base_url("api/user/availability/get_all") ?>?order=DESC&&user_id=${resp.data.id}`,
                        type: "get",
                        dataType: "json",
                        success: function(resp) {
                            if (resp.code == 200) {
                                let start_time = resp.data.map((d) => {
                                function zeros(n) {
                                    if (n <= 9) {
                                        return "0" + n;
                                    }
                                    return n
                                }
                                    var today = new Date();
                                    var date = zeros(today.getFullYear())+'-'+zeros((today.getMonth()+1))+'-'+zeros(today.getDate());
                                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                                    var CurrentDateTime = date+' '+time;
                                 // alert(moment(d.from).format('DD-MM-YYYY')+'-'+moment(CurrentDateTime).format('DD-MM-YYYY'));
                                    var is_select = "";
                                    if((d.from>=CurrentDateTime) && (d.status!=0)){
                                        
                                    if (user_id != "") {
                                        d.user_id == user_id ? is_select = "selected" : "";
                                    }
                                    var date = new Date(d.from);
                                    var endtime=new Date(date.setMinutes(date.getMinutes()+40)).toLocaleString("sv-SE");
                                    return `<option data-end="${moment(endtime).format('DD-MM-YYYY hh:mm a')}" data-avail="${d.id}" value="${d.from}" ${is_select}>${moment(d.from).format('DD-MM-YYYY hh:mm a')}</option>`;
                                }
                                }).join("");

                             
                                $("#start_time").html(`<option value=''>Select</option> ${start_time}`);
                                $("#start_time").trigger("change");
                            
                            } else {
                                $("#start_time").html("<option value='' selected='selected'>Select</option>");
                              
                            }
                        }
                    });
                } else {
                    $("#start_time").html("<option value='' selected='selected'>Select</option>");
                  
                }
            }
        });
    }
    
    // ======== on load change ======== //
    <?php
    if (!empty(set_value('batch_id', $module_id))) {
        $b_id = set_value('batch_id', $batch_id);
        $m_id = set_value('module_id', $module_id);
    ?>
        get_modules(<?= $b_id . "," . $m_id; ?>);
    <?php
    }
    ?>

    $("body").on("change", "#start_time", function() {
       
       $("#end_time").val($(this).find(':selected').data('end'));
      // alert($(this).find(':selected').data('avail'))
       $("#avail").val($(this).find(':selected').data('avail'));
   });

    //*******  ajax call when changed event is fire *******//
//selected teacher then display start time
    $("body").on("change", "#batch_id", function() {
        let batch_id = $(this).val();
        let module_id = $("#module_id").val();
       
        if (batch_id > 0) {
            get_modules(batch_id, module_id);
        } else {
            $("#module_id").html("<option value='' selected='selected'>Select</option>");
        }
    });
    <?php
    if (!empty(set_value('user_id', $user_id))) {
        $u_id = set_value('user_id', $user_id);

    ?>
        get_availability(<?= $u_id; ?>);
    <?php
    }
    ?>

    $("body").on("change", "#user_id", function() {
        let user_id = $(this).val();
        if (user_id > 0) {
            get_availability(user_id);
        } else {
            $("#start_time").html("<option value='' selected='selected'>Select</option>");
           
        }
    });
//display end time
    
    $("body").on("onblur", "#start_time", function() {
       
       $("#end_time").val($(this).find(':selected').data('end'));
   });
//courses on of
    $('#toggle-button').click(function() {
        $("#target").toggle();
        // $(this).text($(this).text()=="OFF"?"ON":"OFF");
    });

    $(function () {
        $('.datetime').datetimepicker({
            format: 'DD-M-YYYY hh:mm A'
        });

    });

</script>