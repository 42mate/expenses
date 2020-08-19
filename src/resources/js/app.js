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


//Demo for Data Table
$(document).ready(function() {

  $.fn.dataTable.ext.search.push(function(settings, data, dataIndex){
      var category = $('#dpFilterCategory').val();

      if (category === '') {
        return true;
      }

      if (data[1] === category) {
        return true;
      }
      return false;
  });

  $.fn.dataTable.ext.search.push(function(settings, data, dataIndex){
    var date = $('#dpFilterDate').val();

    if (date === '') {
      return true;
    }

    if (data[0].trim()  === date) {
      return true;
    }
    return false;
  });

  var table = $('.data-table').DataTable({
    dom: 'Brtip',
    buttons: [
      'copyHtml5',
      'excelHtml5',
      'csvHtml5',
      'pdfHtml5',
    ],
    "order" : []
  });

  $('#dpFilterSearch').keyup(function(){
    table.search($(this).val()).draw() ;
  })

  $('#dpFilterCategory').change( function() {
    table.draw();
  } );

  $('#dpFilterDate').change( function() {
    table.draw();
  } );
});

window.Vue = require('vue');