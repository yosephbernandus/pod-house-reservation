    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Room </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('room');?>"><i class="fa fa-bed"></i> Room</a>
                </li>
                <li>
                    <a href="#">Forms</a>
                </li>
                <li class="active">Edit Room</li>
            </ol>
        </section><!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-xs-12">
                    <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form Edit Room</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                           <form name="<?php echo $form_name;?>" id="<?php echo $form_id;?>" action="<?php echo $form_action;?>" method="POST">
                                <div class="box-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php if(isset($arr_room)) { echo $arr_room->id; } ?>">
                                        <label>Room Name</label> <input class="form-control" placeholder="Room Name" name="nama_room" value="<?php if(isset($arr_room)) { echo $arr_room->nama_room; } ?>" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Amount</label> <input onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Amount" name="jumlah_room" value="<?php if(isset($arr_room)) { echo $arr_room->jumlah_room; } ?>" type="number">
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label> <input onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Price" name="harga" value="<?php if(isset($arr_room)) { echo $arr_room->harga; } ?>" type="number">
                                    </div>
                                    <div class="form-group">
                                        <label>Discount</label> <input onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Discount" name="diskon" value="<?php if(isset($arr_room)) { echo $arr_room->diskon; } ?>" type="number">
                                    </div>
                                    <div class="form-group">
                                        <label>Breakfast</label>
                                        <select name="breakfast" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option><?php echo $arr_room->breakfast;?></option>
                                            <option>INCLUDED</option>
                                            <option>NOT INCLUDE</option>
                                      </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label> 
                                        <textarea class="form-control" name="keterangan" placeholder="Enter ..." rows="3"><?php echo $arr_room->keterangan;?></textarea>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label>Input Image</label>
                                        <input type="file" name="userfile" class="form-control">
                                        <br>
                                        <?php if ($room['image'] == NULL):?>
                                            <p>No Image</p>
                                        <?php else :?>
                                            <img style="width: 200px;" class="img-responsive" src="<?php echo base_url('assets/img/gallery/'.$room['image']);?>">
                                        <?php endif;?>
                                    </div> -->
                                    <br>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button class="btn btn-primary" type="submit" name="submit">Save</button>
                                </div>
                            </form>
                           
                        </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>

    <script type="text/javascript">
        function hanyaAngka(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    </script>