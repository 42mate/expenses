var dataTableInit = function () {
  var tableFormat = 'Bfrtip';

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

}

var getColumns = function(table) {
  var columns = table.attr('columns').split(',');
  var linkeable = table.attr('linkeable').split(',');

  var objColumns = [];

  var makeLink = function (nTd, sData, oData, iRow, iCol) {
    var uri = linkeable[1].replace('%id', oData.id);
    $(nTd).html("<a href='" + uri + "'>" + oData.date + "</a>");
  }

  columns.forEach(function(element) {
      var entry = {
        data: element,
        name: element
      };

      if (element === linkeable[0]) {
        entry.fnCreatedCell = makeLink;
      }
      objColumns.push(entry);
  });

  return objColumns;
}

var dataTableAjaxInit = function () {
  var tableFormat = 'Bfrtip';

  $('.data-table-ajax').each(function(i, jtable) {
    var jtable = $(jtable);

    var columns = getColumns(jtable);

    var table = jtable.DataTable({
      dom: tableFormat,
      buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
      ],
      "pageLength": 50,
      "order": [],
      "processing": true,
      "serverSide": true,
      "ajax": jtable.attr('endpoint'),
      columns: columns,
    });

  });

};

var dataTableSimple = function () {
  var tableFormat = 't';

  var table = $('.data-table-simple').DataTable({
    dom: tableFormat,
    "order": []
  });
}


$(document).ready(function() {
  dataTableInit();
  dataTableAjaxInit();
  dataTableSimple();
});
