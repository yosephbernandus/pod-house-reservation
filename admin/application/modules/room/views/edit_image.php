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
                <li class="active">Edit Image</li>
            </ol>
        </section><!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-xs-12">
                    <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form Edit Image</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                           <form action="" method="POST" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php if(isset($arr_room)) { echo $arr_room->id; } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Input Image</label>
                                        <input type="file" name="userfile" class="form-control">
                                        <br>
                                        <?php if ($arr_room->image == NULL):?>
                                            <p>No Image</p>
                                        <?php else :?>
                                            <img style="width: 200px;" class="img-responsive" src="<?php echo base_url('assets/img/room/'.$arr_room->image);?>">
                                        <?php endif;?>
                                    </div>
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