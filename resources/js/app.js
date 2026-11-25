// jQuery
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

// Bootstrap
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Bootstrap Datepicker
import 'bootstrap-datepicker';

// Bootstrap Datetimepicker
import 'bootstrap-datetime-picker';

// DataTables BS4
import DataTable from 'datatables.net-bs4';
DataTable.use(jQuery);
window.DataTable = DataTable;

// DataTables Responsive BS4
import 'datatables.net-responsive-bs4';

// Select2
import select2 from 'select2';
select2(jQuery);

// SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// Custom
import './_custom';
