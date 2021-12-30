        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Testimony</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo site_url('testimoni');?>"><i class="fa fa-user-circle"></i> Testimony</a>
                    </li>
                    <li>
                        <a href="#">Forms</a>
                    </li>
                    <li class="active">Edit Testimony</li>
                </ol>
            </section><!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form id="<?php echo $form_id;?>" action="<?php echo $form_action;?>" method="POST">
                                <div class="box-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php if(isset($arr_testimoni)) { echo $arr_testimoni->id; } ?>" class="form-control">
                                        <label>ID Booking</label> <input value="<?php if(isset($arr_testimoni)) { echo $arr_testimoni->id_reservasi; } ?>"" class="form-control" required placeholder="Booking ID" name="id_reservasi" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label> <input class="form-control" placeholder="Name" name="nama" type="text" value="<?php if(isset($arr_testimoni)) { echo $arr_testimoni->nama; } ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Company</label> <input class="form-control" placeholder="Company" name="company" type="text" value="<?php if(isset($arr_testimoni)) { echo $arr_testimoni->company; } ?>" required>
                                    </div>
                                    <label>Email</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span> <input class="form-control" placeholder="Email" type="email" name="email" value="<?php if(isset($arr_testimoni)) { echo $arr_testimoni->email; } ?>" required>
                                    </div>
                                    <br>
                                    <label>Status</label>
                                    <br>
                                    <div class="form-group">
                                        <label> 
                                            <input type="radio" name="status" class="flat-red form-control" value="pending" <?php echo ($arr_testimoni->status == "pending")?'checked':''?>> Pending   
                                        </label>
                                        <label> 
                                            <input type="radio" name="status" class="flat-red form-control" value="accepted" <?php echo ($arr_testimoni->status == "accepted")?'checked':''?>> Accepted
                                        </label>
                                    </div>
                                    <label>Rating</label>
                                    <div class="form-group">
                                        <select name="rating" class="form-control">
                                            <option value="<?php if(isset($arr_testimoni)) { echo $arr_testimoni->rating; } ?>"><?php echo $arr_testimoni->rating;?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label>Message</label> 
                                        <textarea class="form-control" name="pesan" placeholder="Enter ..." rows="3"><?php echo $arr_testimoni->pesan;?></textarea>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo site_url('testimoni');?>" class="btn btn-success">Back</a>
                                </div>
                            </form>
                        </div><!-- /.box -->
                    </div><!--/.col (left) -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
       