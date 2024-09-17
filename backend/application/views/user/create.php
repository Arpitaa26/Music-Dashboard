<?php
$id = "";
$user_type_id = "";
$user_pronoun_id = "";
$first_name = "";
$middle_name = "";
$last_name = "";
$username = "";
$email = "";
$phone_no = "";
$city = "";
$state = "";
$country = "";
$postal_code = "";
$address = "";
$dob = "";
$password = "";
$cpassword = "";
$status = "";
$account_details_url = "";
$action_url = base_url("user/save");
$label = "Create";
$icon = "<i class='fa fa-plus-square'></i>&nbsp; {$label}</i>";
if (isset($user->id)) :
    $id = $user->id;
    $user_type_id = $user->user_type_id;
    $user_pronoun_id = $user->user_pronoun_id;
    $first_name = $user->first_name;
    $middle_name = $user->middle_name;
    $last_name = $user->last_name;
    $username = $user->username;
    $email = $user->email;
    $phone_no = $user->phone_no;
    $city = $user->city;
    $state = $user->state;
    $country = $user->country;
    $postal_code = $user->postal_code;
    $address = $user->address;
    $dob = $user->dob;
    $password = $user->password;
    $cpassword = $user->password;
    $status = $user->status;
    $account_details_url = base_url("api/user/account_details/{$id}");
    $performance_url = base_url("user/performance/{$id}");
    $action_url = base_url("user/save/{$id}");
    $label = "Edit";
    $icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
endif;

