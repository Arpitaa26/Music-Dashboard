<?php
$id = "";
$user_id = "";
$status = "1";
$form = "";
$to = "";
$user_fullname = "";
$action_url = base_url("user_availability/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($users[0]->id)) :
    $user_id = $users[0]->id;
    $action_url = base_url("user_availability/save/{$user_id}");
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
                    <li class="breadcrumb-item"><a href="<?= base_url('user_availability/save/' . $user_id) ?>">Teacher's Availability</a></li>
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
                                    <?php if (isset($users)) { ?>
                                        <input type="hidden" name="user_id" value="<?= set_value('user_id', $users[0]->id) ?>" class="form-control form-control-sm">
                                        <input type="text" name="user" value="<?= set_value('user_id', $users[0]->full_name) ?>" class="form-control form-control-sm <?= set_form_error('user_id', false); ?>" readonly>
                                        <?= set_form_error('user_id'); ?>

                                    <?php    } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="teacher">
                            <?php
                            if (isset($teacher)) {
                               
                                foreach ($teacher as $key => $row) :
                                 
                                    $from = date("Y-m-d");
                                    if ($row->from >= $from && $row->status==1) {
                            ?>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Form" class="col-form-label-sm">Form</label>
                                                <input type="hidden" name="status[<?= $key ?>]" value="1" class="form-control form-control-sm">
                                                <input type="text" name="from[<?= $key ?>]" value="<?= set_value('from[' . $key . ']', $row->from) ?>" class="form-control form-control-sm <?= set_form_error('form[' . $key . ']', false); ?>" readonly>
                                                <?= set_form_error('from[' . $key . ']'); ?>

                                            </div>
                                        </div>

                                        <div class="col-md-5" id="teachers">
                                            <div class="form-group">
                                                <label for="user_id" class="col-form-label-sm">To</label>

                                                <input type="text" name="to[<?= $key ?>]" value="<?= set_value('to[' . $key . ']', $row->to) ?>" class="form-control form-control-sm <?= set_form_error('to[' . $key . ']', false); ?>" readonly>
                                                <?= set_form_error('to[' . $key . ']'); ?>

                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group mt-4 pt-3">
                                            <button type="button" id="<?= (isset($row->id) ? $row->id : '') ?>" class="btn btn-xs btn-danger remove_btn" title="Remove"><i class='fa fa-times'></i></button>
                                              
                                            </div>
                                        </div>
                            <?php
                                    }
                                endforeach;
                            }
                            ?>

                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" class="btn btn-sm btn-primary float-left" id="addAvailability">Add New</button>

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


<script>
    $(document).ready(function() {

      
        var count = $('#addAvailability div').length+1;
        $("#addAvailability").click(function() {
            count++;
           
            let html = `<div class="row">
            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="From" class="col-form-label-sm">Form</label>
                                    <input type="datetime-local" name="from[]" value="<?= set_value('from[]', $form) ?>" class="form-control form-control-sm <?= set_form_error('from[]', false); ?>" id='from' min="<?=date("Y-m-d h:i"); ?>">
                                    <?= set_form_error('from[]'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="TO" class="col-form-label-sm">To</label>
                                    <input type="datetime-local" name="to[]" value="<?= set_value('to[]', $to) ?>" class="form-control form-control-sm <?= set_form_error('to[]', false); ?>" id='to'>
                                    <?= set_form_error('to[]'); ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <select name="status[]" class="custom-select custom-select-sm ">
                                        <option value="">Select</option>
                                        <option value="1" selected="selected">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group mt-4 pt-3">
                                    <button  type="button" class="btn btn-xs btn-danger remove_btn" title="Remove"><i class='fa fa-times'></i></button>
                                </div>
                            </div>
                        </div>`;

            $(".append_place").append(html);
        });

        $("#user_availability").on('click', ".remove_btn", function() {
            $(this).parent().parent().parent().remove();
            var id = $(this).attr('id');
           // alert(id);
            if (id) {
                $.ajax({
                    url: `<?= base_url("api/user/availability/delete/") ?>${id}`,
                    type: "post",
                    dataType: "json",
                    success: function(resp) {
                      //  console.log(resp);
                      window.location.reload();
                    }
                });
            }
        });
        $("#user_availability").on('click', ".save", function() {
           
            // var form = $('#form').val('id');
            // var to = $('#to').val('id');
            const fromDateInput = document.getElementById("from");
            const toDateInput = document.getElementById("to");

            const fromDateValue = new Date(fromDateInput.value);
            const toDateValue = new Date(toDateInput.value);

            // Check if both input fields are not empty
            if (!fromDateValue || !toDateValue) {
            alert("Please enter both From and To dates.");
            return false;
            }

            // Check if the "from" date is later than the "to" date
            if (fromDateValue > toDateValue) {
            alert("From Date cannot be later than To Date.");
            return false;
            }

            // Form is valid, allow submission
            return true;
        });
    });
</script>