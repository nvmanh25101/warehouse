import './bootstrap';
import jQuery from 'jquery';
import swal from 'sweetalert2';
import DataTable from 'datatables.net-dt';

import.meta.glob([
    '../images/**',
    '../fonts/**',
    '../css/**',
    './**',
]);

window.$ = jQuery;
window.Swal = swal;
window.DataTable = DataTable;
