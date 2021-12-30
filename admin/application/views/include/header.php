<!DOCTYPE html>
<html lang="en">

<!-- Head -->

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo isset($page_title) ? $page_title : ' Untitled Page'; ?> | Manado Pod House Apps</title>

    <!-- Meta-Tags -->
    <?php
    if (isset($assets_footer)) {
        foreach ($assets_header as $header) {
            if ($header['type'] == 'css') {
                echo '<link href="' . $header['href'] . '" rel="stylesheet" type="text/css" />';
            } elseif ($header['type'] == 'js') {
                echo '<script type="text/javascript" src="' . $header['href'] . '"></script>';
            }
        }
    }
    ?>
    <style type="text/css">
        .row {
            margin-top: 20px;
        }

        .navbar-default .navbar-nav>li>a:focus,
        .navbar-default .navbar-nav>li>a:hover {
            background-color: rgb(230, 230, 230);
        }

        .loading-data {
            text-align: center;
        }

        .modal {
            text-align: center;
            padding: 0 !important;
        }

        .modal:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
            margin-right: -4px;
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }
    </style>


    <!-- //Head -->

    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>';
        var base_url = '<?php echo base_url(); ?>';
    </script>

    <!-- Body -->

<body class="hold-transition skin-blue sidebar-mini">
    <div id="preloader" style="display: block;">
        <div id="statusLoading">&nbsp;</div>
    </div>

    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a class="logo" href="index2.html">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>P</b>H</span> <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Pod</b>House</span></a> <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a class="sidebar-toggle" data-toggle="push-menu" href="#" role="button"><span class="sr-only">Toggle navigation</span></a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown messages-menu">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-envelope-o"></i> <span class="label label-success new_count_message"><?php echo $this->db->where('read_status', 0)->count_all_results('bukutamu'); ?></span></a>
                            <ul class="dropdown-menu">
                                <audio class="notif_audio">
                                    <source src="<?php echo base_url('../sounds/notify.ogg'); ?>" type="audio/ogg">
                                    <source src="<?php echo base_url('../sounds/notify.mp3'); ?>" type="audio/mpeg">
                                    <source src="<?php echo base_url('../sounds/notify.wav'); ?>" type="audio/wav"></audio>
                                <li class="header new_count_message_2">You have <?php echo $this->db->where('read_status', 0)->count_all_results('bukutamu'); ?> messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu message-tbody">
                                        <?php
                                        if ($message->num_rows() > 0) {
                                            foreach ($message->result() as $rows) {

                                        ?>
                                                <li>
                                                    <a style="cursor:pointer" class="detail-message" id="<?php echo $rows->id; ?>">
                                                        <h4><?php echo $rows->nama; ?> </h4>
                                                        <p><?php echo $rows->pesan; ?></p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <li class="no-message-notif">
                                                <a href="#">
                                                    <h4>No Message</h4>
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">See All Messages</a>
                                </li>
                            </ul>
                        </li><!-- Notifications: style can be found in dropdown.less -->

                        <li class="dropdown notifications-menu">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bell-o"></i> <span class="label label-warning new_reservasi_message"><?php echo $this->db->where('read_status', 0)->count_all_results('reservasi'); ?></span></a>
                            <ul class="dropdown-menu">
                                <li class="header new_reservasi_message_2">You have <?php echo $this->db->where('read_status', 0)->count_all_results('reservasi'); ?> reservation</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu reservasi-tbody">
                                        <?php
                                        if ($reservasi_notif->num_rows() > 0) {
                                            foreach ($reservasi_notif->result() as $rows) {

                                        ?>
                                                <li>
                                                    <a style="cursor:pointer" class="detail-reservasi" id="<?php echo $rows->id_reservasi; ?>">
                                                        <h4><?php echo $rows->id_reservasi; ?> </h4>
                                                        <p><?php echo $rows->guest_name; ?></p>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <li class="no-reservasi-notif">
                                                <a href="#">
                                                    <h4>No New Reservation</h4>
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all</a>
                                </li>
                            </ul>
                        </li><!-- Tasks: style can be found in dropdown.less -->

                        <li class="dropdown user user-menu">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img alt="User Image" class="user-image" src="<?php echo base_url('assets/img/user.jpg'); ?>"> <span class="hidden-xs">
                                    <?php
                                    $id = $this->session->userdata('id');
                                    $username = $this->session->userdata('username');
                                    echo ucwords($username); ?></span></a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img alt="User Image" class="img-circle" src="<?php echo base_url('assets/img/user.jpg'); ?>">
                                    <p><?php $username = $this->session->userdata('username');
                                        echo ucwords($username); ?> <small><?php echo $this->session->userdata('email'); ?></small></p>
                                </li><!-- Menu Body -->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a class="btn btn-default btn-flat" href="<?php echo site_url('account/change_password/' . $id); ?>">Change Password</a>
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-flat" href="<?php echo site_url('auth/logout'); ?>">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li><!-- Control Sidebar Toggle Button -->
                    </ul>
                </div>
            </nav>
        </header><!-- Left side column. contains the logo and sidebar -->

        <?php $level = $this->session->userdata('level'); ?>
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image"><img alt="User Image" class="img-circle" src="<?php echo base_url('assets/img/user.jpg'); ?>"></div>
                    <div class="pull-left info">
                        <p><?php $username = $this->session->userdata('username');
                            echo ucwords($username); ?></p><a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div><!-- search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-sticky-note"></i> <span>Reservasi</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li class="active">
                                <a href="<?php echo site_url('reservasi'); ?>"><i class="fa fa-circle-o"></i> Reservasi</a>
                                <a href="<?php echo site_url('customer'); ?>"><i class="fa fa-circle-o"></i> Customer Data</a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-user-circle"></i> <span>Testimony</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li class="active">
                                <a href="<?php echo site_url('testimoni'); ?>"><i class="fa fa-circle-o"></i> Testimony</a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-bed"></i> <span>Room</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li class="active">
                                <a href="<?php echo site_url('room'); ?>"><i class="fa fa-circle-o"></i> Room</a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-address-book"></i> <span>Guestbook</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li class="active">
                                <a href="<?php echo site_url('guestbook'); ?>"><i class="fa fa-circle-o"></i> Guestbook</a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-image"></i> <span>Gallery</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li class="active">
                                <a href="<?php echo site_url('gallery'); ?>"><i class="fa fa-circle-o"></i> Gallery</a>
                            </li>
                        </ul>
                    </li>
                    <?php
                    if ($level == "admin") { ?>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-user"></i> <span>Users</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                            <ul class="treeview-menu">
                                <li class="active">
                                    <a href="<?php echo site_url('users'); ?>"><i class="fa fa-circle-o"></i> Users</a>
                                </li>
                            </ul>
                        </li>
                    <?php } else { ?>

                    <?php } ?>
                </ul>
            </section><!-- /.sidebar -->
        </aside><!-- Content Wrapper. Contains page content -->