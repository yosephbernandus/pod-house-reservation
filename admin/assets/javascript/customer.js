function nyandaBisaKlik(a) {
    $(a).click(function(e) {
        e.stopPropagation();
        e.preventDefault();
        e.stopImmediatePropagation();

        return false;
    });

    $(a).bind('contextmenu', function(e) {
        e.stopPropagation();
        e.preventDefault();
        e.stopImmediatePropagation();
        return false;
    });
}

function bisaKlik(a) {
    $(a).unbind('click');
    $(a).unbind('contextmenu');
}

$(function () {
    var t = $('#customer').DataTable( {
        "ajax": site_url + "customer/data",
        "order": [[ 2, 'desc']],
        "columns": [
        {"data": "id"},
        {"data": "guest_name"},
        {"data": "province"},
        {"data": "country"},
        {"data": "company"},
        {"data": "telp"},
        {"data": "email"},
        {"data": "status"},
        {"data": "input_date"}
        ],
    });

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
})