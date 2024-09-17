<?php
$id = "";
$course_id = "";
$course_level_id = "";
$name = "";
$status = "1";
$description = "";
$action_url = base_url("module/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($users->id)) :

    $availability = $users->availability;
    $final_availability = json_decode($availability);





    $action_url = base_url("module/save/{$id}");
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Module <?= $label ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('module') ?>">Module</a></li>
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

                    <div class="card-body append_place">


                        <!-- Main content -->
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Teacher Time Table</h3>
                                            <div class="box-tools pull-right"></div>
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
                                                        
                                                            if(isset($final_availability)):
                                                            foreach ($final_availability as $day) :
                                                                if (date('D', strtotime($day->from)) === 'Mon') :
                                                            ?>


                                                                    <div class="attachment-block clearfix">
                                                                        <b class="text-green">Subject: English (210)
                                                                        </b><br>

                                                                        <strong class="text-green">Class: Class 2(B)</strong><br>
                                                                        <strong class="text-green"><?= $day->from ?></strong>
                                                                        <b class="text text-center">-</b>
                                                                        <strong class="text-green">10:35 AM</strong><br>

                                                                        <strong class="text-green">Room No.: 125</strong><br>

                                                                    </div>
                                                            <?php
                                                             endif;
                                                            endforeach; 
                                                        endif;
                                                            ?>
                                                        </td>
                                                        <td class="text text-center">

                                                            <?php 
                                                             if(isset($final_availability)):
                                                            foreach ($final_availability as $day) :
                                                                if (date('D', strtotime($day->from)) === 'Tue') :
                                                           
                                                           ?>


                                                                    <div class="attachment-block clearfix">
                                                                        <b class="text-green">Subject: English (210)
                                                                        </b><br>

                                                                        <strong class="text-green">Class: Class 2(B)</strong><br>
                                                                        <strong class="text-green"><?= $day->from ?></strong>
                                                                        <b class="text text-center">-</b>
                                                                        <strong class="text-green">10:35 AM</strong><br>

                                                                        <strong class="text-green">Room No.: 125</strong><br>

                                                                    </div>
                                                            <?php 
                                                            endif;
                                                            endforeach;
                                                        endif;
                                                            ?>





                                                        </td>
                                                        <td class="text text-center">

                                                            <?php 
                                                             if(isset($final_availability)):
                                                            foreach ($final_availability as $day) :
                                                            if (date('D', strtotime($day->from)) === 'Wed') :
                                                            ?>


                                                                <div class="attachment-block clearfix">
                                                                    <b class="text-green">Subject: English (210)
                                                                    </b><br>

                                                                    <strong class="text-green">Class: Class 2(B)</strong><br>
                                                                    <strong class="text-green"><?= $day->from ?></strong>
                                                                    <b class="text text-center">-</b>
                                                                    <strong class="text-green">10:35 AM</strong><br>

                                                                    <strong class="text-green">Room No.: 125</strong><br>

                                                                </div>
                                                            <?php 
                                                            endif;
                                                            endforeach;
                                                        endif;
                                                            ?>


                                                            </td>
                                                        <td class="text text-center">

                                                            <?php 
                                                             if(isset($final_availability)):
                                                            foreach ($final_availability as $day) :
                                                                if (date('D', strtotime($day->from)) === 'Thu') :
                                                            ?>


                                                                    <div class="attachment-block clearfix">
                                                                        <b class="text-green">Subject: English (210)
                                                                        </b><br>

                                                                        <strong class="text-green">Class: Class 2(B)</strong><br>
                                                                        <strong class="text-green"><?= $day->from ?></strong>
                                                                        <b class="text text-center">-</b>
                                                                        <strong class="text-green">10:35 AM</strong><br>

                                                                        <strong class="text-green">Room No.: 125</strong><br>

                                                                    </div>
                                                            <?php
                                                             endif;
                                                            endforeach; 
                                                        endif;
                                                            ?>




                                                        </td>
                                                        <td class="text text-center">

                                                            <?php 
                                                             if(isset($final_availability)):
                                                            foreach ($final_availability as $day) :
                                                                if (date('D', strtotime($day->from)) === 'Fri') :
                                                            ?>


                                                                    <div class="attachment-block clearfix">
                                                                        <b class="text-green">Subject: English (210)
                                                                        </b><br>

                                                                        <strong class="text-green">Class: Class 2(B)</strong><br>
                                                                        <strong class="text-green"><?= $day->from ?></strong>
                                                                        <b class="text text-center">-</b>
                                                                        <strong class="text-green">10:35 AM</strong><br>

                                                                        <strong class="text-green">Room No.: 125</strong><br>

                                                                    </div>
                                                            <?php 
                                                            endif;
                                                            endforeach; 
                                                        endif;
                                                            ?>




                                                        </td>
                                                        <td class="text text-center">

                                                            <?php 
                                                             if(isset($final_availability)):
                                                            foreach ($final_availability as $day) :
                                                                if (date('D', strtotime($day->from)) === 'Sat') :
                                                            
                                                            ?>


                                                                    <div class="attachment-block clearfix">
                                                                        <b class="text-green">Subject: English (210)
                                                                        </b><br>

                                                                        <strong class="text-green">Class: Class 2(B)</strong><br>
                                                                        <strong class="text-green"><?= $day->from ?></strong>
                                                                        <b class="text text-center">-</b>
                                                                        <strong class="text-green">10:35 AM</strong><br>

                                                                        <strong class="text-green">Room No.: 125</strong><br>

                                                                    </div>
                                                            <?php
                                                             endif;
                                                            endforeach; 
                                                        endif;
                                                            ?>






                                                        </td>
                                                        <td class="text text-center">

                                                            <?php 
                                                             if(isset($final_availability)):
                                                            foreach ($final_availability as $day) :
                                                                if (date('D', strtotime($day->from)) === 'Sun') :
                                                            ?>


                                                                    <div class="attachment-block clearfix">
                                                                        <b class="text-green">Subject: English (210)
                                                                        </b><br>

                                                                        <strong class="text-green">Class: Class 2(B)</strong><br>
                                                                        <strong class="text-green"><?= $day->from ?></strong>
                                                                        <b class="text text-center">-</b>
                                                                        <strong class="text-green">10:35 AM</strong><br>

                                                                        <strong class="text-green">Room No.: 125</strong><br>

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

<script>
    $(document).ready(function() {
        $("#addModule").click(function() {
            var html = `
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price" class="col-form-label-sm">Name</label>
                        <input type="text" name="name[]" value="" class="form-control form-control-sm" placeholder="Module name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="description" class="col-form-label-sm">Description</label>
                        <textarea type="text" name="description[]" value="" rows="2" class="form-control form-control-sm" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status" class="col-form-label-sm">Status</label>
                        <select name="status[]" class="custom-select custom-select-sm ">
                            <option value="" selected="selected">Select</option>
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-1">
                    <div class="form-group">
                        <button  type="button" class="btn btn-xs btn-danger remove_btn" title="Remove"><i class='fa fa-times'></i></button>
                    </div>
                </div>
            </div>`;

            $(".append_place").append(html);
        });

        $("#moduleForm").on('click', ".remove_btn", function() {
            $(this).parent().parent().parent().remove();
        });

    });

    /* 
     $(document).ready(function() {
        function get_course_level(course_id, course_level_id) {
          
                        $.ajax({
                            url: `<?= base_url("api/module/get_all") ?>?course_id=${course_id}`,
                            type: "get",
                            dataType: "json",
                            success: function(resp) {
                                if (resp.code == 200) {
                                    var levellist = [];
                                    let options = resp.data.map((d) => {
                                        
                                        if ((levellist[d.course_level_id])==undefined) {

                                        levellist[d.course_level_id] = d.course_level_id;
                                        var is_select = "";

                                        if (course_level_id != "") {
                                              d.course_level_id == course_level_id ? is_select = "selected" : "";
                                        }
                                        return `<option value="${d.course_level_id}" ${is_select}>${d.course_level}</option>`;
                                    }
                                    }).join("");

                                    $("#course_level_id").html(`<option value=''>Select</option> ${options}`);
                                } else {
                                    $("#course_level_id").html("<option value=''>Select</option>");
                                }
                              //  get_module();
                            }

                        });

                    }
                    //  run();
                    <?php
                    if (!empty(set_value('course_id', $course_id))) {
                        $c_id = set_value('course_id', $course_id);
                        $c_l_id = set_value('course_level_id', $course_level_id);

                    ?>
                    
                        get_course_level(<?= $c_id . "," . $c_l_id; ?>);
                    <?php
                    } else {
                    ?>

                  //  get_module();
                    <?php
                    }
                    ?>

                    $("body").on("change", "#course_id", function() {
                        let course_id = $(this).val();
                     
                        let course_level_id = $("#course_level_id").val();
                       
                        if (course_id > 0) {
                            get_course_level(course_id, course_level_id);
                           
                        } else {
                            $("#course_level_id").html("<option value=''>Select</option>");
                        }
                    });
 });
*/
</script>