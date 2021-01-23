window.datepickerConfig = datepickerConfig = {
    yearStart: (new Date()).getFullYear() - 2,
    yearEnd: (new Date()).getFullYear(),
    timepicker: false,
    format: 'd-m-Y',
}

window.datetimepickerConfig = datetimepickerConfig = {
    yearStart: (new Date()).getFullYear() - 2,
    yearEnd: (new Date()).getFullYear(),
    format: 'd-m-Y H:i',
    step: 30,
}

$(document).ready(function () {
    $(".readonly").keydown(function(e){
        e.preventDefault();
    });

    //Initialize Validator Elements
    $('form:not(.non-validate)').validate({
        errorElement: "em",

        // For hide message...
        //errorPlacement: function(error, element) {},

        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }

            //Place error after div where use class (.input-group)
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".form-group" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).parents( ".form-group" ).addClass( "has-success" ).removeClass( "has-error" );
        },
    });

    //Initialize Select2 Elements
    $('.select2').select2();


    //Initialize JQuery Datetimepicker
    $('.datepicker').datetimepicker(datepickerConfig);
    $('.datetimepicker').datetimepicker(datetimepickerConfig);
});
