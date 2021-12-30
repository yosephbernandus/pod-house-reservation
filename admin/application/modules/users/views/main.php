    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Users </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('users');?>"><i class="fa fa-user"></i> Users</a>
                </li>
                <li>
                    <a href="#">Tables</a>
                </li>
                <li class="active">Users</li>
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
                                <table class="table table-bordered table-striped" id="users">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>   
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>Email</th>
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
                                <h3 class="box-title">Form Add Username</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form name="<?php echo $form_name;?>" action="<?php echo site_url('users/ajax_add');?>" method="POST" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Username</label> <input class="form-control" placeholder="Username" name="user" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label> <input class="form-control" placeholder="Password" name="password" type="password" >
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label> <input class="form-control" placeholder="Email" name="email" type="email" >
                                    </div>
                                    <div class="form-group">
                                        <label>Level</label>
                                        <select name="level" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                          <option value="admin" selected="selected">admin</option>
                                          <option value="user">user</option>
                                      </select>
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