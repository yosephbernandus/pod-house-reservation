$(document).ready(function() {
    
    $(document).on("click", ".detail-message", function() {

        var dataString = {
            id: $(this).attr('id')
        };
        console.log(dataString);
        $.ajax({
            type: "POST",
            url: base_url + "guestbook/notif_reply",
            data: dataString,
            dataType: "json",
            cache: false,
            success: function(data) {
                console.log(data);
                if (data.success == true) {
                    var socket = io.connect('http://' + window.location.hostname + ':3000');
                    socket.emit('update_count_message', {
                        update_count_message: data.update_count_message
                    });
                    window.location = data.redirect; 
                }
            },
            error: function(xhr, status, error) {
                alert(error);
            },
        });
    });

    $(document).on("click", ".detail-reservasi", function() {

        var dataString = {
            id: $(this).attr('id')
        };
        console.log(dataString);
        $.ajax({
            type: "POST",
            url: base_url + "reservasi/notif_reservasi",
            data: dataString,
            dataType: "json",
            cache: false,
            success: function(data) {
                console.log(data);
                if (data.success == true) {
                    var socket = io.connect('http://' + window.location.hostname + ':3000');
                    socket.emit('update_reservasi_message', {
                        update_reservasi_message: data.update_reservasi_message
                    });
                    window.location = data.redirect; 
                }
            },
            error: function(xhr, status, error) {
                alert(error);
            },
        });
    });
});

var socket = io.connect('http://' + window.location.hostname + ':3000');
socket.on('new_count_message', function(data) {
    $(".new_count_message").html(data.new_count_message);
    $(".new_count_message_2").html('You have ' + data.new_count_message + ' messages');
    $('.notif_audio')[0].play();
});

socket.on('new_visitor', function(data){
    console.log('user connect');
});

socket.on('update_count_message', function(data) {
    $(".new_count_message").html(data.update_count_message);
});

socket.on('new_message', function(data) {
    notifyMe(data.nama, data.pesan);
    $(".message-tbody").prepend('<li><a style="cursor:pointer" class="detail-message" id="' + data.id + '">' + '<h4>' + data.nama + '</h4>' + '<p>' + data.pesan + '</p></a></li>');
    $(".no-message-notif").html('');
    $(".new-message-notif").html('<div class="alert alert-success" role="alert"> <i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>New message ...</div>');
});

socket.on('new_reservasi_message', function(data) {
    $('.new_reservasi_message').html(data.new_reservasi_message);
    $('.notif_audio')['0'].play();
    $(".new_reservasi_message_2").html('You have ' + data.new_reservasi_message + ' reservation');
});

socket.on('update_reservasi_message', function(data) {
    $('.new_reservasi_message').html(data.new_reservasi_message);
});

socket.on('new_reservasi', function(data){
    notifyReservasi(data.id_reservasi, data.guest_name);
    $('.reservasi-tbody').prepend('<li><a style="cursor:pointer" class="detail-reservasi" id="' + data.id_reservasi + '">' + '<h4>' + data.id_reservasi + '</h4>' + '<p>' + data.guest_name + '</p></a></li>');
    $(".no-reservasi-notif").html('');
    $(".new-reservasi-notif").html('<div class="alert alert-success" role="alert"> <i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>New message ...</div>');
});

function notifyMe(nama, pesan) {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }
    // Let's check if the user is okay to get some notification
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var options = {
            body: pesan,
            dir: "ltr"
        };
        var notification = new Notification(nama, options);
        notification.onclick = function () {
            window.open("http://dev.karyampat.net/manadopodhouse/admin/");
        };
    }
    // Otherwise, we need to ask the user for permission
    // Note, Chrome does not implement the permission static property
    // So we have to check for NOT 'denied' instead of 'default'
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function(permission) {
            // Whatever the user answers, we make sure we store the information
            if (!('permission' in Notification)) {
                Notification.permission = permission;
            }
            // If the user is okay, let's create a notification
            if (permission === "granted") {
                var options = {
                    body: pesan,
                    dir: "ltr"
                };
                var notification = new Notification(nama + " New Message ", options);
                notification.onclick = function () {
                    window.open("http://dev.karyampat.net/manadopodhouse/admin/");
                };
            }
        });
    }
    // At last, if the user already denied any notification, and you
    // want to be respectful there is no need to bother them any more.
}

function notifyReservasi(id_reservasi, guest_name) {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }
    // Let's check if the user is okay to get some notification
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var options = {
            body: guest_name,
            dir: "ltr"
        };
        var notification = new Notification(id_reservasi, options);
        notification.onclick = function () {
            window.open("http://dev.karyampat.net/manadopodhouse/admin/");
        };
    }
    // Otherwise, we need to ask the user for permission
    // Note, Chrome does not implement the permission static property
    // So we have to check for NOT 'denied' instead of 'default'
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function(permission) {
            // Whatever the user answers, we make sure we store the information
            if (!('permission' in Notification)) {
                Notification.permission = permission;
            }
            // If the user is okay, let's create a notification
            if (permission === "granted") {
                var options = {
                    body: guest_name,
                    dir: "ltr"
                };
                var notification = new Notification(id_reservasi + " New Message ", options);
                notification.onclick = function () {
                    window.open("http://dev.karyampat.net/manadopodhouse/admin/");
                };
            }
        });
    }
    // At last, if the user already denied any notification, and you
    // want to be respectful there is no need to bother them any more.
}

function requestNotifikasi(){
    Notification.requestPermission().then(function(result){
        if (result === 'denied') {
            console.log('Permission wasn\'t granted. Allow a retry.');
            return;
        }

        if (result === 'default') {
            console.log('The permission request was dismissed.');
            return;
        }

        if (result === 'granted') {
            alert('Permission has been granted');
            return;
        }
    });
}