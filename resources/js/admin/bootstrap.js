window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// Datatables Dependency
import jsZip from 'jszip/dist/jszip';

window.JSZip = jsZip;

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('jquery-ui-dist/jquery-ui');
    require('bootstrap');
    require('chart.js');
    require('sparklines');
    require('jqvmap-novulnerability');
    require('jquery-knob-chif');
    require('moment');
    require('jquery-datetimepicker');
    require('summernote');
    require('overlayScrollbars');

    require('datatables.net');
    require('datatables.net-bs4');
    require('datatables.net-responsive-bs4');
    require('datatables.net-buttons');
    require('datatables.net-buttons/js/buttons.colVis');
    require('datatables.net-buttons/js/buttons.flash');
    require('datatables.net-buttons/js/buttons.html5');
    require('datatables.net-buttons/js/buttons.print');
    require('datatables.net-buttons-bs4');
    // require('tempusdominus-bootstrap-4');
    require('jquery-validation');
    require('select2');
    require('admin-lte');
} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

$('.applyDataTable').DataTable({
    paging: false,
    dom: 'tB',
    buttons: [
        {
            extend: 'copy',
            footer: true,
            exportOptions: {
                //columns: [':visible :not(:last-child)']
                columns: ':visible:not(.not-export-col)'
            }
        },
        {
            extend: 'excel',
            footer: true,
            exportOptions: {
                //columns: [':visible :not(:last-child)']
                columns: ':visible:not(.not-export-col)'
            }
        },
        {
            extend: 'pdf',
            footer: true,
            exportOptions: {
                //columns: [':visible :not(:last-child)']
                columns: ':visible:not(.not-export-col)'
            }
        },
        {
            extend: 'print',
            footer: true,
            exportOptions: {
                //columns: [':visible :not(:last-child)']
                columns: ':visible:not(.not-export-col)'
            }
        }
    ]
    /*buttons: [
        'copy', 'excel', 'pdf', 'print'
    ]*/
});
