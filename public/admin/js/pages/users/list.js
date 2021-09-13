/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is not neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/*!************************************************!*\
  !*** ./resources/admin/js/pages/users/list.js ***!
  \************************************************/
/*! unknown exports (runtime-defined) */
/*! runtime requirements:  */
eval("$(document).on('click', '.open-delete-modal', function () {\n  modal_update_action_button_text(\"Delete\");\n  modal_add_class_action_button_text('btn-danger');\n  modal_add_class_action_button_text('delete');\n  modal_update_title('Delete User?');\n  modal_update_body(\"Are you sure you want to delete this user?\");\n  modal_update_data_id($(this).data('id'));\n  $('#confirm_modal').modal('show');\n});\n$.ajaxSetup({\n  headers: {\n    'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')\n  }\n});\n$('.modal-footer').on('click', '.delete', function () {\n  modal_update_processing_message(\"Processing...\");\n  modal_disable_action_button();\n  $.ajax({\n    type: 'POST',\n    url: 'users/' + $('#data_id').text(),\n    data: {\n      '_method': 'DELETE'\n    },\n    dataType: 'json',\n    success: function success(data) {\n      modal_update_result_message(data.message);\n\n      if (data.result) {\n        $('#user_table').DataTable().draw(false);\n      }\n    },\n    error: function error(data) {\n      modal_update_result_message(\"An error occured. Please try again later\");\n    },\n    complete: function complete(data) {\n      modal_close();\n    }\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9jb3JwLXBsYXRmb3JtLy4vcmVzb3VyY2VzL2FkbWluL2pzL3BhZ2VzL3VzZXJzL2xpc3QuanM/ZjZkMiJdLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJvbiIsIm1vZGFsX3VwZGF0ZV9hY3Rpb25fYnV0dG9uX3RleHQiLCJtb2RhbF9hZGRfY2xhc3NfYWN0aW9uX2J1dHRvbl90ZXh0IiwibW9kYWxfdXBkYXRlX3RpdGxlIiwibW9kYWxfdXBkYXRlX2JvZHkiLCJtb2RhbF91cGRhdGVfZGF0YV9pZCIsImRhdGEiLCJtb2RhbCIsImFqYXhTZXR1cCIsImhlYWRlcnMiLCJhdHRyIiwibW9kYWxfdXBkYXRlX3Byb2Nlc3NpbmdfbWVzc2FnZSIsIm1vZGFsX2Rpc2FibGVfYWN0aW9uX2J1dHRvbiIsImFqYXgiLCJ0eXBlIiwidXJsIiwidGV4dCIsImRhdGFUeXBlIiwic3VjY2VzcyIsIm1vZGFsX3VwZGF0ZV9yZXN1bHRfbWVzc2FnZSIsIm1lc3NhZ2UiLCJyZXN1bHQiLCJEYXRhVGFibGUiLCJkcmF3IiwiZXJyb3IiLCJjb21wbGV0ZSIsIm1vZGFsX2Nsb3NlIl0sIm1hcHBpbmdzIjoiQUFBQUEsQ0FBQyxDQUFDQyxRQUFELENBQUQsQ0FBWUMsRUFBWixDQUFlLE9BQWYsRUFBd0Isb0JBQXhCLEVBQThDLFlBQVc7QUFDckRDLEVBQUFBLCtCQUErQixDQUFDLFFBQUQsQ0FBL0I7QUFDQUMsRUFBQUEsa0NBQWtDLENBQUMsWUFBRCxDQUFsQztBQUNBQSxFQUFBQSxrQ0FBa0MsQ0FBQyxRQUFELENBQWxDO0FBQ0FDLEVBQUFBLGtCQUFrQixDQUFDLGNBQUQsQ0FBbEI7QUFDQUMsRUFBQUEsaUJBQWlCLENBQUMsNENBQUQsQ0FBakI7QUFDQUMsRUFBQUEsb0JBQW9CLENBQUNQLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUVEsSUFBUixDQUFhLElBQWIsQ0FBRCxDQUFwQjtBQUNBUixFQUFBQSxDQUFDLENBQUMsZ0JBQUQsQ0FBRCxDQUFvQlMsS0FBcEIsQ0FBMEIsTUFBMUI7QUFDSCxDQVJEO0FBVUFULENBQUMsQ0FBQ1UsU0FBRixDQUFZO0FBQ1JDLEVBQUFBLE9BQU8sRUFBRTtBQUNMLG9CQUFnQlgsQ0FBQyxDQUFDLHlCQUFELENBQUQsQ0FBNkJZLElBQTdCLENBQWtDLFNBQWxDO0FBRFg7QUFERCxDQUFaO0FBTUFaLENBQUMsQ0FBQyxlQUFELENBQUQsQ0FBbUJFLEVBQW5CLENBQXNCLE9BQXRCLEVBQStCLFNBQS9CLEVBQTBDLFlBQVc7QUFFakRXLEVBQUFBLCtCQUErQixDQUFDLGVBQUQsQ0FBL0I7QUFDQUMsRUFBQUEsMkJBQTJCO0FBRTNCZCxFQUFBQSxDQUFDLENBQUNlLElBQUYsQ0FBTztBQUNIQyxJQUFBQSxJQUFJLEVBQUUsTUFESDtBQUVIQyxJQUFBQSxHQUFHLEVBQUUsV0FBU2pCLENBQUMsQ0FBQyxVQUFELENBQUQsQ0FBY2tCLElBQWQsRUFGWDtBQUdIVixJQUFBQSxJQUFJLEVBQUU7QUFDRixpQkFBWTtBQURWLEtBSEg7QUFNSFcsSUFBQUEsUUFBUSxFQUFFLE1BTlA7QUFPSEMsSUFBQUEsT0FBTyxFQUFFLGlCQUFTWixJQUFULEVBQWU7QUFFcEJhLE1BQUFBLDJCQUEyQixDQUFDYixJQUFJLENBQUNjLE9BQU4sQ0FBM0I7O0FBRUEsVUFBSWQsSUFBSSxDQUFDZSxNQUFULEVBQWdCO0FBQ1p2QixRQUFBQSxDQUFDLENBQUMsYUFBRCxDQUFELENBQWlCd0IsU0FBakIsR0FBNkJDLElBQTdCLENBQWtDLEtBQWxDO0FBQ0g7QUFDSixLQWRFO0FBZUhDLElBQUFBLEtBQUssRUFBRSxlQUFTbEIsSUFBVCxFQUFlO0FBQ2xCYSxNQUFBQSwyQkFBMkIsQ0FBQywwQ0FBRCxDQUEzQjtBQUNILEtBakJFO0FBa0JITSxJQUFBQSxRQUFRLEVBQUUsa0JBQVNuQixJQUFULEVBQWU7QUFFckJvQixNQUFBQSxXQUFXO0FBRWQ7QUF0QkUsR0FBUDtBQXlCSCxDQTlCRCIsInNvdXJjZXNDb250ZW50IjpbIiQoZG9jdW1lbnQpLm9uKCdjbGljaycsICcub3Blbi1kZWxldGUtbW9kYWwnLCBmdW5jdGlvbigpIHtcclxuICAgIG1vZGFsX3VwZGF0ZV9hY3Rpb25fYnV0dG9uX3RleHQoXCJEZWxldGVcIik7XHJcbiAgICBtb2RhbF9hZGRfY2xhc3NfYWN0aW9uX2J1dHRvbl90ZXh0KCdidG4tZGFuZ2VyJyk7XHJcbiAgICBtb2RhbF9hZGRfY2xhc3NfYWN0aW9uX2J1dHRvbl90ZXh0KCdkZWxldGUnKTtcclxuICAgIG1vZGFsX3VwZGF0ZV90aXRsZSgnRGVsZXRlIFVzZXI/Jyk7XHJcbiAgICBtb2RhbF91cGRhdGVfYm9keShcIkFyZSB5b3Ugc3VyZSB5b3Ugd2FudCB0byBkZWxldGUgdGhpcyB1c2VyP1wiKTtcclxuICAgIG1vZGFsX3VwZGF0ZV9kYXRhX2lkKCQodGhpcykuZGF0YSgnaWQnKSk7XHJcbiAgICAkKCcjY29uZmlybV9tb2RhbCcpLm1vZGFsKCdzaG93Jyk7XHJcbn0pO1xyXG5cclxuJC5hamF4U2V0dXAoe1xyXG4gICAgaGVhZGVyczoge1xyXG4gICAgICAgICdYLUNTUkYtVE9LRU4nOiAkKCdtZXRhW25hbWU9XCJjc3JmLXRva2VuXCJdJykuYXR0cignY29udGVudCcpXHJcbiAgICB9XHJcbn0pO1xyXG5cclxuJCgnLm1vZGFsLWZvb3RlcicpLm9uKCdjbGljaycsICcuZGVsZXRlJywgZnVuY3Rpb24oKSB7XHJcblxyXG4gICAgbW9kYWxfdXBkYXRlX3Byb2Nlc3NpbmdfbWVzc2FnZShcIlByb2Nlc3NpbmcuLi5cIik7XHJcbiAgICBtb2RhbF9kaXNhYmxlX2FjdGlvbl9idXR0b24oKTtcclxuXHJcbiAgICAkLmFqYXgoe1xyXG4gICAgICAgIHR5cGU6ICdQT1NUJyxcclxuICAgICAgICB1cmw6ICd1c2Vycy8nKyQoJyNkYXRhX2lkJykudGV4dCgpLFxyXG4gICAgICAgIGRhdGE6IHtcclxuICAgICAgICAgICAgJ19tZXRob2QnIDogJ0RFTEVURScsXHJcbiAgICAgICAgfSxcclxuICAgICAgICBkYXRhVHlwZTogJ2pzb24nLFxyXG4gICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKGRhdGEpIHtcclxuXHJcbiAgICAgICAgICAgIG1vZGFsX3VwZGF0ZV9yZXN1bHRfbWVzc2FnZShkYXRhLm1lc3NhZ2UpO1xyXG5cclxuICAgICAgICAgICAgaWYgKGRhdGEucmVzdWx0KXtcclxuICAgICAgICAgICAgICAgICQoJyN1c2VyX3RhYmxlJykuRGF0YVRhYmxlKCkuZHJhdyhmYWxzZSk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9LFxyXG4gICAgICAgIGVycm9yOiBmdW5jdGlvbihkYXRhKSB7XHJcbiAgICAgICAgICAgIG1vZGFsX3VwZGF0ZV9yZXN1bHRfbWVzc2FnZShcIkFuIGVycm9yIG9jY3VyZWQuIFBsZWFzZSB0cnkgYWdhaW4gbGF0ZXJcIik7XHJcbiAgICAgICAgfSxcclxuICAgICAgICBjb21wbGV0ZTogZnVuY3Rpb24oZGF0YSkge1xyXG5cclxuICAgICAgICAgICAgbW9kYWxfY2xvc2UoKVxyXG5cclxuICAgICAgICB9XHJcbiAgICB9KTtcclxuXHJcbn0pO1xyXG4iXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2FkbWluL2pzL3BhZ2VzL3VzZXJzL2xpc3QuanMuanMiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/admin/js/pages/users/list.js\n");
/******/ })()
;