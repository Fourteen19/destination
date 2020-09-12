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
///////////////////
/////////////////// 

require('admin-lte/plugins/jszip/jszip'); 
require('admin-lte/plugins/datatables-buttons/js/buttons.html5'); 
require('admin-lte/plugins/datatables-buttons/js/buttons.print'); 


//require('./tinymce_config.js');


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});