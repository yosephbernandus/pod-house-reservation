    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Users </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('users');?>"><i class="fa fa-user"></i> Users</a>
                </li>
                <li>
                    <a href="#">Forms</a>
                </li>
                <li class="active">Edit Users</li>
            </ol>
        </section><!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-xs-12">
                    <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form Edit Users</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form name="<?php echo $form_name;?>" id="<?php echo $form_id;?>" action="<?php echo $form_action;?>" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Username</label> 
                                        <input type="hidden" name="id" value="<?php if(isset($arr_user)) { echo $arr_user->id; } ?>">
                                        <input class="form-control" placeholder="Username" name="user" type="text" value="<?php if(isset($arr_user)) { echo $arr_user->user; } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label> <input class="form-control" placeholder="Email" name="email" value="<?php if(isset($arr_user)) { echo $arr_user->email; } ?>" type="email">
                                    </div>
                                    <label>Status</label>
                                    <div class="form-group">
                                        <label> 
                                            <input type="radio" name="level" class="flat-red form-control" value="admin" <?php echo ($arr_user->level == "admin")?'checked':''?>> Admin   
                                        </label>
                                        <label> 
                                            <input type="radio" name="level" class="flat-red form-control" value="user" <?php echo ($arr_user->level == "user")?'checked':''?>> User
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label> <input class="form-control" placeholder="Password" name="password" type="password">
                                    </div>
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