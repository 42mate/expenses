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

window.Vue = require('vue');

Vue.component('tags-input', require('./vue/components/tags.vue').default);

const app = new Vue({
  el: '#wrapper',
});

//Used for recurrent payments in create expense
$('.fill-expense').click(function(e) {
    var recurrent = $(e.target).data('expense');
    $('form input[name=amount]').val(recurrent.amount);
    $('form input[name=description]').val(recurrent.description);
    $('form select[name=category_id]').val(recurrent.category_id);
    $('form input[name=recurrent_expense_id]').val(recurrent.id);
    $('.sidepanel').toggleClass('active');
});

$(document).ready(function () {

    $('.sidebarCollapse').on('click', function () {
        $('.sidepanel').toggleClass('active');
    });

});
