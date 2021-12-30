    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Reservasi </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('reservasi');?>"><i class="fa fa-sticky-note"></i> Reservasi</a>
                </li>
                <li>
                    <a href="#">Tables</a>
                </li>
                <li class="active">Reservasi</li>
            </ol>
        </section><!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">List</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <button class="btn btn-primary" onclick="requestNotifikasi()">Get Notification</button>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="reservasi">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Booking</th>
                                            <th>Name</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>   
                                            <th>No</th>
                                            <th>ID Booking</th>
                                            <th>Name</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>
