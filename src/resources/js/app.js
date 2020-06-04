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
  $('.data-table').DataTable({
    "order" : [],
    responsive: false,
  });
});

window.Vue = require('vue');