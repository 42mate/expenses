/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap');
require('./sb-admin-2');
require('chart.js');
require('./charts/charts');


var dataTableInit = function () {
  var filterCategory = $('#dpFilterCategory');
  var filterDate = $('#dpFilterDate');
  var filterSearch = $('#dpFilterSearch');

  var tableFormat = 'Brtip';

  if (filterSearch.length == 0) {
    tableFormat = 'Bfrtip';
  }

  var table = $('.data-table').DataTable({
    dom: tableFormat,
    buttons: [
      'copyHtml5',
      'excelHtml5',
      'csvHtml5',
      'pdfHtml5',
    ],
    "pageLength": 50,
    "order": []
  });



  if (filterCategory.length > 0) {
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
      var category = filterCategory.val();

      if (category === '') {
        return true;
      }

      if (data[1] === category) {
        return true;
      }
      return false;
    });

    filterCategory.change(function () {
      table.draw();
    });
  }


  if (filterDate.length > 0) {
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
      var date = filterDate.val();

      if (date === '') {
        return true;
      }

      if (data[0].trim() === date) {
        return true;
      }
      return false;
    });

    filterDate.change(function () {
      table.draw();
    });
  }

  if (filterSearch.length > 0) {
    filterSearch.keyup(function () {
      table.search($(this).val()).draw();
    });
  }
}

//Demo for Data Table
$(document).ready(function() {
  dataTableInit();
});

window.Vue = require('vue');