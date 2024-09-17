<?php

$action_url = base_url("price/save");
$label = "Create";
$icon="<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (!empty($price)) {
$id = $price[0]->course_id;
$action_url = base_url("price/save/{$id}");
$label = "Edit";
$icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Price <?= $label ?>
</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Price') ?>">Price</a></li>
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
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Price</h3>
                                </div>
                                <div class="card-body table-responsive p-2">
                                <?php if (empty($price_by_country)) { ?>
                                    <table class="table text-center">
                                    <?= form_open($action_url, ['method' => "post", "id" => "priceForm"]); ?>
                                        <tbody>
                                       
                                            <tr>
                                                <th></th>
                                            <?php
                                            $colspan_level = sizeof($session_types);

                                            if (isset($course_levels)) {
                                                foreach ($course_levels as $key => $row) {
                                            ?>
                                                <td colspan="<?=$colspan_level ?>"><?=$row->level;?></td>
                                            <?php

                                                }
                                            }
                                            ?>
                                            </tr>
                                            <tr>
                                                
                                                <th></th>
                                            <?php
                                           
                                            if (isset($session_types)) {
                                                foreach ($course_levels as $level_key => $level_row) {
                                                    foreach ($session_types as $session_key => $session_row) {
                                                        ?>
                                                        <td><?=$session_row->type;?></td>
                                                    <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            </tr>
                                            <tr>
                                            <?php
                                            $fieldcnt = -1;
                                            if (isset($countries)) {
                                                foreach ($countries as $country_key => $country_row) {
                                                    ?>
                                                    <tr>
                                                        <th><?=$country_row->country_name; ?></th>
                                                        <?php
                                                        foreach ($course_levels as $level_key => $level_row) {
                                                            foreach ($session_types as $session_key => $session_row) {
                                                                $fieldcnt++;
                                                            
                                                        ?>
                                                        <td>
                                                            <input style="width:75px;" type="text" name="cost_per_class[<?=$fieldcnt; ?>]" value="">
                                                            <input type="hidden" name="course_id[<?=$fieldcnt; ?>]" value="<?=isset($course_id)?$course_id:''; ?>">
                                                            <input type="hidden" name="session_type_id[<?=$fieldcnt; ?>]" value="<?=$session_row->id; ?>">
                                                            <input type="hidden" name="course_level_id[<?=$fieldcnt; ?>]" value="<?=$level_row->id; ?>">
                                                            <input type="hidden" name="country_id[<?=$fieldcnt; ?>]" value="<?=$country_row->id; ?>">
                                                        </td>
                                                        
                                                    
                                                    <?php
                                                            
                                                            }
                                                        }
                                                    ?>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </tr>
                                            <td colspan="<?=(sizeof($course_levels)*sizeof($session_types) + 1) ?>">
                                                <div class="card-footer">
                                                 <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fa fa-save"></i> Save Changes</button>
                                                </div>
                                            </td>
                                        </tbody>
                                        <?= form_close() ?>
                                    </table>
                                    <?php  } else{?>

                                        <table class="table text-center">
                                    <?= form_open($action_url, ['method' => "post", "id" => "priceForm"]); ?>
                                        <tbody>
                                       
                                            <tr>
                                                <th></th>
                                            <?php
                                            $colspan_level = sizeof($session_types);

                                            if (isset($course_levels)) {
                                                foreach ($course_levels as $key => $row) {
                                            ?>
                                                <td colspan="<?=$colspan_level ?>"><?=$row->level;?></td>
                                            <?php

                                                }
                                            }
                                            ?>
                                            </tr>
                                            <tr>
                                                
                                                <th></th>
                                            <?php
                                           
                                            if (isset($session_types)) {
                                                foreach ($course_levels as $level_key => $level_row) {
                                                    foreach ($session_types as $session_key => $session_row) {
                                                        ?>
                                                        <td><?=$session_row->type;?></td>
                                                    <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            </tr>
                                            <tr>
                                            <?php
                                            $fieldcnt = -1;
                                            if (isset($countries)) {
                                                foreach ($countries as $country_key => $country_row) {
                                                    ?>
                                                    <tr>
                                                        <th><?=$country_row->country_name; ?></th>
                                                        <?php
                                                        foreach ($course_levels as $level_key => $level_row) {
                                                            foreach ($session_types as $session_key => $session_row) {
                                                                // foreach ($price_by_country[$country_row->id] as $price_key => $price_row) {
                                                                    $fieldcnt++;
                                                            //   pp($price_row);
                                                        ?>
                                                        <td>
                                                            <input style="width:75px;" type="text" name="cost_per_class[<?=$fieldcnt; ?>]" value="<?=isset($price_by_country[$country_row->id][$level_row->id][$session_row->id])?$price_by_country[$country_row->id][$level_row->id][$session_row->id]["cost_per_class"]:''?>">
                                                            <input type="hidden" name="course_id[<?=$fieldcnt; ?>]" value="<?=isset($course_id)?$course_id:''; ?>">
                                                            <input type="hidden" name="session_type_id[<?=$fieldcnt; ?>]" value="<?=isset($session_row->id)?$session_row->id:''; ?>">
                                                            <input type="hidden" name="course_level_id[<?=$fieldcnt; ?>]" value="<?=isset($level_row->id)?$level_row->id:''; ?>">
                                                            <input type="hidden" name="country_id[<?=$fieldcnt; ?>]" value="<?=isset($country_row->id)?$country_row->id:''; ?>">
                                                        </td>
                                                        
                                                    
                                                    <?php
                                                                // }
                                                            }
                                                        }
                                                    ?>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </tr>
                                            <td colspan="<?=(sizeof($course_levels)*sizeof($session_types) + 1) ?>">
                                                <div class="card-footer">
                                                 <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fa fa-save"></i> Save Changes</button>
                                                </div>
                                            </td>
                                        </tbody>
                                        <?= form_close() ?>
                                    </table>


                                        <?php  }?>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
               
       
</section>
<!-- /.content -->
