<?php
$id = "";
$user_id = "";
$task_title = "";
$status = "1";
$task_type="";
$task_date="";
$description = "";
$action_url = base_url("task/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
$comment_url = base_url("task/task_comments");
if (isset($task->id)) :
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
    $id = $task->id;
    $task_title = $task->task_title;
    $task_type = $task->task_type;
    $user_id = $task->user_id;
    $task_date=$task->task_date;
    $status = $task->status;
    $description = $task->description;
    $action_url = base_url("task/save/{$id}");

endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tasks <?= $label ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('task') ?>">Task</a></li>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Task" class="col-form-label-sm">Task Title</label>
                                    <input type="text" name="task_title" id="task_title" value="<?= set_value('task_title', $task_title) ?>" class="form-control form-control-sm <?= set_form_error('task_title', false); ?>" placeholder="Task name">
                                    <?= set_form_error('task_title'); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="col-form-label-sm">Description</label>
                                    <textarea id="description" name="description" class="form-control form-control-sm <?= set_form_error('description', false); ?>" rows="6" placeholder="Description"><?= set_value('description', $description) ?></textarea>
                                    <?= set_form_error('description'); ?>
                                </div>
                            </div>
                           
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="assign_name" class="col-form-label-sm">Assign</label>
                               <?php
                                    $user_error = set_form_error('user_id', false);
                                    $users = ["" => "Select"] + array_column($users, "full_name", "id");
                                    ?>
                                    <?= form_dropdown('user_id',  $users, set_value('user_id', $user_id), "class='custom-select custom-select-sm {$user_error}'") ?>
                                    <?= set_form_error('user_id'); ?>
                                  

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label-sm">Task Type</label>
                                        <?php $task_type_error = set_form_error('task_type', false); ?>
                                        <?= form_dropdown('task_type', ['SUPPORT' => 'SUPPORT'], set_value('task_type', $task_type), "class='custom-select custom-select-sm {$task_type_error}'") ?>
                                        <?= set_form_error('task_type'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date" class="col-form-label-sm">Task Date</label>
                                        <?php $task_date_error = set_form_error('task_date', false); ?>
                                        <input type="date" name="task_date" id="task_date" value="<?= set_value('task_date', $task_date) ?>" class="form-control form-control-sm <?= set_form_error('task_date', false); ?>" placeholder="Task Date">
                                        <?= set_form_error('task_date'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label-sm">Status</label>
                                        <?php $status_error = set_form_error('status', false); ?>
                                        <?= form_dropdown('status', ['' => 'Select','0' => 'InActive','1' => 'Incomplete', '2' => 'Completed'], set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
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
                    <div class="card-footer">
                    <?= form_open($comment_url , ['method' => "post" ,"id" => "comment_form"]); ?>
                            <div class="input-group">
                                <input type="hidden" name="task_id" value="<?=isset($task)?$task->id:''?>">
                                <input type="hidden" name="user_id" value=" <?= $this->http->session_get("id") ?>">
                                <input type="text" name="task_comment" placeholder="Type Comments ..." class="form-control">
                                <span class="input-group-append">
                                <button type="submit" id="save_comment" class="btn btn-primary">Send</button>
                                </span>
                            </div>
                     <?= form_close() ?>

                <div class="direct-chat-messages">
                    <?php
                    

                    if (isset($task_comments)) {
                       // pp($task_comments);
                        foreach ($task_comments as $key => $row) {
                            if($row->user_id==$this->http->session_get("id")){
                    ?>
                                <div class="direct-chat-msg">
                                    <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left"><?=$row->full_name?></span>
                                    <span class="direct-chat-timestamp float-right"><?=$row->created_on?></span>
                                    </div>

                                    <!-- <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image"> -->

                                    <div class="direct-chat-text">
                                    <?=$row->task_comment?>
                                    </div>

                                </div>
                            <?php }else{?>
                                    <div class="direct-chat-msg right">
                                        <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name float-right"><?=$row->full_name?></span>
                                        <span class="direct-chat-timestamp float-left"><?=$row->created_on?></span>
                                        </div>

                                        <!-- <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image"> -->

                                        <div class="direct-chat-text">
                                        <?=$row->task_comment?>
                                    </div>

                        </div>
                        <?php 
                            }
                        }
                    }
                        ?>

                       

                    </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
