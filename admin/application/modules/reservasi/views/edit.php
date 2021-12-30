        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Reservasi</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="#"><i class="fa fa-sticky-note"></i> Reservasi</a>
                    </li>
                    <li>
                        <a href="#">Forms</a>
                    </li>
                    <li class="active">Edit Reservasi</li>
                </ol>
            </section><!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Forms</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form id="<?php echo $form_id;?>" action="<?php echo $form_action;?>" method="POST">
                                <div class="box-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php if(isset($arr_reservasi)) { echo $arr_reservasi->id; } ?>" class="form-control">
                                        <label>Booking ID</label> <input value="<?php if(isset($arr_reservasi)) { echo $arr_reservasi->id_reservasi; } ?>" class="form-control" required placeholder="Booking ID" name="id_reservasi" type="text" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama</label> <input class="form-control" placeholder="Name" name="guest_name" type="text" value="<?php if(isset($arr_reservasi)) { echo $arr_reservasi->guest_name; } ?>" required readonly>
                                    </div>
                                    <br>
                                    <label>Status</label>
                                    <br>
                                    <div class="form-group">
                                        <label> 
                                            <input type="radio" name="status" class="flat-red form-control" value="booking" <?php echo ($arr_reservasi->status == "booking")?'checked':''?>> Booking   
                                        </label>
                                        <label> 
                                            <input type="radio" name="status" class="flat-red form-control" value="checkout" <?php echo ($arr_reservasi->status == "checkout")?'checked':''?>> Checkout
                                        </label>
                                    </div>
                                    <br>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo site_url('reservasi');?>" class="btn btn-success">Back</a>
                                </div>
                            </form>
                        </div><!-- /.box -->
                    </div><!--/.col (left) -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
       