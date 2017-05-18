$(function() {
  $sql = "SELECT NAME, PRIME FROM DEPARTMENT";
    registered_table =
        $('#Btable').DataTable({
            "responsive": true,
            "scrollCollapse": true,
            "displayLength": 20,
            "paginate": true,
            "lengthChange": true,
            "processing": false,
            "serverSide": false,
            "ajax": {
                url: 'ajax/search_registered_ajax.php',
                type: 'POST',
                data: function (d) {
                    d.oper = "registered"
                },
                dataType: 'json'
            },
            "columns": [
              { "name": "name" },
              { "name": "letter_no" },
              { "name": "receive_date" },
              { "name": "room_code" },
              { "name": "dept_code" },
            ]
        });
});
