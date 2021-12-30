    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Testimony </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('testimoni');?>"><i class="fa fa-user-circle"></i> Testimony</a>
                </li>
                <li>
                    <a href="#">Tables</a>
                </li>
                <li class="active">Testimony</li>
            </ol>
        </section><!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div class="new-message-notif"></div>
                            <table class="table table-hover">
                                <div id="load">Please wait ...</div>
                                <audio class="notif_audio"><source src="<?php echo base_url('../sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('../sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('../sounds/notify.wav');?>" type="audio/wav"></audio>
                                <tbody class="message-tbody">
                                    <?php
                                    if($message->num_rows() > 0){

                                        foreach($message->result() as $row){

                                          ?>

                                          <tr>
                                            <td><?php echo $row->name;?></td>
                                            <td><?php echo $row->email;?></td>
                                            <td><?php echo $row->subject;?></td>
                                            <td><?php echo $row->created_at;?></td>
                                            <td><a style="cursor:pointer" data-toggle="modal" data-target=".bs-example-modal-sm" class="detail-message" id="<?php echo $row->id;?>"><span class="glyphicon glyphicon-search"></span></a></td>
                                        </tr>
                                        <?php

                                    }


                                } else {

                                    ?>

                                    <tr class="no-message-notif">
                                      <td colspan="5" align="center"><div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="sr-only"></span> No message</div>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>

    <script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js');?>"></script>
<script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('../node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>
<script>
  $(document).ready(function(){

    $("#load").hide();

    $(document).on("click",".detail-message",function() {

      $( "#load" ).show();

      var dataString = { 
        id : $(this).attr('id')
      };

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('message/detail');?>",
        data: dataString,
        dataType: "json",
        cache : false,
        success: function(data){

          $( "#load" ).hide();

          if(data.success == true){

            $("#show_name").html(data.name);
            $("#show_email").html(data.email);
            $("#show_subject").html(data.subject);
            $("#show_message").html(data.message);

            var socket = io.connect( 'http://'+window.location.hostname+':3000' );
            
            socket.emit('update_count_message', { 
              update_count_message: data.update_count_message
            });
          }     
        } ,error: function(xhr, status, error) {
          alert(error);
        },
      });
    });
  });

  var socket = io.connect( 'http://'+window.location.hostname+':3000' );

  socket.on( 'new_count_message', function( data ) {

    $( ".new_count_message" ).html( data.new_count_message );
    $('.notif_audio')[0].play();
  });

  socket.on( 'update_count_message', function( data ) {
    $( ".new_count_message" ).html( data.update_count_message );
  });

  socket.on( 'new_message', function( data ) {
    notifyMe(data.name, data.subject);
    $( ".message-tbody" ).prepend('<tr><td>'+data.name+'</td><td>'+data.email+'</td><td>'+data.subject+'</td><td>'+data.created_at+'</td><td><a style="cursor:pointer" data-toggle="modal" data-target=".bs-example-modal-sm" class="detail-message" id="'+data.id+'"><span class="glyphicon glyphicon-search"></span></a></td></tr>');
    $( ".no-message-notif" ).html('');
    $( ".new-message-notif" ).html('<div class="alert alert-success" role="alert"> <i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>New message ...</div>');
  });

  function notifyMe(name,subject) {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
      alert("This browser does not support desktop notification");
    }

    // Let's check if the user is okay to get some notification
    else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    var options = {
      body: subject,
      dir : "ltr"
    };
    var notification = new Notification(name + " New Message ",options);
  }

    // Otherwise, we need to ask the user for permission
    // Note, Chrome does not implement the permission static property
    // So we have to check for NOT 'denied' instead of 'default'
    else if (Notification.permission !== 'denied') {
      Notification.requestPermission(function (permission) {
            // Whatever the user answers, we make sure we store the information
            if (!('permission' in Notification)) {
              Notification.permission = permission;
            }

            // If the user is okay, let's create a notification
            if (permission === "granted") {
              var options = {
                body: subject,
                dir : "ltr"
              };
              var notification = new Notification(name + " New Message ",options);
            }
          });
    }
    // At last, if the user already denied any notification, and you
    // want to be respectful there is no need to bother them any more.
  }

</script>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">✕</button>
        <h4>Detail Message</h4>
      </div>
      
      <div class="modal-body" style="text-align:center;">
        <div class="row-fluid">
         <div class="span10 offset1">
           <div id="modalTab">
             <div class="tab-content">
               <div class="tab-pane active" id="about">

                <center>
                 <p class="text-left">
                  <b>Name</b> : <span id="show_name"></span><br />
                  <b>Email</b> : <span id="show_email"></span><br />
                  <b>Subject</b> : <span id="show_subject"></span><br />
                  <b>Message</b> : <span id="show_message"></span><br />
                </p>
                <br>
              </center>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
