<?php
function active($currect_page)
{
    $url_array =  explode('/', $_SERVER['REQUEST_URI']);
    $url = end($url_array);
    if ($currect_page == $url) {
        echo 'active'; //class name in css 
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/fontawesome-free/css/all.min.css") ?>">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/daterangepicker/daterangepicker.css") ?>">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css") ?>">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css") ?>">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") ?>">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css") ?>">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/bs-stepper/css/bs-stepper.min.css") ?>">

    <!-- ui -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/jquery-ui/jquery-ui.css") ?>">
    <!-- dropzone css -->
    <link rel="stylesheet" href="<?= base_url("assets/dropzone/dropzone.css") ?>">
    <!-- Theme style-->
    <link rel="stylesheet" href="<?= base_url("assets/dist/css/adminlte.min.css") ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/datatables-rowreorder/css/rowReorder.bootstrap4.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/summernote/summernote-bs4.min.css") ?>">

    <!-- customs -->
    <link rel="stylesheet" href="<?= base_url("assets/dist/css/style.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/course/course_addon.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/fullcalendar/main.css") ?>">
    <style>
        .pop_fix_btn {
            bottom: 1.25rem;
            position: fixed;
            right: 1.25rem;
            z-index: 1032;
        }

        a {
            color: #3395ff;
        }

        .dark-mode input:-webkit-autofill,
        .dark-mode input:-webkit-autofill:focus,
        .dark-mode input:-webkit-autofill:hover,
        .dark-mode select:-webkit-autofill,
        .dark-mode select:-webkit-autofill:focus,
        .dark-mode select:-webkit-autofill:hover,
        .dark-mode textarea:-webkit-autofill,
        .dark-mode textarea:-webkit-autofill:focus,
        .dark-mode textarea:-webkit-autofill:hover {
            -webkit-background-clip: text;
            -webkit-text-fill-color: #fff;
        }
    </style>


    <!-- script -->

    <!-- jQuery -->
    <script src="<?= base_url("assets/plugins/jquery/jquery.min.js") ?>"></script>


    <!-- DataTables  & Plugins -->
    <script src="<?= base_url("assets/plugins/datatables/jquery.dataTables.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-responsive/js/dataTables.responsive.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/dataTables.buttons.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-rowreorder/js/dataTables.rowReorder.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/jszip/jszip.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/pdfmake/pdfmake.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/pdfmake/vfs_fonts.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/buttons.html5.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/buttons.print.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/buttons.colVis.min.js") ?>"></script>
    <!-- jquery-ui js-->
    <!-- <script src="<?= base_url("assets/plugins/jquery-ui/jquery-ui.js") ?>"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <!-- dropzonejs -->
    <script src="<?= base_url("assets/dropzone/dropzone.js") ?>"></script>
    <!-- Custom js -->
    <script src="<?= base_url("assets/dist/js/dataReorder.js") ?>"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed dark-mode">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url() ?>" class="nav-link">Home</a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                Messages Dropdown Menu
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                          Message Start 
                            <div class="media">
                                <img src="<?= base_url("assets/dist/img/user1-128x128.jpg") ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            Message End 
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            Message Start
                            <div class="media">
                                <img src="<?= base_url("assets/dist/img/user8-128x128.jpg") ?>" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                         Message End
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                          Message Start 
                            <div class="media">
                                <img src="<?= base_url("assets/dist/img/user3-128x128.jpg") ?>" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                          Message End 
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
               Notifications Dropdown Menu 
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li> -->

                <!-- profile -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= base_url("assets/dist/img/user2-160x160.jpg") ?>" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline"><?= $this->http->session_get("first_name") ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="<?= base_url("assets/dist/img/user2-160x160.jpg") ?>" class="img-circle elevation-2" alt="User Image">

                            <p>
                                <?= $this->http->session_get("username") ?>
                                <small>Member since <?= date("jS M Y", strtotime($this->http->session_get("created_on"))); ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- <li class="user-body">
                        <div class="row">
                            <div class="col-4 text-center">
                            <a href="#">Followers</a>
                            </div>
                            <div class="col-4 text-center">
                            <a href="#">Sales</a>
                            </div>
                            <div class="col-4 text-center">
                            <a href="#">Friends</a>
                            </div>
                        </div>
                        </li> -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="<?= base_url('profile') ?>" class="btn btn-default btn-flat">Profile</a>
                            <a href="<?= base_url('logout') ?>" class="btn btn-default btn-flat float-right">Sign out</a>
                        </li>
                    </ul>
                </li>
                <!-- 
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> -->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>" class="brand-link">
                <img src="<?= base_url($Logo); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= $HF_title; ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- SidebarSearch Form -->
                <div class="form-inline mt-3">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage Course
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("course") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("course/save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Course History
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?= base_url("course_history") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>List</p>
                                            </a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a href="<?= base_url("module/save") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li> -->
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Course Performance
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?= base_url("course_performance") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>List</p>
                                            </a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a href="<?= base_url("module/save") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li> -->
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Manage Module
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?= base_url("module") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>List</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?= base_url("module/save") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Course Level
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?= base_url("course_level") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>List</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?= base_url("course_level/save") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!--    ********* tutorial manage *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage Tutorial
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("tutorial") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("tutorial/save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Question
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>
                                            Manage Question
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="<?= base_url("question") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>List</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?= base_url("question/save") ?>" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage Batches
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("batch") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("batch/save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Scheduled Class
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("scheduled_class") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("scheduled_class/save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!--    ********* course_enrollment *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Course Enrollment
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("course_enrollment") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("course_enrollment/save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!--    ********* user manage *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage User
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("user") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User List</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= base_url("user/save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('user?user_type_id=5') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Student List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('user?user_type_id=4') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Teacher List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('user?user_type_id=3') ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Support List</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <!--    ********* Class_reschedule_request manage *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage Class Rescheduled request
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("class_reschedule_request") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--    ********* File manage *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage File
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("file") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("file/file_save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--    ********* Attendance manage *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage Attendance
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("user_attendance") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="<?= base_url("user_attendance/create") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li> -->
                            </ul>
                        </li>
                        <!--    ********* Task manage *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage Task
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("task") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("task/save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("task") ?>?task_type=GENERAL" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>General</p>
                                    </a>
                                </li>
                                <li class="nav-item" class="<?php active('SUPPORT'); ?>">
                                    <a href="<?= base_url("task") ?>?task_type=SUPPORT" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Support</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--    ********* Task manage *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage Task Template
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("task_template") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("task_template/save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--    ********* Country manage *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Manage Country
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("country") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("country/save") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--    ********* Email Templates *********    -->

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Email Template
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url("general_settings") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Settings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url("general_settings/email_templates") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Email Template</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-md-center">
                        <div class="col-md-6 mt-2">
                            <?= get_message() ?>
                        </div>
                    </div>
                </div>
            </div>