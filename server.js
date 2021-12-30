var socket = require('socket.io');
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = socket.listen(server);
var port = process.env.PORT || 3000;

server.listen(port, function() {
    console.log('Server listening at port %d', port);
});


io.on('connection', function(socket) {
    socket.on('new_visitor', function(data) {
        return '<p>User Connected </p>';
    })

    socket.on('out_visitor', function(data) {
        return '<p>User Disconnected </p>';
    })

    socket.on('new_count_message', function(data) {
        io.sockets.emit('new_count_message', {
            new_count_message: data.new_count_message

        });
    });

    socket.on('update_count_message', function(data) {
        io.sockets.emit('update_count_message', {
            update_count_message: data.update_count_message
        });
    });

    socket.on('new_message', function(data) {
        io.sockets.emit('new_message', {
            nama: data.nama,
            email: data.email,
            telp: data.telp,
            pesan: data.pesan,
            id: data.id
        });
    });

    socket.on('new_reservasi_message', function(data) {
        io.sockets.emit('new_reservasi_message', {
            new_reservasi_message: data.new_reservasi_message
        });
    });

    socket.on('update_reservasi_message', function(data) {
        io.sockets.emit('update_reservasi_message', {
            update_reservasi_message: data.update_reservasi_message
        });
    });

    socket.on('new_reservasi', function(data) {
        io.sockets.emit('new_reservasi', {
            id_reservasi: data.id_reservasi,
            guest_name: data.guest_name,
            email: data.email,
            telp: data.telp,
            id: data.id
        })
    })
});