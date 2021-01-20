window.readURL = function (input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img_preview')
                .attr('src', e.target.result)
                .width(215)
                .height(215);
        };

        //$("#img_preview").css("border","2px solid #999");
        reader.readAsDataURL(input.files[0]);
    }
}

/*bootstrap modal dismiss in html page.*/
window.dismissModal = function () {
    setTimeout(function () {
        $('.modal').remove();
    }, 500);
}

/*bootstrap Alert modal.*/
window.alerts = function (msg) {
    $('<div class="modal fade" id="myModal" role="dialog">' +
        '<div class="modal-dialog">' +
        '<div class="modal-content">' +
        '<div class="modal-header">' +
        '<button type="button" class="close" data-dismiss="modal" onclick="dismissModal()">&times;</button>' +
        '<h4 class="modal-title">System Alert.</h4>' +
        '</div>' +

        '<div class="modal-body"><p>' + msg + '</p></div>' +
        '</div>' +
        '</div>' +
        '</div>').modal();
}

/*bootstrap delete modal.*/
window.deleted = function (url) {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $('<div class="modal fade" id="myModal" role="dialog">' +
        '<div class="modal-dialog">' +
        '<div class="modal-content">' +
        '<div class="modal-header">' +
        '<h4 class="modal-title">System Alert.</h4>' +
        '<button type="button" class="close" data-dismiss="modal" onclick="dismissModal()">&times;</button>' +
        '</div>' +

        '<div class="modal-body"><p>Are you sure to delete this row?</p></div>' +

        '<div class="modal-footer">' +
        '<form method="POST" action="' + url + '">' +
        '<input name="_method" type="hidden" value="DELETE">' +
        '<input name="_token" type="hidden" value="' + csrf_token + '">' +
        '<button type="submit" class="btn btn-success btn-flat mr-1">Yes</button>' +
        '<button type="button" class="btn btn-warning btn-flat" data-dismiss="modal" onclick="dismissModal(\'deleteModal\')">No</button>' +
        '</form>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>').modal();
}

/*bootstrap status modal.*/
window.activity = function (url, msg) {
    msg = (msg !== undefined) ? msg : 'Are you sure to change status this row?';

    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $('<div class="modal fade" id="activeModal" role="dialog">' +
        '<div class="modal-dialog">' +
        '<div class="modal-content">' +
        '<div class="modal-header">' +
        '<button type="button" class="close" data-dismiss="modal" onclick="dismissModal(\'activeModal\')">&times;</button>' +
        '<h4 class="modal-title">System Alert.</h4>' +
        '</div>' +

        '<div class="modal-body"><p>' + msg + '</p></div>' +

        '<div class="modal-footer">' +
        '<form method="POST" action="' + url + '">' +
        '<input name="_method" type="hidden" value="PUT">' +
        '<input name="_token" type="hidden" value="' + csrf_token + '">' +
        '<button type="submit" class="btn btn-success btn-flat">Yes</button>' +
        '<button type="button" class="btn btn-warning btn-flat" data-dismiss="modal" onclick="dismissModal()">No</button>' +
        '</form>' +
        '</div>' +
        '</div>' +
        '</form>' +
        '</div>' +
        '</div>').modal();
}
