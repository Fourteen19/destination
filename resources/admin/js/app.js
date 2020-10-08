require('./bootstrap'); 
require('admin-lte');
 
require('admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4'); 

require('admin-lte/plugins/datatables-responsive/js/dataTables.responsive');
 
//Export button
require('admin-lte/plugins/datatables-buttons/js/dataTables.buttons');
require('admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4'); 
require('admin-lte/plugins/datatables-buttons/js/buttons.colVis'); 
require('admin-lte/plugins/datatables-buttons/js/buttons.flash'); 


///////////////////
/// PDF generator for yajra datatable
/// Triggers PDFs when the PDF button is clicked above Yajra datatables
///
window.pdfMake = require('pdfmake/build/pdfmake.js');
var vfs = require('pdfmake/build/vfs_fonts');
window.pdfMake.vfs = vfs.pdfMake.vfs;
////////////////////
/////////////////// 

require('admin-lte/plugins/jszip/jszip'); 
require('admin-lte/plugins/datatables-buttons/js/buttons.html5'); 
require('admin-lte/plugins/datatables-buttons/js/buttons.print'); 


//input masks for dates
require('admin-lte/plugins/moment/moment.min.js');
require('admin-lte/plugins/inputmask/jquery.inputmask.min.js');


//require('./tinymce_config.js');