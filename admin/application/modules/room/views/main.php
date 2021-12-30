    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Room </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('room');?>"><i class="fa fa-bed"></i> Room</a>
                </li>
                <li>
                    <a href="#">Tables</a>
                </li>
                <li class="active">Room</li>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="room">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>Room Name</th>
                                            <th>Amount</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Breakfast</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>   
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>Room Name</th>
                                            <th>Amount</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Breakfast</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->

                <div class="col-xs-12">
                    <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form Add Room</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form name="<?php echo $form_name;?>" action="<?php echo site_url('room/ajax_add');?>" method="POST" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Room Name</label> <input class="form-control" placeholder="Room Name" name="nama_room" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Amount</label> <input onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Amount" name="jumlah_room" type="number">
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label> <input onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Price" name="harga" type="number">
                                    </div>
                                    <div class="form-group">
                                        <label>Discount</label> <input onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Discount" name="diskon" type="number">
                                    </div>
                                    <div class="form-group">
                                        <label>Breakfast</label>
                                        <select name="breakfast" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                          <option selected="selected">INCLUDED</option>
                                          <option>NOT INCLUDE</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label> 
                                        <textarea class="form-control" name="keterangan" placeholder="Enter ..." rows="3"></textarea>
                                    </div>
                                    <br>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>

    <?php

     function do_upload() {
        $config['image_library'] = 'gd2';
        $original_path = './uploads/activity_images/original';
        $resized_path = './uploads/activity_images/resized';
        $thumbs_path = './uploads/activity_images/thumb';
        $this->load->library('image_lib', $config);

        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png', //only accept these file types
            'max_size' => 2048, //2MB max
            'upload_path' => $original_path //upload directory    
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload();
        $image_data = $this->upload->data(); //upload the image
        $image1 = $image_data['file_name'];

        //your desired config for the resize() function
        $config = array(
            'source_image' => $image_data['full_path'], //path to the uploaded image
            'new_image' => $resized_path,
            'maintain_ratio' => true,
            'width' => 128,
            'height' => 128
        );
        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        // for the Thumbnail image
        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $thumbs_path,
            'maintain_ratio' => true,
            'width' => 36,
            'height' => 36
        );
        //here is the second thumbnail, notice the call for the initialize() function again
        $this->image_lib->initialize($config);

        $this->image_lib->resize();
        //$this->image_lib->clear();
       echo  $this->image_lib->display_errors();
        var_dump(gd_info());
        die();
        return $image1;
    }