const axios = require('axios').default;
require('chart.js');

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
              }
            }
          });
        });

  });
});