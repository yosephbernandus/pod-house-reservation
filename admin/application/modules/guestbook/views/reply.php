        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Guestbook</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo site_url('Guestbook');?>"><i class="fa fa-address-book"></i> Guestbook</a>
                    </li>
                    <li>
                        <a href="#">Forms</a>
                    </li>
                    <li class="active">Reply Email</li>
                </ol>
            </section><!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Forms Reply Email</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                             <form action="<?php echo site_url('guestbook/send');?>" enctype="multipart/form-data">
                                <div class="box-body">
                                    <?php echo $message_success;?>
                                    <label>Email From</label>
                                    <input type="hidden" name="id" value="<?php if(isset($arr_guestbook)) { echo $arr_guestbook->id; } ?>">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span> <input class="form-control" placeholder="Email" type="email" name="email" readonly value="<?php if(isset($arr_guestbook)) { echo $arr_guestbook->email; } ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Message</label> 
                                        <textarea class="form-control" readonly name="pesan" placeholder="Enter ..." rows="3"><?php echo $arr_guestbook->pesan;?></textarea>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label>Subject</label> <input class="form-control" required placeholder="Subject" name="subject" type="text" required>
                                    </div>

                                    <label>Your Email</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span> <select name="email_from" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                          <option selected="selected">info@manadopodhouse.com</option>
                                          <option>admin@manadopodhouse.com</option>
                                        </select>
                                    </div>
                    
                                    <div class="form-group">
                                        <label>Your Password</label> <input class="form-control" placeholder="Password" name="pass_email" type="password" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Your Message</label> 
                                        <textarea class="form-control" name="pesan" placeholder="Enter ..." rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label> <input type="file" name="userfile[]" multiple="multiple" class="form-control">
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo site_url('guestbook');?>" class="btn btn-success">Back</a>
                                </div>
                            </form>
                        </div><!-- /.box -->
                    </div><!--/.col (left) -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
       