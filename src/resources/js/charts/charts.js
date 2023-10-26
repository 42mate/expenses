const axios = require('axios').default;
require('chart.js');
import 'chartjs-plugin-colorschemes';
import { Aspect6 } from 'chartjs-plugin-colorschemes/src/colorschemes/colorschemes.office';

// type="pie"
//
var currentPieChart = null;

$(document).ready(function() {
  $('canvas.chart').each(function(i, e) {
    var ctx = e.getContext('2d');
    var $e = $(e);

    var apiDataSource = $e.attr('data');

    axios.get(apiDataSource)
        .then(function(response) {
          var chart = new Chart(ctx, {
            type: $e.attr('type'),
            data: response.data.data,

            options: {
              legend: {
                display: $e.attr('show_legend')
              },
              plugins: {
                colorschemes: {
                  scheme: Aspect6
                }
              }
            }
          });
        });
  });

  $('.categoryPie').each(function(i, e) {
      var currencyDropDown = $("select[name=currency_id]", e);
      var chart = $(".pie", e)[0];

      function drawChart() {
          const currency_id = currencyDropDown.val();

          if (currentPieChart !== null) {
              currentPieChart.destroy();
          }
          var ctx = chart.getContext('2d');
          var apiDataSource = $(chart).attr('data') + '?currency_id=' + currency_id;

          $('.result-message').hide();
          axios.get(apiDataSource)
              .then(function(response) {
                  if (response.data.data.datasets[0].data.length == 0) {
                      $('.result-message').html('There is no expenses for this currency').fadeIn(300);
                  } else {
                      currentPieChart = new Chart(ctx, {
                          type: 'pie',
                          data: response.data.data,

                          options: {
                              legend: {
                                  display: $(chart).attr('show_legend')
                              },
                              plugins: {
                                  colorschemes: {
                                      scheme: Aspect6
                                  }
                              }
                          }
                      });
                  }
              });
      }

      currencyDropDown.on('change', function(e2) {
          drawChart();
      });

      drawChart();
  });
});
