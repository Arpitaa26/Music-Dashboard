<?php
$id = "";
$action_url = base_url("availability/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($availability)) :
    $final_availability = $availability;

    $action_url = base_url("availability/save/{$id}");
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Availability <?= $label ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('module') ?>">Availability</a></li>
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
                        <?php if (isset($availability[0]->user_id)) : $user_id = $availability[0]->user_id; ?>
                            <form action="<?= base_url('user_availability/delete_availability/'.$user_id); ?>/" method="POST">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>" class="form-control form-control-sm ">
                                            <input type="date" name="from" id="from" value="" class="form-control form-control-sm ">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                           
                                            <input type="date" name="to" id="to" value="" class="form-control form-control-sm ">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <!-- <a href="javascript:void(0)" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger float-right" title="Delete" data-toggle="tooltip">Reset</i></a> -->
                                        <button type="submit" class="btn btn-success btn-sm">Reset</button>
                                                 
                                    </div>
                                </div>
                            </form>
                        <?php endif ?>
                    </div>

                    <div class="card-body append_place">


                        <!-- Main content -->
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Teacher Availability Time Table</h3>

                                        </div>

                                        <div class="box-body">
                                            <table class="table table-stripped">
                                                <thead>
                                                    <tr>
                                                        <th class="text text-center">Monday</th>
                                                        <th class="text text-center">Tuesday</th>
                                                        <th class="text text-center">Wednesday</th>
                                                        <th class="text text-center">Thursday</th>
                                                        <th class="text text-center">Friday</th>
                                                        <th class="text text-center">Saturday</th>
                                                        <th class="text text-center">Sunday</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text text-center">
                                                            <?php

                                                            if (isset($final_availability)) :
                                                                foreach ($final_availability as $day) :
                                                                    if (date('D', strtotime($day->from)) === 'Mon') :
                                                            ?>
                                                                        <div class="attachment-block clearfix" style="padding:7px;">

                                                                            <strong> <a href="<?= base_url("user_availability/edit/$day->id") ?>" title="Edit"><?= date('d-m-Y H:i A', strtotime($day->from)); ?></a> </strong>
                                                                            <a href="<?= base_url("user_availability/delete/$day->id") ?>" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger float-right" title="Delete" data-toggle="tooltip">x</i></a>
                                                                        </div>
                                                            <?php
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                            ?>
                                                        </td>
                                                        <td class="text text-center">

                                                            <?php
                                                            if (isset($final_availability)) :
                                                                foreach ($final_availability as $day) :
                                                                    if (date('D', strtotime($day->from)) === 'Tue') :

                                                            ?>


                                                                        <div class="attachment-block clearfix" style="padding:7px;">

                                                                            <strong> <a href="<?= base_url("user_availability/edit/$day->id") ?>" title="Edit"><?= date('d-m-Y H:i A', strtotime($day->from)); ?></a> </strong>
                                                                            <a href="<?= base_url("user_availability/delete/$day->id") ?>" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger float-right" title="Delete" data-toggle="tooltip">x</i></a>
                                                                        </div>
                                                            <?php
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                            ?>





                                                        </td>
                                                        <td class="text text-center">

                                                            <?php
                                                            if (isset($final_availability)) :
                                                                foreach ($final_availability as $day) :
                                                                    if (date('D', strtotime($day->from)) === 'Wed') :
                                                            ?>

                                                                        <div class="attachment-block clearfix" style="padding:7px;">

                                                                            <strong> <a href="<?= base_url("user_availability/edit/$day->id") ?>" title="Edit"><?= date('d-m-Y H:i A', strtotime($day->from)); ?></a> </strong>
                                                                            <a href="<?= base_url("user_availability/delete/$day->id") ?>" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger float-right" title="Delete" data-toggle="tooltip">x</i></a>
                                                                        </div>
                                                            <?php
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                            ?>


                                                        </td>
                                                        <td class="text text-center">

                                                            <?php
                                                            if (isset($final_availability)) :
                                                                foreach ($final_availability as $day) :
                                                                    if (date('D', strtotime($day->from)) === 'Thu') :
                                                            ?>

                                                                        <div class="attachment-block clearfix" style="padding:7px;">

                                                                            <strong> <a href="<?= base_url("user_availability/edit/$day->id") ?>" title="Edit"><?= date('d-m-Y H:i A', strtotime($day->from)); ?></a> </strong>
                                                                            <a href="<?= base_url("user_availability/delete/$day->id") ?>" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger float-right" title="Delete" data-toggle="tooltip">x</i></a>
                                                                        </div>
                                                            <?php
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                            ?>




                                                        </td>
                                                        <td class="text text-center">

                                                            <?php
                                                            if (isset($final_availability)) :
                                                                foreach ($final_availability as $day) :
                                                                    if (date('D', strtotime($day->from)) === 'Fri') :
                                                            ?>


                                                                        <div class="attachment-block clearfix" style="padding:7px;">

                                                                            <strong> <a href="<?= base_url("user_availability/edit/$day->id") ?>" title="Edit"><?= date('d-m-Y H:i A', strtotime($day->from)); ?></a> </strong>
                                                                            <a href="<?= base_url("user_availability/delete/$day->id") ?>" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger float-right" title="Delete" data-toggle="tooltip">x</i></a>
                                                                        </div>
                                                            <?php
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                            ?>




                                                        </td>
                                                        <td class="text text-center">

                                                            <?php
                                                            if (isset($final_availability)) :
                                                                foreach ($final_availability as $day) :
                                                                    if (date('D', strtotime($day->from)) === 'Sat') :

                                                            ?>

                                                                        <div class="attachment-block clearfix" style="padding:7px;">

                                                                            <strong> <a href="<?= base_url("user_availability/edit/$day->id") ?>" title="Edit"><?= date('d-m-Y H:i A', strtotime($day->from)); ?></a> </strong>
                                                                            <a href="<?= base_url("user_availability/delete/$day->id") ?>" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger float-right" title="Delete" data-toggle="tooltip">x</i></a>
                                                                        </div>
                                                            <?php
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                            ?>






                                                        </td>
                                                        <td class="text text-center">

                                                            <?php
                                                            if (isset($final_availability)) :
                                                                foreach ($final_availability as $day) :
                                                                    if (date('D', strtotime($day->from)) === 'Sun') :
                                                            ?>


                                                                        <div class="attachment-block clearfix" style="padding:7px;">

                                                                            <strong> <a href="<?= base_url("user_availability/edit/$day->id") ?>" title="Edit"><?= date('d-m-Y H:i A', strtotime($day->from)); ?></a> </strong>
                                                                            <a href="<?= base_url("user_availability/delete/$day->id") ?>" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger float-right" title="Delete" data-toggle="tooltip">x</i></a>
                                                                        </div>
                                                            <?php
                                                                    endif;
                                                                endforeach;
                                                            endif;
                                                            ?>


                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </section>



                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">


                    </div>

                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->