?>
<style>
    label {
        height: 50px;
    }

    .input-group-text {
        background-color: #6c757d !important; 
        padding: 0;
        padding-right: 5px;
        padding-left: 5px;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User <?= $label ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('user') ?>">User</a></li>
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
                    <?= form_open_multipart($action_url, ['method' => "post", "id" => "moduleForm"]); ?>
                    <div class="card-body append_place">

                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name" class="col-form-label-sm">First Name</label>
                                    <input type="text" name="first_name" value="<?= set_value('first_name', $first_name) ?>" class="form-control form-control-sm <?= set_form_error('first_name', false); ?>" placeholder="First name">
                                    <?= set_form_error('first_name'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="middle_name" class="col-form-label-sm">Middle Name</label>
                                    <input type="text" name="middle_name" value="<?= set_value('middle_name', $middle_name) ?>" class="form-control form-control-sm <?= set_form_error('middle_name', false); ?>" placeholder="Middle Name">
                                    <?= set_form_error('middle_name'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name" class="col-form-label-sm">Last Name</label>
                                    <input type="text" name="last_name" value="<?= set_value('last_name', $last_name) ?>" class="form-control form-control-sm <?= set_form_error('last_name', false); ?>" placeholder="Last Name">
                                    <?= set_form_error('last_name'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="username" class="col-form-label-sm">Username</label>
                                    <input type="text" name="username" value="<?= set_value('username', $username) ?>" class="form-control form-control-sm <?= set_form_error('username', false); ?>" placeholder="Username">
                                    <?= set_form_error('username'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Password" class="col-form-label-sm">Email</label>
                                    <input type="text" name="email" value="<?= set_value('email', $email) ?>" class="form-control form-control-sm <?= set_form_error('email', false); ?>" placeholder="Email">
                                    <?= set_form_error('email'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone_no" class="col-form-label-sm">Phone Number</label>
                                    <input type="text" name="phone_no" value="<?= set_value('phone_no', $phone_no) ?>" class="form-control form-control-sm <?= set_form_error('phone_no', false); ?>" placeholder="Phone Number">
                                    <?= set_form_error('phone_no'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city" class="col-form-label-sm">City</label>
                                    <input type="text" name="city" value="<?= set_value('city', $city) ?>" class="form-control form-control-sm <?= set_form_error('city', false); ?>" placeholder="City">
                                    <?= set_form_error('city'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state" class="col-form-label-sm">State</label>
                                    <input type="text" name="state" value="<?= set_value('state', $state) ?>" class="form-control form-control-sm <?= set_form_error('state', false); ?>" placeholder="State">
                                    <?= set_form_error('state'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country" class="col-form-label-sm">Country</label>
                                    <input type="text" name="country" value="<?= set_value('country', $country) ?>" class="form-control form-control-sm <?= set_form_error('country', false); ?>" placeholder="Country">
                                    <?= set_form_error('country'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="postal_code" class="col-form-label-sm">Postal Code</label>
                                    <input type="text" name="postal_code" value="<?= set_value('postal_code', $postal_code) ?>" class="form-control form-control-sm <?= set_form_error('postal_code', false); ?>" placeholder="Postal Code">
                                    <?= set_form_error('postal_code'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address" class="col-form-label-sm">Address</label>
                                    <input type="text" name="address" value="<?= set_value('address', $address) ?>" class="form-control form-control-sm <?= set_form_error('address', false); ?>" placeholder="Address">
                                    <?= set_form_error('address'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dob" class="col-form-label-sm">Date of Birth</label>
                                    <input type="date" name="dob" value="<?= set_value('dob', $dob) ?>" class="form-control form-control-sm <?= set_form_error('dob', false); ?>" placeholder="Date of Birth">
                                    <?= set_form_error('dob'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user_type_id" class="col-form-label-sm">User Type</label>
                                    <?php $user_type_error = set_form_error('user_type_id', false);
                                    if (isset($user_types)) {
                                        $user_types = ["" => "Select"] + array_column($user_types, "type", "id");
                                    } else {
                                        $user_types = ["" => "Select"];
                                    }
                                    ?>
                                    <?= form_dropdown('user_type_id', $user_types, set_value('user_type_id', $user_type_id), "class='custom-select custom-select-sm {$user_type_error}'") ?>
                                    <?= set_form_error('user_type_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user_pronoun_id" class="col-form-label-sm">User Pronoun</label>
                                    <?php $user_pronoun_error = set_form_error('user_pronoun_id', false);
                                    if (isset($user_pronouns)) {
                                        $user_pronouns = ["" => "Select"] + array_column($user_pronouns, "pronoun", "id");
                                    } else {
                                        $user_pronouns = ["" => "Select"];
                                    }
                                    ?>
                                    <?= form_dropdown('user_pronoun_id', $user_pronouns, set_value('user_pronoun_id', $user_pronoun_id), "class='custom-select custom-select-sm {$user_pronoun_error}'") ?>
                                    <?= set_form_error('user_pronoun_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="col-form-label-sm">Status</label>
                                    <?php
                                    $status_error = set_form_error('status', false);
                                    $status_options = ["" => "Select", "pending" => "Pending", "active" => "Active", "inactive" => "InActive", "blocked" => "Blocked", "banned" => "Banned"];
                                    ?>
                                    <?= form_dropdown('status', $status_options, set_value('status', $status), "class='custom-select custom-select-sm {$status_error}'") ?>
                                    <?= set_form_error('status'); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password" class="col-form-label-sm">Password</label>
                                    <input type="password" name="password" class="form-control form-control-sm <?= set_form_error('password', false); ?>" placeholder="Password">
                                    <?= set_form_error('password'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cpassword" class="col-form-label-sm">Confirm Password</label>
                                    <input type="password" name="cpassword" class="form-control form-control-sm <?= set_form_error('cpassword', false); ?>" placeholder="Confirm Password">
                                    <?= set_form_error('cpassword'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cpassword" class="col-form-label-sm">Profile Image</label>
                                    <input type="file" name="profile_file" id="profile_file">
                                   
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
                <?php if (isset($user->id)) {
                    if ($user->type == 'TEACHER') { ?>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Others Details</h3>

                                <div class="card-tools">

                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                </div>
                            </div>

                            <div class="card-body">
                                <?= form_open_multipart($account_details_url, ['method' => "post", "id" => "moduleForm"]); ?>
                                <?php

                                $test = $user->other_details;
                                $res = json_decode($test);
                                $date_of_joining = isset($res->date_of_joining) ? $res->date_of_joining : '';
                                ?>
                                <div class="row ">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="last_name" class="col-form-label-sm">Date Of Joining</label>
                                            <input type="hidden" name="category" value="RESUME" class="form-control form-control-sm">

                                            <input type="text" name="date_of_joining" value="<?= isset($res->date_of_joining) ? $res->date_of_joining : '' ?>" class="form-control form-control-sm" placeholder="date_of_joining">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="last_name" class="col-form-label-sm">Achivements</label>
                                            <input type="text" name="achivements" value="<?= isset($res->achivements) ? $res->achivements : '' ?>" class="form-control form-control-sm" placeholder="achivements">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="last_name" class="col-form-label-sm">Concerts</label>
                                            <input type="text" name="concerts" value="<?= isset($res->concerts) ? $res->concerts : '' ?>" class="form-control form-control-sm" placeholder="concerts">
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Date_of_contract_Accademi" class="col-form-label-sm">Date Of Contract Sent By The Academy</label>

                                            <input type="text" name="date_of_contract_Academy" value="<?= isset($res->date_of_contract_Academy) ? $res->date_of_contract_Academy : '' ?>" class="form-control form-control-sm" placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="last_name" class="col-form-label-sm">Date Of Training Period</label>
                                            <input type="text" name="date_of_training_period" value="<?= isset($res->date_of_training_period) ? $res->date_of_training_period : '' ?>" class="form-control form-control-sm" placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Date_of_contract_teacher" class="col-form-label-sm">Date Of Teacher Singing The Contract</label>
                                            <input type="text" name="date_of_contract_teacher" value="<?= isset($res->date_of_contract_teacher) ? $res->date_of_contract_teacher : '' ?>" class="form-control form-control-sm" placeholder="dd-mm-yyyy">
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="last_name" class="col-form-label-sm">Resume</label>
                                            <input type="hidden" name="file_name" value="<?= isset($res->link) ? $res->link : '' ?><?= isset($res->file_ext) ? $res->file_ext : '' ?>" id="file">
                                            <input type="file" name="file" id="file">
                                            <!-- <input type="file" name="userfile"> -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <!-- <img class="img-circle elevation-2" src="<?= base_url() ?>file/open/<?= isset($res->link) ? $res->link : '' ?>" alt="User Avatar"> -->

                                            <a class="btn btn-sm btn-success float-right" href="<?= base_url() ?>file/download/<?= isset($res->link) ? $res->link : '' ?>"><i class="fa fa-download" aria-hidden="true"></i>
                                            </a>&nbsp;&nbsp;
                                            <a class="btn btn-sm btn-primary float-right" href="<?= base_url() ?>file/viewfile/<?= isset($res->link) ? $res->link : '' ?>"><i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fa fa-save"></i> Save Changes</button>
                            </div>

                            <?= form_close() ?>
                        </div>
                <?php }
                } ?>
                <?php if (isset($user->id)) {
                    if ($user->type == 'TEACHER') { ?>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Performance</h3>

                                <div class="card-tools">

                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                </div>
                            </div>

                            <div class="card-body">
                                <?= form_open_multipart($performance_url, ['method' => "post", "id" => "moduleForm"]); ?>
                                <?php
                                $tests = $user->performance;
                                $res = json_decode($tests);

                                ?>
                                <div class="row ">
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="renewals_concerns_cookie" class="col-form-label-sm">Renewals and Concerns Cookie</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cookie</span>
                                            </div>
                                            <input type="number" name="renewals_concerns_cookie" value="<?= isset($res->renewals_concerns_cookie) ? $res->renewals_concerns_cookie : '' ?>" class="form-control form-control-sm" >
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="attendance_reschedule_cookie" class="col-form-label-sm">Attendance and Reschedules Cookie</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cookie</span>
                                            </div>
                                            <input type="number" name="attendance_reschedule_cookie" value="<?= isset($res->attendance_reschedule_cookie) ? $res->attendance_reschedule_cookie : '' ?>" class="form-control form-control-sm">

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="virtual_background_consistencies_cookie" class="col-form-label-sm">Virtual Background Consistencies Cookie</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cookie</span>
                                            </div>
                                            <input type="number" name="virtual_background_consistencies_cookie" value="<?= isset($res->virtual_background_consistencies_cookie) ? $res->virtual_background_consistencies_cookie : '' ?>" class="form-control form-control-sm" >
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="punctuality_cookie" class="col-form-label-sm">Punctuality Cookie</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cookie</span>
                                            </div>
                                            <input type="number" name="punctuality_cookie" value="<?= isset($res->punctuality_cookie) ? $res->punctuality_cookie : '' ?>" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="disciplinary_compliances_cookie" class="col-form-label-sm">Disciplinary Compliances Cookie</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cookie</span>
                                            </div>
                                            <input type="number" name="disciplinary_compliances_cookie" value="<?= isset($res->disciplinary_compliances_cookie) ? $res->disciplinary_compliances_cookie : '' ?>" class="form-control form-control-sm" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="Renewals and Concerns" class="col-form-label-sm">Renewals and Concerns Cutnip</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cutnip</span>
                                            </div>
                                            <input type="number" name="renewals_concerns_cutnip" value="<?= isset($res->renewals_concerns_cutnip) ? $res->renewals_concerns_cutnip : '' ?>" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="Attendance and Reschedule" class="col-form-label-sm">Attendance and Reschedule</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cutnip</span>
                                            </div>
                                            <input type="number" name="attendance_reschedule_cutnip" value="<?= isset($res->attendance_reschedule_cutnip) ? $res->attendance_reschedule_cutnip : '' ?>" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="virtual_background_consistencies_cutnip" class="col-form-label-sm">Virtual Background Consistencies</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cutnip</span>
                                            </div>
                                            <input type="number" name="virtual_background_consistencies_cutnip" value="<?= isset($res->virtual_background_consistencies_cutnip) ? $res->virtual_background_consistencies_cutnip : '' ?>" class="form-control form-control-sm" >
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="Punctuality" class="col-form-label-sm">Punctuality  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cutnip</span>
                                            </div>
                                            <input type="number" name="punctuality_cutnip" value="<?= isset($res->punctuality_cutnip) ? $res->punctuality_cutnip : '' ?>" class="form-control form-control-sm" placeholder="punctuality_cutnip">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group input-group">
                                            <label for="disciplinary_compliances_cutnip" class="col-form-label-sm">Disciplinary Compliances</label>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cutnip</span>
                                            </div>
                                            <input type="number" name="disciplinary_compliances_cutnip" value="<?= isset($res->disciplinary_compliances_cutnip) ? $res->disciplinary_compliances_cutnip: '' ?>" class="form-control form-control-sm" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-primary float-right"><i class="fa fa-save"></i> Save Changes</button>
                            </div>

                            <?= form_close() ?>
                        </div>
                <?php }
                } ?>

            </div>
        </div>
    </div>
</section>
<!-- /.content -->