    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Invoice <small>#<?php echo $arr_reservasi->id_reservasi;?></small></h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('reservasi');?>"><i class="fa fa-sticky-note"></i> Reservasi</a>
                </li>
                <li>
                    <a href="#">Form</a>
                </li>
                <li class="active">Invoice</li>
            </ol>
        </section>
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header"><i class="fa fa-globe"></i> Pod House, Inc. <small class="pull-right">Date: <?php echo $arr_reservasi->input_date;?></small></h2>
                </div><!-- /.col -->
            </div><!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong><?php echo $arr_reservasi->guest_name;?>.</strong><br>
                        <?php echo $arr_reservasi->company;?><br>
                        <?php echo $arr_reservasi->province;?>, <?php echo $arr_reservasi->country;?><br>
                        Phone: <?php echo $arr_reservasi->telp;?><br>
                        Email: <?php echo $arr_reservasi->email;?>
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>Manado Pod House</strong><br>
                        Jl. Piere Tendean No. 35, Manado 95111<br>
                        Sulawesi Utara, Indonesia<br>
                        Phone: (555) 539-1037<br>
                        Email: john.doe@example.com
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Invoice #<?php echo $arr_reservasi->id_reservasi;?></b><br>
                    <br>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Days</th>
                                <th>Room</th>
                                <th>Check In Date</th>
                                <th>Check Out Date</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Breakfast</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <?php foreach ($arr_detail as $row): ?>
                        <tbody>
                            <tr>
                                <td><?php echo $row->jumlah;?></td>
                                <td><?php echo $row->selisih;?></td>
                                <td><?php echo $row->nama_room;?></td>
                                <td><?php echo $row->check_in;?></td>
                                <td><?php echo $row->check_out;?></td>
                                <td><?php echo "Rp.", number_format($row->harga, 0, ".", ".");?></td>
                                <td><?php echo $row->diskon;?>%</td>
                                <td><?php echo $row->breakfast;?></td>
                                <td><?php echo "Rp.", number_format($row->total, 0, ".", ".");?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">
                    <p class="lead">Detail:</p>
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">Thank You For Reservation</p>
                </div><!-- /.col -->
                <div class="col-xs-6">
                    
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Total:</th>
                                <td><?php echo "Rp.", number_format($total, 0, ".", ".");?></td>
                            </tr>
                        </table>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                     <a style="margin-right: 5px;" href="<?php echo site_url('reservasi/report/'.$arr_reservasi->id_reservasi);?>" class="btn btn-primary pull-right"><i class="fa fa-download"></i> Generate PDF</a>
                </div>
            </div>
        </section><!-- /.content -->
        <div class="clearfix"></div>
    </div>